<?php

namespace App\Controller;
Use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\SecurityBundle\Security;


class HomeController extends AbstractController {

#[Route("/", name: "home")]
function index (Request $request, EntityManagerInterface $em, UserPasswordHasherInterface $hasher,Security $security): Response {

    $user = new User();
   // dd($security->getUser());
   // dd($security->getToken());

    return $this->render('home/index.html.twig');
    }
}
