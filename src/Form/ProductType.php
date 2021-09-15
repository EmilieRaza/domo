<?php

namespace App\Form;

use App\Entity\Size;
use App\Entity\Weight;
use App\Entity\Product;
use App\Entity\Category;
use App\Entity\Gamme;
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
                'required' => false 
            ])
            ->add('solde', TextType::class, [
                'required' => false 
            ])
            ->add('isHome', CheckboxType::class, [
                'label' => 'En stock',
                'required' => False
            ])
            ->add('isActive', CheckboxType::class, [
                'label'        => 'En ligne',
                'required' => False
            ])
            ->add('isNewProduct', CheckboxType::class, [
                'label'        => 'Nouveau produit',
            ])
            ->add('withDelivery', CheckboxType::class, [
                'label'        => 'Livraison',
                'required' => false 
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
            ->add('humitestEnAction', TextareaType::class, [
                'attr' => ['class' => 'ckeditor'],
                'label'        => 'Humitest en action',
            ])
            ->add('gammeProduct', EntityType::class, [
                'label' => 'Gamme',
                'required' => True,
                'class' => Gamme::class,
                'expanded' => false,
                'multiple' => false,
                'placeholder' => 'Choisir une gamme'
            ])
            ->add('linkVideo', TextType::class, [
                'label'        => 'URL de la video (Youtube)',
                'required' => False,
            ]);

            if($options['isFlagship']){
                $builder
                ->add('isFlagship');
            }
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Product::class,
            'translation_domain' => 'forms',
            'isFlagship' => False,
        ]);

        $resolver->setRequired([
            'update',
        ]);
    }
}