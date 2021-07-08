<?php

namespace App\Form;

use App\Entity\Recruitment;
use Symfony\Component\Form\AbstractType;
use Vich\UploaderBundle\Form\Type\VichFileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class RecruitmentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('pdfFile', VichFileType::class, array(
                'label' => 'Ajouter votre CV, Fichier de type (.pdf)',
                'required'      => true,
                'allow_delete'  => false,
                'download_link' => false,
            ))
            ->add('firstname')
            ->add('lastname')
            ->add('email')
            ->add('phone')
            ->add('message', TextareaType::class, [
                'label' => 'Votre présentation',
                'attr' => [
                    'rows' =>'5',
                    'cols' => '50'
                ],
             ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Recruitment::class,
        ]);
    }
}
