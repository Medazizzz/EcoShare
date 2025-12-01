<?php

namespace App\Form;

use App\Entity\Commentaire;
use App\Entity\Evenement;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class Commentaire1Type extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('contenu')
            ->add('dateCreation', DateTimeType::class, [
                'widget' => 'single_text',
                'html5' => true,
                'attr' => ['class' => 'input-date'],
            ])
            ->add('evenement', EntityType::class, [
                'class' => Evenement::class,
                // display the event title instead of the id in the select
                'choice_label' => 'titre',
                'placeholder' => 'Choisir un événement',
                'attr' => ['class' => 'select-input'],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Commentaire::class,
        ]);
    }
}
