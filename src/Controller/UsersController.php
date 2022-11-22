<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UsersController extends AbstractController
{
    #[Route('/users', name: 'users_index')]
    public function index(): Response
    {
        return $this->render('pages/users/index.html.twig', [
            'controller_name' => 'UsersController',
        ]);
    }
}
