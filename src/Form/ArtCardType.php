<?php

namespace App\Form;

use App\Entity\ArtCard;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\File;

class ArtCardType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'label' => 'Titre',
                'required' => 'Un titre est obligatoire.',
                'constraints' => [
                    new NotBlank(['message' => 'Le champ ne peut être vide.']),
                ]])
            ->add('pictureArt', FileType::class, [
                'label' => 'Photo',
                'required' => 'Une image est obligatoire.',
                'mapped' => false,
                'constraints' => [
                    new File([
                        'maxSize' => '2M',
                        'mimeTypes' => [
                            'image/jpg',
                            'image/jpeg',
                            'image/png',
                        ],
                        'mimeTypesMessage' => "Merci d'upload une image au format PNG, JPEG, JPG.",
                    ]),
                ]])
            ->add('description', TextareaType::class, [
                'label' => "Description",
                'attr' => ['class' => 'area-artisteType']
            ])
        ->add('city', TextType::class, [
            'label' => 'Ville',
            'required' => 'Une ville est obligatoire.',
            'constraints' => [
                new NotBlank(['message' => 'Le champ ne peut être vide.']),
            ]])
            ->add('latitude', NumberType::class, [
                'attr' => ['class' => 'hidden']
            ])
            ->add('longitude', NumberType::class, [
                'attr' => ['class' => 'hidden']
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ArtCard::class,
        ]);
    }
}
