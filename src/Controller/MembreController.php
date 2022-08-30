<?php

namespace App\Controller;
use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MembreController extends AbstractController
{
    #[Route('/membre', name: 'app_membre')]
    public function index(UserRepository $userRepository): Response
    {
        return $this->render('membre/index.html.twig');

    }     

}
