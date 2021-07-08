<?php

namespace App\Form;

use App\Entity\Size;
use App\Entity\Weight;
use App\Entity\Product;
use App\Entity\Category;
use App\Form\CategoryType;
use App\Form\ProductImageType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;

class ProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('category', EntityType::class, [
                'class' => Category::class,
                'placeholder' => "Choisir une categorie",
                'multiple' => false,  
                'expanded' => false
                
            ])

            ->add('price', TextType::class, [
                'label'        => 'Prix',
            ])
            ->add('priceCustomer', TextType::class, [
                'label'        => 'Prix client',
            ])
            ->add('solde')
            ->add('isHome')
            ->add('isActive', CheckboxType::class, [
                'label'        => 'En ligne',
            ])
            ->add('withDelivery', CheckboxType::class, [
                'label'        => 'Livraison',
            ])
            ->add('images', CollectionType::class, [
                'entry_type'   => ProductImageType::class,
                'entry_options'  => [
                    'label' => false,
                ],
                'label'        => 'Ajouter vos images',
                'allow_add'    => true,
                'allow_delete' => true,
                'prototype'    => true,
                'by_reference' => false,
                'required' => !$options['update'],
                'attr'         => [
                    'class' => "image-collection",
                ]
            ])
            ->add('shortDesc', TextareaType::class, [
                'attr' => ['class' => 'ckeditor'],
                'label'        => 'Description courte',
            ])
            ->add('gamme', ChoiceType::class, [
                'label' => 'Gamme',
                'choices' => [
                    'Bâtiment-Immobilier' => 'Bâtiment-Immobilier',
                    'Industrie' => 'Industrie',
                    'Biomasse' => 'Biomasse',
                    'Agro-Alimentaire' => 'Agro-Alimentaire'
                ],
                'placeholder' => 'Choisir une gamme'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Product::class,
            'translation_domain' => 'forms'
        ]);

        $resolver->setRequired([
            'update',
        ]);
    }
}