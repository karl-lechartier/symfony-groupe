<?php

namespace App\Form;

use App\Entity\Enclos;
use App\Entity\Espace;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EnclosType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom')
            ->add('superficie')
            ->add('nbAnimaux')
            ->add('quarantaine')
            ->add('espace', EntityType::class, [
                'class'=>Espace::class,
                'choice_label'=>"nom",
                'label'=> "espace",
                'multiple'=>true,
                'expanded'=>true
                ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Enclos::class,
        ]);
    }
}
