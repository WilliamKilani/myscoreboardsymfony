<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $user = $options['data']; // je récupère la variable User qui est lié au formulaire dans le contrôleur, dans la méthode createForm()
        $builder
            ->add('pseudo', TextType::class, [
                'constraints' => [
                    new Assert\NotNull(["message" => "Veuillez remplir ce champ"]),
                    new Assert\Length([
                        "min" => 4,
                        "minMessage" => "Le pseudo doit comporter au moins 4 caractères"
                    ])
                ]
            ])
            ->add('email', EmailType::class, [
                'label' => 'E-mail',
                'mapped' => false,
                'constraints' => [
                    new Assert\NotNull(["message" => "Veuillez remplir ce champ"])
                ]
            ])
            ->add('roles', ChoiceType::class, [
                'choices' => [
                    'Administrateur' => 'ROLE_ADMIN',
                    'Joueur' => 'ROLE_PLAYER',
                    'Abitre' => 'ROLE_REFEREE',
                    'Utilisateur' => 'ROLE_USER'
                ],
                'multiple' => true,
                'expanded' => true
            ])
            ->add('password', TextType::class, [
                'mapped' => false,
                'required' => $user->getId() ? false : true // si l'id n'est pas nul, le champ password n'est pas requis (edit) sinon il l'est (new)
                // on aurait pu écrire:
                // 'required' => !$user-getId()
            ])

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
