<?php

namespace App\Form;

use App\Entity\Serie;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SerieType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, ['label' => 'Title'])
            ->add('overview', null,['required' => false] )
            ->add('status', ChoiceType::class, ['choices' =>
                ['cancelled' => 'cancelled', 'ended' => 'ended', 'returning' => 'returning'],
                'multiple' => false
            ])
            ->add('vote')
            ->add('popularity')
            ->add('genres')
            ->add('firstAirDate', DateType::class, ['html5' => true, 'widget'=>'single_text'])
            ->add('lastAirDate', DateType::class, ['html5' => true, 'widget'=>'single_text'])
            ->add('backdrop')
            ->add('poster')
            ->add('tmdbId')
            // ->add('submit', SubmitType::class) // optionel permet ajouter bouton submit préférer ajouter en twig
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Serie::class,
        ]);
    }
}
