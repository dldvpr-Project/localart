<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class AdminModifyArtistType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nickname', TextType::class, [
                'label' => 'Pseudo',
                'required' => 'Le champ Pseudo est obligatoire.',
                'constraints' => [
                    new NotBlank(['message' => 'Le champ ne peut être vide.']),
                    new Length([
                        'min' => 2,
                        'minMessage' => 'Votre pseudo doit comporter au moins {{ limit }} caractères',
                        'max' => 50,
                        'maxMessage' => 'Votre pseudo ne peut pas dépasser {{ limit }} caractères',])
                ]
            ])
            ->add('email', EmailType::class, [
                'label' => 'E-mail',
                'required' => "Le champ E-mail est obligatoire",
            ])
            ->add('description', TextareaType::class, [
                'label' => "Description de l'artiste",
                'attr' => ['class' => 'area-artisteType']
            ])
            ->add('profilPicture', FileType::class, [
                'label' => 'Photo de profil',
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
                ]]);
    }

    public function configurationOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}