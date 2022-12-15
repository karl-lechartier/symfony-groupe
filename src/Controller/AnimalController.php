<?php

namespace App\Controller;

use App\Entity\Animal;
use App\Entity\Enclo;
use App\Entity\Espace;
use App\Form\AnimalType;
use App\Form\EncloType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AnimalController extends AbstractController
{
    #[Route('/animal/voir', name: 'app_animal_voir')]
    public function index(ManagerRegistry $doctrine): Response
    {
        $animal = $doctrine->getRepository(Animal::class)->findAll();
        /*if (!$animal) {
            throw $this->createNotFoundException("Aucun animal avec l'id $id");
        }*/

        return $this->render('animal/index.html.twig', [
            'animal' => $animal,
        ]);
    }

    #[Route('/animal/ajouter', name: 'app_animal_ajouter')]
    public function ajouter(ManagerRegistry $doctrine, Request $request): Response
    {

        $animal = new Animal();
        $form = $this->createForm(AnimalType::class,$animal);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $em = $doctrine->getManager();
            $em->persist($animal);
            $em->flush();
            return $this->redirectToRoute("app_animal_voir");
        }

        return $this->render('animal/ajouter.html.twig', [
            'formulaire' => $form->createView()
        ]);
    }

    #[Route('/animal/supprimer/{id}', name: 'app_animal_supprimer')]
    public function supprimer($id, ManagerRegistry $doctrine, Request $request): Response
    {
        $animal = $doctrine->getRepository(Animal::class)->find($id);

        if (!$animal){
            throw $this->createNotFoundException("Pas d'animaux avec l'id $id");
        }

        $em=$doctrine->getManager();
        $em->remove($animal);

        $em->flush();

        return $this->redirectToRoute("app_animal_voir");
    }

    #[Route('/animal/modifier/{id}', name: 'app_animal_modifier')]
    public function modifier($id, ManagerRegistry $doctrine, Request $request): Response
    {
        $animal = $doctrine->getRepository(Animal::class)->find($id);

        if (!$animal){
            throw $this->createNotFoundException("Pas d'animaux avec l'id $id");
        }

        $form=$this->createForm(AnimalType::class, $animal);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){

            $em=$doctrine->getManager();
            $em->persist($animal);
            $em->flush();
            return $this->redirectToRoute("app_animal_voir");
        }

        return $this->render("animal/modifier.html.twig",[
            "animal"=>$animal,
            "formulaire"=>$form->createView()
        ]);
    }
}
