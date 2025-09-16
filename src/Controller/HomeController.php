<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class HomeController extends AbstractController
{
    #[Route('/home', name: 'app_home')]
    public function index(): Response
    {
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }

    #[Route('/message', name:'app_home_message')]
    public function msg(){
        return new Response('Hello 3A45');
    }

    #[Route('/message/name/{name}', name:'app_home_message_name')]
    public function msgName($name){
        return new Response('Hello 3A45 '. $name);
    }

    #[Route('/hello', name:'app_home_hello')]
    public function hello(){
        return $this->render('home/hello.html.twig');
    }

    #[Route('/hello/name/{na}', name:'app_home_hello_na')]
    public function helloNa($na){
        return $this->render('home/hello.html.twig', [ 'name' => $na ]);
    }
}
