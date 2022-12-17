<?php

namespace App\Controller;

use App\Entity\Animal;
use App\Entity\Enclo;
use App\Entity\Espace;
use App\Form\AnimalmodifyType;
use App\Form\AnimalType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AnimalController extends AbstractController
{
    #[Route('/animal/voir/{id}', name: 'app_animal_voir')]
    public function index($id, ManagerRegistry $doctrine): Response
    {
        $enclo = $doctrine->getRepository(Enclo::class)->find($id);
        //si on n'a rien trouvé -> 404
        if (!$enclo) {
            throw $this->createNotFoundException("Aucun enclos avec l'id $id");
        }

        return $this->render('animal/index.html.twig', [
            'enclo' => $enclo,
            "animal" => $enclo->getAnimaux()
        ]);
    }

    #[Route('/animal/ajouter/{id}', name: 'app_animal_ajouter')]
    public function ajouter($id, ManagerRegistry $doctrine, Request $request): Response
    {
        $enclo = $doctrine->getRepository(Enclo::class)->find($id);
        $nbrAnimaux = sizeof($enclo->getAnimaux());

        if ($nbrAnimaux>=$enclo->getAnimauxMax()){
            throw new \Exception("Vous ne pouvez pas rajouter d'animaux a cet enclos");
        }

        $animal = new Animal();
        $form = $this->createForm(AnimalType::class,$animal);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $numeroIdentification = $form['numeroIdentification']->getData();
            $dateNaissance = $form['dateNaissance']->getData();
            $dateArrive = $form['dateArrivee']->getData();
            $dateDepart = $form['dateDepart']->getData();
            $sexe = $form['sexe']->getData();
            $sterile = $form['sterile']->getData();
            $encloID = $form['encloID']->getData();
            $verifnumid = $doctrine->getRepository(Animal::class)->findBy(array('numeroIdentification' => $numeroIdentification));

            if ($dateNaissance>$dateArrive && isset($dateNaissance)){
                throw new \Exception("La date d'arriver ne pas pas être plus ancienne que la date de naissance");
            }
            if ($dateArrive>$dateDepart && isset($dateDepart)){
                throw new \Exception("La date de départ ne pas pas être plus ancienne que la date d'arriver");
            }
            if (!(preg_match('/^[0-9]+$/', $numeroIdentification))){
                throw new \Exception("Le numéro d'identification ne doit pas contenir de lettre ou caractères spéciaux : ".$numeroIdentification);
            }
            if (sizeof($verifnumid)){
                throw new \Exception("Il y a déjà un animal avec le numéro d'identification : ".$numeroIdentification);
            }
            if ($sexe == null && $sterile == true) {
                throw new \Exception("Son sexe n'est pas défini, il ne peut pas être stérile");
            }

            $em = $doctrine->getManager();
            $em->persist($animal);
            $em->flush();

            if (($enclo->getQuarantaine())==1){
                $animal->setEnQuarantaine(true);
                $em = $doctrine->getManager();
                $em->persist($animal);
                $em->flush();
            }

            return $this->redirectToRoute("app_animal_voir", ["id" => $animal->getEncloID()->getId()]);
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

        $form=$this->createForm(AnimalmodifyType::class, $animal);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $numeroIdentification = $form['numeroIdentification']->getData();
            $dateNaissance = $form['dateNaissance']->getData();
            $dateArrive = $form['dateArrivee']->getData();
            $dateDepart = $form['dateDepart']->getData();
            $sexe = $form['sexe']->getData();
            $sterile = $form['sterile']->getData();
            $verifnumid = $doctrine->getRepository(Animal::class)->findBy(array('numeroIdentification' => $numeroIdentification));

            if ($dateNaissance>$dateArrive && isset($dateNaissance)){
                throw new \Exception("La date d'arriver ne pas pas être plus ancienne que la date de naissance");
            }
            if ($dateArrive>$dateDepart && isset($dateDepart)){
                throw new \Exception("La date de départ ne pas pas être plus ancienne que la date d'arriver");
            }
            if (!(preg_match('/^[0-9]+$/', $numeroIdentification))){
                throw new \Exception("Le numéro d'identification ne doit pas contenir de lettre ou caractères spéciaux : ".$numeroIdentification);
            }
            if (sizeof($verifnumid)>1){
                throw new \Exception("Il y a déjà un animal avec le numéro d'identification : ".$numeroIdentification);
            }
            if ($sexe == null && $sterile == true) {
                throw new \Exception("Son sexe n'est pas défini, il ne peut pas être stérile");
            }

            $quarantaine = $form['enQuarantaine']->getData();
            if ($quarantaine!=true){
                $enclo = $animal->getEncloID();

                $nbrAnimauxQuarantaine = sizeof($doctrine->getRepository(Animal::class)->findBy(array('enQuarantaine' => true)));
                if ($nbrAnimauxQuarantaine==1){
                    $enclo->setQuarantaine(false);
                }
            }

            $em=$doctrine->getManager();
            $em->persist($animal);
            $em->flush();
            return $this->redirectToRoute("app_animal_voir", ["id" => $animal->getEncloID()->getId()]);
        }

        return $this->render("animal/modifier.html.twig",[
            "animal"=>$animal,
            "formulaire"=>$form->createView()
        ]);
    }
}
