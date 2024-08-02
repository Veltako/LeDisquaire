<?php

namespace App\Controller;

use App\Entity\Disque;
use App\Form\DisqueType;
use App\Repository\DisqueRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

class DisqueControlleur extends AbstractController
{
    #[Route(path: "/disques", name: "app_disque", methods: ['GET'])]
    public function index(DisqueRepository $disqueRepo): Response
    {

        $disque = $disqueRepo->findAll();

        return $this->render("disque/index.html.twig", [
            "disques" => $disque
        ]);
    }
    #[Route(path: "/disques/{id}", name: "app_disque_id", methods: ['GET'])]
    public function show(int $id, DisqueRepository $disqueRepo): Response
    {
        $disque = $disqueRepo->find($id);

        return $this->render("disque/show.html.twig", [
            "disque" => $disque

        ]);
    }
    #[Route(path: "/disquecreate", name: "app_disque_create", methods: ['GET', 'POST'])]

    public function new(Request $request, EntityManagerInterface $manager): Response
    {
        //création d'un nouveau disque
        $disque = new Disque();

        //création du formation
        $form = $this->createForm(DisqueType::class, $disque);

        //traitement du formulaire 
        $form->handleRequest($request);
        //si le formulaire est soumis et valide
        if ($form->isSubmitted() && $form->isValid()) {
            //on récupère le manager
            $manager->persist($disque);

            //envoie dans la db
            $manager->flush();
            //on enregistre vers la liste des disque
            return $this->redirectToRoute('app_disque');
        }
        return $this->render('disque/create.html.twig', [
            //on envoie le formulaire à la vue
            'form' => $form->createView()
        ]);
    }
    
    #[Route(path: '/disque/edit/{id}', name: 'app_disque_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, DisqueRepository $disqueRepo, $id, EntityManagerInterface $manager): Response
    {
        
        //on récupère le livre par l'id
        $disque = $disqueRepo->findOneBy(['id' => $id]);
        //on créer le form
        $form = $this->createForm(DisqueType::class, $disque);
        //on traite le form
        $form->handleRequest($request);
        //si le form est soumis et valide
        if ($form->isSubmitted() && $form->isValid()) {
            //on enregistre le disque
            $disque = $form->getData();
            
            $manager->persist($disque);
            $manager->flush();
            return $this->redirectToRoute('app_disque');
        }
        return $this->render('disque/edit.html.twig', [
            //on envoie le formulaire à la vue
            'form' => $form->createView()
        ]);
    }
    #[Route(path:'/disque/delete/{id}', name:'app_disque_delete', methods: ['GET'])]
    public function delete(DisqueRepository $disqueRepo, $id, EntityManagerInterface $manager): Response
    {
        //on récupère le livre à supprimer par son id
        $disque = $disqueRepo->findOneBy(['id'=> $id]);
        //si le livre n'existe pas
        if (!$disque) {
            //on affiche un message d'erreur
            $this->addFlash('danger', 'Le livre n\'existe pas');
            //on redirige vers la liste des disques
            return $this->redirectToRoute('app_disque');
        }

        //on supprime le livre
        $manager->remove($disque);
        $manager->flush();

        //on affiche un message de confirmation
        $this->addFlash('success','le livre a été supprimé');

        return $this->redirectToRoute('app_disque');   
    }
}
