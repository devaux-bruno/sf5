<?php


namespace App\Form;



use App\Entity\Solution;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SolutionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $formBuilder, array $options)
    {
        $formBuilder
            ->add('solutions',TextareaType::class, [
                'label' => 'Solution',
                'attr' => [
                    'class' => "form-control"
                ],
            ])
            ->add('save', SubmitType::class ,[
            'label' => 'Proposer votre solution',
            'attr' => [
                'class' => "btn btn-primary mt-3"
            ],
        ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
    $resolver->setDefaults([
        'data_class' => Solution::class,
    ]);
}

}