<?php

namespace App\Controller;

use App\Entity\Espace;
use App\Form\EncloType;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Enclo;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EncloController extends AbstractController
{
    #[Route('/enclos/voir/{id}', name: 'app_enclo_voir')]
    public function index($id, ManagerRegistry $doctrine): Response
    {
        $espace = $doctrine->getRepository(Espace::class)->find($id);
        //si on n'a rien trouvé -> 404
        if (!$espace) {
            throw $this->createNotFoundException("Aucun espace avec l'id $id");
        }

        return $this->render('enclo/index.html.twig', [
            'espace' => $espace,
            "enclos" => $espace->getEnclos()
        ]);
    }

    #[Route('/enclos/ajouter', name: 'app_enclo_ajouter')]
    public function ajouter(ManagerRegistry $doctrine, Request $request): Response
    {

        $enclo = new Enclo();
        $form = $this->createForm(EncloType::class,$enclo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $em = $doctrine->getManager();
            $em->persist($enclo);
            $em->flush();
            return $this->redirectToRoute("app_enclo_voir", ["id" => $enclo->getEspaceID()->getId()]);
        }


        return $this->render('enclo/ajouter.html.twig', [
            'formulaire' => $form->createView()
        ]);
    }

    #[Route('/enclos/supprimer/{id}', name: 'app_enclo_supprimer')]
    public function supprimer($id, ManagerRegistry $doctrine, Request $request): Response
    {
        $enclo = $doctrine->getRepository(Enclo::class)->find($id);
        $nbrAnimaux = sizeof($enclo->getAnimaux());

        if (!$enclo){
            throw $this->createNotFoundException("Pas d'enclos avec l'id $id");
        }
        if ($nbrAnimaux!=0){
            throw new \Exception("Vous ne pouvez pas supprimer un enclos qui contient des animaux");
        }

        $em=$doctrine->getManager();
        $em->remove($enclo);

        $em->flush();

        return $this->redirectToRoute("app_enclo_voir", ["id" => $enclo->getEspaceID()->getId()]);
    }

    #[Route('/enclos/modifier/{id}', name: 'app_enclo_modifier')]
    public function modifier($id, ManagerRegistry $doctrine, Request $request): Response
    {
        $enclo = $doctrine->getRepository(Enclo::class)->find($id);

        if (!$enclo){
            throw $this->createNotFoundException("Pas d'enclos avec l'id $id");
        }

        $form=$this->createForm(EncloType::class, $enclo);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $quarantaine  = $form['quarantaine']->getData();

            if ($quarantaine==1){
                $animaux = $enclo->getAnimaux();
                foreach ($animaux as $a){
                    $a->setEnQuarantaine(true);
                }
            }else{
                $animaux = $enclo->getAnimaux();
                foreach ($animaux as $a){
                    $a->setEnQuarantaine(false);
                }
            }

            $em=$doctrine->getManager();
            $em->persist($enclo);
            $em->flush();
            return $this->redirectToRoute("app_enclo_voir", ["id" => $enclo->getEspaceID()->getId()]);
        }

        return $this->render("enclo/modifier.html.twig",[
            "enclo"=>$enclo,
            "formulaire"=>$form->createView()
        ]);
    }

}
