<?php


namespace App\Form;


use App\Entity\Profilsecu;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProfilsecuEditType extends AbstractType
{
    public function buildForm(FormBuilderInterface $formBuilder, array $options)
    {

        $formBuilder
            ->add('usernames', TextType::class, [
                'label' => 'Changer votre email ?',
                'attr' => [
                    'class' => "form-control"
                ],
            ])
            ->add('imageprofil', FileType::class, [
                'label' => 'Changer votre photo de profil :',
                'attr' => [
                    'class' => "form-control"
                ],
                'data_class' => null,
                'required' => false,
            ])
            ->add('save', SubmitType::class, [
                'label' => 'Enregistrer',
                'attr' => [
                    'class' => "btn btn-primary mt-3"
                ],
            ]);

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Profilsecu::class,
        ]);
    }
}