<?php

namespace App\Form;

use App\Entity\Publicite;
use App\Entity\SponsorPartenaire;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PubliciteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            // text field: URL or stored path
            ->add('image', TextType::class, [
                'label' => 'Image (URL ou chemin)',
                'required' => false,
            ])
            // NEW: file upload from PC (not mapped to entity)
            ->add('imageFile', FileType::class, [
                'label' => 'Uploader une image depuis votre PC',
                'mapped' => false,
                'required' => false,
                'constraints' => [],
            ])
            ->add('description', TextType::class, [
                'label' => 'Description',
                'required' => false,
            ])
            ->add('lien', TextType::class, [
                'label' => 'Lien externe',
                'required' => false,
            ])
            ->add('sponsorPartenaire', EntityType::class, [
                'class' => SponsorPartenaire::class,
                'choice_label' => 'nom',
                'label' => 'Sponsor / Partenaire lié',
                'placeholder' => 'Aucun (publicité générale)',
                'required' => false,
            ])
            ->add('favori', CheckboxType::class, [
                'label' => 'Marquer comme favori',
                'required' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Publicite::class,
        ]);
    }
}
