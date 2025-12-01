<?php

namespace App\Form;

use App\Entity\Publicite;
use App\Entity\SponsorPartenaire;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PubliciteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('image', TextType::class)
            ->add('description', TextType::class, [
                'required' => false,
            ])
            ->add('lien', TextType::class, [
                'required' => false,
            ])
            ->add('sponsorPartenaire', EntityType::class, [
                'class' => SponsorPartenaire::class,
                'choice_label' => 'nom',
                'placeholder' => 'Aucun (publicité générale)',
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
