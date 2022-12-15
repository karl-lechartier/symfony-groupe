<?php

namespace App\Form;

use App\Entity\Animal;
use phpDocumentor\Reflection\Type;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
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
                'label'=>"Numéro d'identification (14 chiffres)"])
            ->add('nom')
            ->add('dateNaissance', DateType::class, array(
                "format" => 'ddMMyyyy'
            ))
            ->add('dateArrivee', DateType::class, [
                'required'=>true,
                'data' => new \DateTime("now"),
                "format" => 'ddMMyyyy'
            ])
            ->add('dateDepart', DateType::class, array(
                "format" => 'ddMMyyyy'
            ))
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

        $test = $builder->getData();

        if ($test->getSexe() != null) {
            $builder->add('sterile', null, [
                'disabled'=>false
            ]);
        }
    }


    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Animal::class,
        ]);
    }
}
