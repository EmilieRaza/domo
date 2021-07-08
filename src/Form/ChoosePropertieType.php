<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class ChoosePropertieType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('choose', ChoiceType::class, [
            'label' => 'Choisir un type de bien',
            'choices' => [
                'Terrain' => 'Terrain',
                'Villa / Maison' => 'Villa ou Maison',
                'Appartement' => 'Appartement',
                'Immeuble' => 'Immeuble',
                'Bureau' => 'Bureau',
                'Local commercial' => 'Local commercial'
            ]
        ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
