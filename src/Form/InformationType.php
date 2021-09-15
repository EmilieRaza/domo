<?php

namespace App\Form;

use App\Entity\Information;
use App\Entity\Promotional;
use Symfony\Component\Form\FormError;
use Symfony\Component\Form\AbstractType;
use App\Repository\PromotionalRepository;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Callback;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

class InformationType extends AbstractType
{
    private $promotionalRepository;
    private $security;

    public function __construct(PromotionalRepository $promotionalRepository, Security $security){
        $this->promotionalRepository = $promotionalRepository;
        $this->security = $security;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstname',TextType::class,[
                'label' => false,
                'attr' => array(
                    'placeholder' => 'Nom'
                )

            ])
            ->add('lastname',TextType::class,[
                'label' => false,
                'attr' => array(
                    'placeholder' => 'Prénom'
                )

            ])
            ->add('email',TextType::class,[
                'label' => false,
                'attr' => array(
                    'placeholder' => 'Email'
                )

            ])
            ->add('phone',TextType::class,[
                'label' => false,
                'attr' => array(
                    'placeholder' => 'Téléphone'
                )

            ])
            ->add('address',TextType::class,[
                'label' => false,
                'attr' => array(
                    'placeholder' => 'Adresse'
                )

            ])
            ->add('zipcode',TextType::class,[
                'label' => false,
                'attr' => array(
                    'placeholder' => 'CP'
                )
            ])
            ->add('city',TextType::class,[
                'label' => false,
                'attr' => array(
                    'placeholder' => 'Ville'
                )
            ])
            // ->add('code', TextType::class,[
            //     'required' => false,
            //     'label' => false,
            //         'attr' => array(
            //             'placeholder' => 'Code Promo'
            //         )
            // ])
            ->add('termsAccepted', CheckboxType::class, [
                'mapped' => false,
                'constraints' => new IsTrue(),
                'label' => 'En cochant cette case, vous acceptez :'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Information::class,
            'translation_domain' => 'forms',
            'constraints' => [
                new Callback([$this, 'validate']),
            ],
        ]);
    }

    public function validate(Information $information, ExecutionContextInterface $context)
    {
         $form = $context->getRoot();

         $msg1 = 'Erreur! Le code promo n\'est pas valide';
         $msg2 = 'Erreur! Connectez-vous pour ce code promo!';
         $code = $information->getCode();
         if(!empty($code)){
            $promotional = $this->promotionalRepository->findOneByCode($code);
            if(!empty($promotional)){
                if($promotional->getIsCustomer()){
                    if(!$this->security->isGranted('ROLE_CUSTOMER')){
                        $form->get('code')->addError(
                            new FormError($msg2)
                        );
                    }
                }
            }else{
                $form->get('code')->addError(
                    new FormError($msg1)
                );
            }
         }
         
    }
}
