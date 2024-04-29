<?php

namespace App\Form;

use App\Entity\Evenement;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EvenementType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('typeEvenement', ChoiceType::class, [
                'choices' => [
                    'Conference' => 'Conference',
                    'Workshop' => 'Workshop',
                    'Seminar' => 'Seminar',
                    'Meeting' => 'Meeting',
                    'Party' => 'Party',
                ],
                'label' => 'Event Type',
                'required' => true,
                'placeholder' => 'Choose an event type', // Optional: adds a default option to the dropdown
                'empty_data' => null, // Optional: determines the default value when no choice is selected
            ])
            ->add('nomEvenement')
            ->add('descriptionEvenement')
            ->add('timeEventDebut')
            ->add('timeEventFin')
            ->add('lienFichier', FileType::class, [
                'label' => 'Upload Image',
                'required' => true,
                'constraints' => [
                    new File([
                        'mimeTypes' => ['image/jpeg', 'image/png', 'image/gif'],
                        'mimeTypesMessage' => "Please upload a JPEG, PNG, or GIF image.",
                        'maxSize' => '200M', // or any appropriate limit
                        'maxSizeMessage' => "The image must be 200 MB or smaller.",
                    ]),
                ],
            ])
            ->add('destinationEvenement')
            ->add('club')
            ->add('lecture')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Evenement::class,
        ]);
    }
}
