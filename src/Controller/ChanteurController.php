<?php

namespace App\Controller;

use App\Entity\Chanteur;
use App\Form\ChanteurType;
use App\Repository\ChanteurRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/chanteur')]
class ChanteurController extends AbstractController
{
    #[Route('/', name: 'app_chanteur_index', methods: ['GET'])]
    public function index(ChanteurRepository $chanteurRepository): Response
    {
        return $this->render('chanteur/index.html.twig', [
            'chanteurs' => $chanteurRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_chanteur_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $chanteur = new Chanteur();
        $form = $this->createForm(ChanteurType::class, $chanteur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($chanteur);
            $entityManager->flush();

            return $this->redirectToRoute('app_chanteur_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('chanteur/new.html.twig', [
            'chanteur' => $chanteur,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_chanteur_show', methods: ['GET'])]
    public function show(Chanteur $chanteur): Response
    {
        return $this->render('chanteur/show.html.twig', [
            'chanteur' => $chanteur,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_chanteur_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Chanteur $chanteur, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ChanteurType::class, $chanteur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_chanteur_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('chanteur/edit.html.twig', [
            'chanteur' => $chanteur,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_chanteur_delete', methods: ['POST'])]
    public function delete(Request $request, Chanteur $chanteur, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$chanteur->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($chanteur);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_chanteur_index', [], Response::HTTP_SEE_OTHER);
    }
}
