<?php

namespace App\Form;

use App\Entity\Profilsecu;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class StatusType extends AbstractType
{
    public function buildForm(FormBuilderInterface $formBuilder, array $options)
    {

        $formBuilder->add('statut', ChoiceType::class, [
            'label' => 'Statut : ',
            'choices' => [
                'Membre' => '0',
                'Admin' => '1',
            ],
            'attr' => [
                'class' => 'form-control'
            ]
        ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Profilsecu::class,
        ]);
    }
}