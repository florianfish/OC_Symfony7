<?php

namespace App\Controller\Admin;

use App\Entity\Editor;
use App\Form\EditorType;
use App\Repository\EditorRepository;
use Doctrine\ORM\EntityManagerInterface;
use Pagerfanta\Doctrine\ORM\QueryAdapter;
use Pagerfanta\Pagerfanta;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin/editor')]
class EditorController extends AbstractController
{
    #[Route('', name: 'app_admin_editor_index')]
    public function index(Request $request, EditorRepository $repository): Response
    {
        $qb = $repository->createQueryBuilder('editor');
        $pagerfanta = new Pagerfanta(
            new QueryAdapter($qb),
        );
        $pagerfanta->setMaxPerPage(5);
        $pagerfanta->setCurrentPage($request->get('page') ?? 1);

        return $this->render('admin/editor/index.html.twig', [
            'controller_name' => 'EditorController',
            'pager' => $pagerfanta
        ]);
    }

    #[Route('/new', name: 'app_admin_editor_new', methods: ['GET', 'POST'])]
    #[Route('/{id}/edit', name: 'app_admin_editor_edit', requirements: ['id' => '\d+'], methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $em): Response
    {
        $editor ??= new Editor();
        $form = $this->createForm(EditorType::class, $editor);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($editor);
            $em->flush();

            return $this->redirectToRoute('app_admin_editor_new', ['id' => $editor->getId()]);
        }



        return $this->render('admin/editor/new.html.twig', [
            'form' => $form,
        ]);
    }
    #[Route('/{id}', name: 'app_admin_editor_show', requirements: ['id' => '\d+'], methods: ['GET'])]
    public function show(?Editor $editor, EditorRepository $repository): Response
    {
        return $this->render('admin/editor/show.html.twig', [
            'controller_name' => 'EditorController',
            'editor' => $editor,
        ]);
    }
}
