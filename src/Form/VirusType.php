<?php


namespace App\Form;


use App\Entity\Interruptions;
use App\Entity\Solution;
use App\Entity\Virus;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class VirusType extends AbstractType
{
    public function buildForm(FormBuilderInterface $formBuilder, array $options)
    {
        $formBuilder
            ->add('nomVirus', TextType::class, [
                'label' => 'Nom virus : ',
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('description', TextType::class, [
                'label' => 'Description courte : ',
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('solution', EntityType::class, [
                'label' => 'Solution ? : ',
                'required' => false,
                'class' => Solution::class,
                'choice_label' => 'idInter',
                'attr' => [
                    'class' => 'form-control'
                ]

            ])
            ->add('save', SubmitType::class ,[
                'label' => 'Enregistrer',
                'attr' => [
                    'class' => "btn btn-primary mt-3"
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Virus::class,
        ]);
    }
}
