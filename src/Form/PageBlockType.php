<?php

namespace App\Form;

use App\Entity\PageBlock;
use Symfony\Component\Form\AbstractType;
use Vich\UploaderBundle\Form\Type\VichFileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class PageBlockType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, [
                'label' => 'titre H2 - (facultatif)',
            ])
            ->add('content', TextareaType::class, [
                'attr' => ['class' => 'ckeditor'],
            ])
            ->add('moreTitle')
            ->add('moreContent')
            ->add('pdfTitle')
            ->add('pdfFile', VichFileType::class, array(
                'label' => 'Ajouter une plaquette, Fichier de type (.pdf) - (facultatif)',
                'required'      => false,
                'allow_delete'  => true,
                'download_link' => true,
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => PageBlock::class,
            'translation_domain' => 'forms'
        ]);
    }
}