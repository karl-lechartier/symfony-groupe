<?php

namespace App\Form;

use App\Entity\Animal;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AnimalType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('numeroIdentification', TextType::class, [
                'attr'=>['minlength'=>"14", 'maxlength'=>"14", 'size'=>"14"],
                'required'=>true,
                'label'=>"Numéro d'identification (14 chiffres)"
                ])
            ->add('nom')
            ->add('dateNaissance')
            ->add('dateArrivee', DateType::class, [ //Doit être la valeur de creation de l'espace où il est
                'required'=>true
                ])
            ->add('dateDepart', DateType::class, [
                'required'=>false
                ])
            ->add('zooEstProprietaire')
            ->add('genre', TextType::class, [
                'required'=>true
                ])
            ->add('espece', TextType::class, [
                'required'=>true
                ])
            ->add('sexe', ChoiceType::class, [
                'choices'=> [
                    'Non déterminé'=> null,
                    'Mâle'=> 'Mâle',
                    'Femelle'=> 'Femelle'
                    ]
                ])
            ->add('sterile', null, [
                'disabled'=>true
                ])
            ->add('enQuarantaine')
            ->add("ok", SubmitType::class, ["label"=>"OK"])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Animal::class,
        ]);
    }
}
