<?php


namespace App\Form;


use App\Entity\Interruptions;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class InterruptionsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $formBuilder, array $options)
    {
        $formBuilder
            ->add('type', TextType::class, [
                'label' => 'Votre type d\'incident',
                'attr' => [
                    'class' => "form-control"
                ],
            ])
            ->add('description', TextType::class, [
                'label' => 'Votre description',
                'attr' => [
                    'class' => "form-control"
                ],
            ])
            ->add('transport', TextType::class, [
                'label' => 'Virus',
                'attr' => [
                    'class' => "form-control"
                ],
            ])
            ->add('active', ChoiceType::class, [
                'label' => 'Activer',
                'choices' => [
                    'active' => '1',
                    'non active' => '0',
                ],
                'attr' => [
                    'class' => "form-control"
                ],
            ])
            ->add('save', SubmitType::class, [
                'label' => 'Ajouter cet incident',
                'attr' => [
                    'class' => "btn btn-primary mt-3"
                ],
            ]);

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Interruptions::class,
        ]);
    }
}

