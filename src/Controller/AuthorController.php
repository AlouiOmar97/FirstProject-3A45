<?php

namespace App\Controller;

use App\Entity\Author;
use App\Repository\AuthorRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class AuthorController extends AbstractController
{
    public $authors = array(
        array('id' => 1, 'picture' => '/images/Victor-Hugo.jpg','username' => 'Victor Hugo', 'email' =>
        'victor.hugo@gmail.com ', 'nb_books' => 100),
        array('id' => 2, 'picture' => '/images/william-shakespeare.jpg','username' => ' William Shakespeare', 'email' =>
        ' william.shakespeare@gmail.com', 'nb_books' => 200 ),
        array('id' => 3, 'picture' => '/images/Taha_Hussein.jpg','username' => 'Taha Hussein', 'email' =>
        'taha.hussein@gmail.com', 'nb_books' => 300),
        );
    #[Route('/author', name: 'app_author')]
    public function index(): Response
    {
        return $this->render('author/index.html.twig', [
            'controller_name' => 'AuthorController',
        ]);
    }

    #[Route('/author/list', name:'app_author_list')]
    public function authorList(AuthorRepository $authorRepository): Response{
        $authors= $authorRepository->findAll();
        //dd($authors);
        return $this->render('author/list.html.twig',[
            "authors" => $authors
        ]
    );
    }

    #[Route('/author/details/{id}', name:'app_author_details')]
    public function authorDetails($id, AuthorRepository $authorRepository): Response {
        /*$author=null;
        foreach ($this->authors as $a) {
            if($a['id']==$id){
                $author=$a;
                break;
            }
        }*/
        $author= $authorRepository->find($id);
        return $this->render('author/details.html.twig',[
            "author" => $author
        ]);
    }

    #[Route("/author/search/{username}", name:"app_author_search_username")]
    public function searchAuthorByUsername($username, AuthorRepository $authorRepository): Response{
        $author= $authorRepository->findOneByUsername($username);
        //dd($author);
        return $this->render('author/details.html.twig',[
            "author" => $author
        ]);

    }

    #[Route('/author/add/{username}', name:'app_author_add')]
    public function addAuthor($username, EntityManagerInterface $em): void{
        $author= new Author();
        $author->setUsername($username);
        $author->setEmail('taha.hussein@gmail.com');
        $author->setPicture('/images/Taha_Hussein.jpg');
        $author->setNbBooks(300);
        $em->persist($author);
        $em->flush();
        dd($author);
    }

    #[Route('/author/edit/{id}', name:'app_author_edit')]
    public function editAuthor($id, EntityManagerInterface $em, AuthorRepository $authorRepository): void{
        $author= $authorRepository->find($id);
        $author->setEmail('email edited 22222!');
        //$em->persist($author);
        $em->flush();
        dd($author);
    }
    #[Route('/author/delete/{id}', name:'app_author_delete')]
    public function deleteAuthor($id, EntityManagerInterface $em, AuthorRepository $authorRepository): void{
        $author = $authorRepository->find($id);
        $em->remove($author);
        $em->flush();
        dd("author deleted");
    }
}
