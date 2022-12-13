<?php

namespace App\Controller;

use App\Entity\Espace;
use App\Form\EnclosType;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Enclos;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EnclosController extends AbstractController
{
    #[Route('/enclos/voir/{id}', name: 'app_enclos')]
    public function index($id, ManagerRegistry $doctrine): Response
    {
        $espace = $doctrine->getRepository(Espace::class)->find($id);

        if (!$espace) {
            throw $this->createNotFoundException("Aucun espace avec l'id $id");
        }

        $repo = $doctrine->getRepository(Enclos::class);
        $enclos= $repo->findAll();

        return $this->render('enclos/index.html.twig', [
            'espace'=> $espace,
            'enclos'=> $espace->getOui(),
        ]);
    }

    #[Route('/enclos/ajouter', name: 'app_enclos_ajouter')]
    public function ajouter(ManagerRegistry $doctrine, Request $request): Response
    {
        $enclos = new Enclos();
        $form = $this->createForm(EnclosType::class,$enclos);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $em = $doctrine->getManager();
            $em->persist($enclos);
            $em->flush();
            return $this->redirectToRoute("app_espace");
        }

        return $this->render('enclos/ajouter.html.twig', [
            'formulaire' => $form->createView()
        ]);
    }

    #[Route('/enclos/supprimer/{id}', name: 'app_enclos_supprimer')]
    public function supprimer($id, ManagerRegistry $doctrine, Request $request): Response
    {
        $enclos = $doctrine->getRepository(Enclos::class)->find($id);

        if (!$enclos){
            throw $this->createNotFoundException("Pas d'enclos avec l'id $id");
        }

        $form=$this->createForm(EnclosType::class, $enclos);

        $em=$doctrine->getManager();
        $em->remove($enclos);

        $em->flush();

        return $this->redirectToRoute("app_enclos");
    }
}
