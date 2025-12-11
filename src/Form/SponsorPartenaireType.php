<?php

namespace App\Form;

use App\Entity\SponsorPartenaire;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Image;

class SponsorPartenaireType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class, [
                'label' => 'Nom',
            ])
            // existing text field: URL or path (can be filled manually or via uploader)
            ->add('logo', TextType::class, [
                'label' => 'Logo (URL ou chemin)',
                'required' => false,
            ])
            // NEW: file field not mapped to the entity, used only for upload from PC
            ->add('logoFile', FileType::class, [
                'label' => 'Uploader un logo depuis votre PC',
                'mapped' => false,
                'required' => false,
                'constraints' => [
                    new Image([
                        'maxSize' => '4M',
                        'mimeTypesMessage' => 'Veuillez téléverser une image valide (JPG, PNG, GIF, SVG).',
                    ]),
                ],
            ])
            ->add('description', TextType::class, [
                'label' => 'Description',
                'required' => false,
            ])
            ->add('type', ChoiceType::class, [
                'label' => 'Type',
                'choices' => [
                    'Sponsor'    => 'sponsor',
                    'Partenaire' => 'partenaire',
                ],
                'placeholder' => 'Sélectionner un type',
            ])
            ->add('email', EmailType::class, [
                'label' => 'Email de contact',
                'required' => false,
            ])
            ->add('lien', TextType::class, [
                'label' => 'Lien externe',
                'required' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => SponsorPartenaire::class,
        ]);
    }
}
