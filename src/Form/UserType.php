<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;

class UserType extends AbstractType
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
            ->add('password', RepeatedType::class, [
                'type' => PasswordType::class,
                'label' => 'Mot de passe',
                'required' => true,
                'first_options' => array('label' => 'Mot de passe*'),
                'second_options' => array('label' => 'Confirmez votre mot de passe*'),
                'constraints' => [
                    new NotBlank(['message' => "Ce champ est obligatoire."]),
                    new Length([
                        'min' => 8,
                        'minMessage' => 'Le mot de passe doit comporter plus de {{ limit }} caractères.'
                    ])
                ],
                'invalid_message' => 'Le mot de passe doit être identique.',
                'options' => ['attr' => [
                    'class' => 'password-field',
                    'placeholder' => "Mot de passe",
                ]],
            ]);
    }

    public function configurationOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}