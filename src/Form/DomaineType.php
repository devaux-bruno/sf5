<?php


namespace App\Form;


use App\Entity\Domaine;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DomaineType extends AbstractType
{
    public function buildForm(FormBuilderInterface $formBuilder, array $options)
    {
        $formBuilder
            ->add('domaine', TextType::class, [
                'label' => 'Nom du domaine',
                'attr' => [
                    'class' => "form-control"
                ],
            ])
            ->add('save', SubmitType::class, [
                'label' => 'Ajouter ce domaine',
                'attr' => [
                    'class' => "btn btn-primary mt-3"
                ],
            ]);

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Domaine::class,
        ]);
    }
}

