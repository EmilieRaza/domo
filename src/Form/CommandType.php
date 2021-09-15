<?php

namespace App\Form;

use App\Entity\Command;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
class CommandType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            // ->add('orderKey')
            // ->add('firstname')
            // ->add('lastname')
            // ->add('email')
            // ->add('phone')
            // ->add('address')
            // ->add('zipcode')
            // ->add('city')
            // ->add('stripeKey')
            // ->add('createdAt')
            ->add('stape', ChoiceType::class, [
                'label' => 'Statuts des commandes',
                'choices' => [
                    'En attente de paiement' => 'En attente de paiement',
                    'Paiement Accepté' => 'Paiement Accepté',
                    'Commande Expédiée' => 'Commande Expédiée',
                    'Commande Annulée' => 'Commande Annulée',
                    'Commande Remboursée' => 'Commande Remboursée',
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Command::class,
            'translation_domain' => 'forms'
        ]);
    }
}