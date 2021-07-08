<?php

namespace App\Form;

use App\Entity\Page;
use App\Form\PageBlockType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class PageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('metaTitle')
            ->add('metaDescription')
            ->add('title')
            ->add('type', ChoiceType::class, [
                'label' => 'Type de page',
                'choices' => [
                    'Page de contenue' => 'content',
                    'Page d\'information (Ex: CGV)' => 'information',
                ],
            ])
            ->add('pageBlocks', CollectionType::class, [
                'entry_type'   => PageBlockType::class,
                'entry_options'  => [
                    'label' => false,
                ],
                'label'        => 'Ajouter plusieurs champs pour créer votre page',
                'allow_add'    => true,
                'allow_delete' => true,
                'prototype'    => true,
                'by_reference' => false,
                'required'     => false,
                'attr'         => [
                    'class' => "page-collection",
                ]
            ])
        ;

        if($options['is_active']){
            $builder
                ->add('isActive')
            ;
        }
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Page::class,
            'is_active' => true, 
            'translation_domain' => 'forms'
        ]);
    }
}