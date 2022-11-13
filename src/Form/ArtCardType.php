<?php

namespace App\Form;

use App\Entity\ArtCard;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

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
            ->add('pictureArt', TextType::class, [
                'label' => 'urlPicture',
                'required' => 'Une image est obligatoire.',
                'constraints' => [
                    new NotBlank(['message' => 'Le champ ne peut être vide.']),
                ]])
            ->add('description', TextareaType::class, [
                'label' => "Description de l'oeuvre",
                'attr' => ['class' => 'area-artisteType']
            ])
        ->add('city', TextType::class, [
            'label' => 'city',
            'required' => 'Une ville est obligatoire.',
            'constraints' => [
                new NotBlank(['message' => 'Le champ ne peut être vide.']),
            ]]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ArtCard::class,
        ]);
    }
}
