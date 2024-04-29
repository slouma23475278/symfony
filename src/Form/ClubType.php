<?php

namespace App\Form;

use App\Entity\Club;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ClubType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('NomClub')
            ->add('FonctionClub')
            ->add('LogoClub', FileType::class, [
                'label' => 'Upload Club Logo',
                'required' => false, // Allow for no file
                'mapped' => false, // Not automatically mapped to the entity
                'attr' => ['accept' => 'image/*'], // Limit to image files
            ])
            ->add('DescriptionClub')
            ->add('TresorieClub')
            ->add('LocalClub')
            ->add('NombreStudentClub')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Club::class,
        ]);
    }
}
