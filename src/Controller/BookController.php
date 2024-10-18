<?php

namespace App\Controller;

use App\Entity\Book;
use App\Repository\BookRepository;
use Pagerfanta\Doctrine\ORM\QueryAdapter;
use Pagerfanta\Pagerfanta;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;


#[Route('/books')]
class BookController extends AbstractController
{
    #[Route('', name: 'app_book_index')]
    public function index(Request $request, BookRepository $repository): Response
    {
        $qb = $repository->createQueryBuilder('book');
        $pagerfanta = new Pagerfanta(
            new QueryAdapter($qb),
        );
        $pagerfanta->setMaxPerPage(5);
        $pagerfanta->setCurrentPage($request->get('page') ?? 1);

        return $this->render('book/index.html.twig', [
            'controller_name' => 'BookController',
            'pager' => $pagerfanta,
        ]);
    }

    #[Route('/{id}', name: 'app_book_show', requirements: ['id' => '\d+'], methods: ['GET'])]

    public function show(?Book $book): Response
    {

        return $this->render('book/show.html.twig', [
            'controller_name' => 'BookController',
            'book' => $book,
        ]);
    }
}
