<?php

namespace App\Controller;

use App\Form\EspaceType;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Espace;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EspaceController extends AbstractController
{
    #[Route('/', name: 'app_espace')]
    public function index(ManagerRegistry $doctrine): Response
    {
        $repo = $doctrine->getRepository(Espace::class);
        $espaces=$repo->findAll();
        
        return $this->render('espace/index.html.twig', [
            'espaces' => $espaces,
        ]);
    }

    #[Route('/espace/ajouter', name: 'app_espace_ajouter')]
    public function ajouter(ManagerRegistry $doctrine, Request $request): Response
    {
        $espace = new Espace();
        $form = $this->createForm(EspaceType::class,$espace);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $dateOverture = $form['dateOuverture']->getData();
            $dateFermeture = $form['dateFermeture']->getData();

            if (isset($dateFermeture) && !isset($dateOverture)) {
                throw new \Exception("La date de fermeture ne peut pas être remplie si la date d'ouverture n'est pas remplie");
            }
            if ($dateFermeture<=$dateOverture && isset($dateOverture)) {
                throw new \Exception("La date de fermeture dois être plus récente que la date d'ouverture");
            }

                $em = $doctrine->getManager();
            $em->persist($espace);
            $em->flush();
            return $this->redirectToRoute("app_espace");
        }

        return $this->render('espace/ajouter.html.twig', [
            'formulaire' => $form->createView()
        ]);
    }

    #[Route('/espace/supprimer/{id}', name: 'app_espace_supprimer')]
    public function supprimer($id, ManagerRegistry $doctrine, Request $request): Response
    {
        $espace = $doctrine->getRepository(Espace::class)->find($id);

        if (!$espace){
            throw $this->createNotFoundException("Pas d'espace avec l'id $id");
        }

        $em=$doctrine->getManager();
        $em->remove($espace);

        $em->flush();

        return $this->redirectToRoute("app_espace");
    }

    #[Route('/espace/modifier/{id}', name: 'app_espace_modifier')]
    public function modifier($id, ManagerRegistry $doctrine, Request $request): Response
    {
        $espace = $doctrine->getRepository(Espace::class)->find($id);

        if (!$espace){
            throw $this->createNotFoundException("Pas d' espace avec l'id $id");
        }

        $form=$this->createForm(EspaceType::class, $espace);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $dateOverture = $form['dateOuverture']->getData();
            $dateFermeture = $form['dateFermeture']->getData();

            if (isset($dateFermeture) && !isset($dateOverture)) {
                throw new \Exception("La date de fermeture ne peut pas être remplie si la date d'ouverture n'est pas remplie");
            }
            if ($dateFermeture<=$dateOverture && isset($dateOverture)) {
                throw new \Exception("La date de fermeture dois être plus récente que la date d'ouverture");
            }

            $em=$doctrine->getManager();
            $em->persist($espace);
            $em->flush();
            return $this->redirectToRoute("app_espace");
        }

        return $this->render("espace/modifier.html.twig",[
            "espace"=>$espace,
            "formulaire"=>$form->createView()
        ]);
    }
}
