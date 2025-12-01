<?php

namespace App\Form;

use App\Entity\Evenement;
use App\Enum\TypeEvenement;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class Evenement1Type extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titre')
            ->add('description')
            ->add('dateEvent', DateTimeType::class, [
                'widget' => 'single_text',
                'html5' => true,
                'attr' => ['class' => 'input-date'],
            ])
            ->add('lieu')
            ->add('ville')
            ->add('type', ChoiceType::class, [
                'choices' => TypeEvenement::cases(),
                'choice_label' => function (?TypeEvenement $choice) {
                    return $choice?->value;
                },
                'choice_value' => function (?TypeEvenement $choice) {
                    return $choice?->value;
                },
                'attr' => ['class' => 'select-input'],
            ])
            // image upload (not mapped to entity directly)
            ->add('imageFile', FileType::class, [
                'label' => 'Image (fichier)',
                'mapped' => false,
                'required' => false,
                'attr' => ['class' => 'input-file'],
            ])
            ->add('organisateurNom')
            ->add('organisateurPrenom')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Evenement::class,
        ]);
    }
}
