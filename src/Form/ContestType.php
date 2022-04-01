<?php

namespace App\Form;

use App\Entity\Contest;
use App\Entity\Game;
use App\Entity\Player;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContestType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('start_date', DateType::class, [
                'widget' => 'single_text',
                'label' => 'Date de début',
            ])
            ->add('game', EntityType::class, [
                'class' => Game::class,
                'choice_label' => 'title', // on choisit le champ qui sera affiché dans le select
                'placeholder' => '',
                'label' => 'Jeu'
            ])
            ->add('winner', EntityType::class, [
                'class' => Player::class,
                'choice_label' => 'nickname', 
                'placeholder' => 'Choisir le gagnant',
                'required' => false,
                'label' => 'Vainqueur'
            ])
            ->add('players', EntityType::class, [
                'class' => Player::class,
                'choice_label' => 'nickname',
                'multiple' => true,
                'expanded' => true,
                'label' => "participants"
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Contest::class,
        ]);
    }
}
