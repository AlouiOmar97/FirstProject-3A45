<?php

namespace App\Controller;

use App\Entity\Book;
use App\Form\AddEditBookType;
use App\Repository\BookRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class BookController extends AbstractController
{
    #[Route('/book', name: 'app_book')]
    public function index(): Response
    {
        return $this->render('book/index.html.twig', [
            'controller_name' => 'BookController',
        ]);
    }

    #[Route('/book/create', name:'app_book_create')]
    public function creatBook(Request $request, EntityManagerInterface $em){
        $book = new Book();
        $form = $this->createForm(AddEditBookType::class, $book);
        $form->handleRequest($request);
        if($form->isSubmitted()){
            $em->persist($book);
            $em->flush();
            return $this->redirectToRoute('app_book_list');
        }
        return $this->render('book/form.html.twig', [
            'title' => 'Create Book',
            'form'=> $form,
        ]);
    }
    

    #[Route('/book/list', name:'app_book_list')]
    public function bookList(BookRepository $bookRepository): Response{
        $books= $bookRepository->findAll();
        return $this->render('book/list.html.twig',[
            "books" => $books
        ]
    );
    }

    #[Route('/book/details/{id}', name:'app_book_details')]
    public function bookDetails($id, BookRepository $bookRepository): Response{
        $book= $bookRepository->find($id);
        return $this->render('book/details.html.twig',[
            "book" => $book
        ]
    );
    }

    #[Route('/book/update/{id}', name:'app_book_update')]
    public function updateBook($id, BookRepository $bookRepository, Request $request, EntityManagerInterface $em){
        $book = $bookRepository->find( $id );
        $form = $this->createForm(AddEditBookType::class, $book);
        $form->handleRequest($request);
        if($form->isSubmitted()){
            $em->flush();
            return $this->redirectToRoute('app_book_list');
        }
        return $this->render('book/form.html.twig', [
            'title' => 'Update Book',
            'form'=> $form,
        ]);
    }
    


    #[Route("/author/delete/{id}", name:"app_book_delete")]
    public function deleteBook($id, BookRepository $bookRepository, EntityManagerInterface $em): Response {
        $book= $bookRepository->find($id);
        $em->remove($book);
        $em->flush();
        return $this->redirectToRoute("app_book_list");
    }
}
