<?php

namespace App\Form;

use App\Entity\Contact;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstname',TextType::class,[
                'label' => 'Nom',
            ])
            ->add('lastname',TextType::class,[
                'label' => 'Prenom',
            ])
            ->add('email',TextType::class,[
                'label' => 'Email',
            ])
            ->add('phone',TextType::class,[
                'label' => 'Téléphone',
            ])
            ->add('fonction',TextType::class,[
                'label' => 'Fonction',
            ])
            ->add('type', ChoiceType::class, [
                'label' => 'Type de demande',
                'choices' => [
                    'Demande d\'information générale' => 'Demande d\'information générale',
                    'Demande d\'information tarifaire' => 'Demande d\'information tarifaire',
                    'Proposition commerciale' => 'Proposition commerciale',
                    'Autre' => 'Autre',
                ],
            ])
            ->add('message', TextareaType::class, [
                'label' => 'Votre message',
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
            'data_class' => Contact::class,
        ]);
    }
}
