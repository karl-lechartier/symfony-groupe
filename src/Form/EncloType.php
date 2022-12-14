<?php

namespace App\Form;

use App\Entity\Enclo;
use App\Entity\Espace;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EncloType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom')
            ->add('superficie')
            ->add('animauxMax')
            ->add('quarantaine')
            ->add('espaceID', EntityType::class, [
                'class'=>Espace::class,
                'choice_label'=>"nom",
                'label'=>"Espace",
                'multiple'=>false,
                'expanded'=>false
            ])
            ->add("ok", SubmitType::class, ["label"=>"OK"])

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Enclo::class,
        ]);
    }
}
