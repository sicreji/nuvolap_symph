<?php

namespace App\Form;

use App\Entity\Proverb;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use \Symfony\Component\Form\Extension\Core\Type\TextType;
use \Symfony\Component\Form\Extension\Core\Type\SubmitType;
use \Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class ProverbType extends AbstractType
{
    private $choices = [
        'Choisir une langue' => '_',
        'français' => 'fr',
        'italien' => 'it',
        'latin' => 'la'
    ];

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('body', TextType::class, ['label' => 'texte'])
            ->add('lang', ChoiceType::class, ['choices' => $this->choices])
            ->add('save', SubmitType::class, ['label' => 'Enregistrer'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Proverb::class,
        ]);
    }
}
