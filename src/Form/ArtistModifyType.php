<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class ArtistModifyType extends AbstractType
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
            ->add('description', TextareaType::class, [
                'label' => "Description de l'artiste",
                'attr' => ['class' => 'area-artisteType']
            ])
            ->add('urlProfilPicture', TextType::class, [
                'label' => "Photo de profil",
            ]);
    }

    public function configurationOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}