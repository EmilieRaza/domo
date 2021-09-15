<?php

namespace App\Form;

use App\Entity\Gamme;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Vich\UploaderBundle\Form\Type\VichImageType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class GammeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name');
            // ->add('content', TextareaType::class, [
            //     'attr' => ['class' => 'ckeditor'],
            // ])
            // ->add('imageFile', VichImageType::class, array(
            //     'label' => 'Ajouter image de type (.jpg)',
            //     'required'      => false,
            //     'allow_delete'  => false,
            //     'download_link' => false,
            // ));
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Gamme::class,
            'translation_domain' => 'forms'
        ]);
    }
}