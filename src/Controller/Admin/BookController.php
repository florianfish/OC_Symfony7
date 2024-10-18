<?php

namespace App\Controller\Admin;

use App\Entity\Book;
use App\Form\BookType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin/book')]
class BookController extends AbstractController
{
    #[Route('', name: 'app_admin_book_index')]
    public function index(): Response
    {
        return $this->render('admin/book/index.html.twig', [
            'controller_name' => 'BookController',
        ]);
    }

    #[Route('/new', name: 'app_admin_book_new', methods: ['GET'])]
    public function new(Request $request): Response
    {
        $author = new Book();
        $form = $this->createForm(BookType::class, $author);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // faire quelque chose
        }

        return $this->render('admin/book/new.html.twig', [
            'form' => $form,
        ]);
    }
}
