<?php

namespace App\Form;

use App\Entity\Game;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class GameType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'label' => 'Nom',
                'constraints' => [
                    new Length([
                        'max' => 30,
                        'maxMessage' => 'Le nom du jeu ne peut pas dépasser 30 caractères',
                        'min' => 3,
                        'minMessage' => 'le nom du jeu doit avoir 3 caractères minimum'
                    ]),
                    new NotBlank([ 'message' => 'Ce champ ne peut être vide'])
                ]
            ])
            ->add('min_players')
            ->add('max_players')
            ->add('image', FileType::class, [
                'mapped' => false,
                'required' => false,
                'label' => 'Photo', 
                'constraints' => [
                    new File([
                        'mimeTypes' => [ "image/jpeg", "image/png", "image/gif"],
                        "mimeTypesMessage" => "Les formats autorisés sont gif, png, jpg",
                        'maxSize' => "2048k",
                        'maxSizeMessage' => 'Le fichier ne peut pas peser plus de 2Mo'
                    ])
                ] 
            ])
            ->add('enregistrer', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Game::class,
        ]);
    }
}
