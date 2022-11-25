<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\SuspendAccount;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

#[Route('/user', name: 'user_')]
class UserController extends AbstractController
{
    #[Route('', name: 'index')]
    public function index(): Response
    {
        return $this->render('pages/user/index.html.twig', [
            'controller_name' => 'UserController',
            'pictures' => []
        ]);
    }

    #[Route('/suspend', name: 'suspend')]
    public function suspend(
        UserRepository $userRepository,
        Request $request,
        TokenStorageInterface $tokenStorage,
    ): Response {
        $user = $this->getUser();
        $form = $this->createForm(SuspendAccount::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $userToRemove = new User();
            $userToRemove = $userRepository->find($user);
            $userRepository->remove($userToRemove, true);
            $request->getSession()->invalidate();
            $tokenStorage->setToken(null);
            return $this->redirectToRoute('home_index');
        }
        return $this->render('pages/user/suspend.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
