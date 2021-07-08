<?php

namespace App\Form;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Component\Form\FormError;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Callback;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

class RegistrationType extends AbstractType
{

    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
            $this->userRepository = $userRepository;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder

            ->add('firstname', TextType::class, [
                'attr' => ['placeholder' => 'Prénom']
            ])

            ->add('lastname', TextType::class, [
                'attr' => ['placeholder' => 'Nom']
            ])

            ->add('company', TextType::class, [
                'attr' => ['placeholder' => 'Entreprise']
            ])

            ->add('phone', TextType::class, [
                'attr' => ['placeholder' => 'Téléphone']
            ])

            ->remove('username')

            ->add('email', TextType::class, [
                'attr' => ['placeholder' => 'Email']
            ]);
    }

    public function getParent()
    {
        return 'FOS\UserBundle\Form\Type\RegistrationFormType';
    }

    public function getBlockPrefix()
    {
        return 'app_user_registration';
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
            'constraints' => [
                new Callback([$this, 'validate']),
            ],
        ]);
    }

    public function validate(User $user, ExecutionContextInterface $context)
    {
        $form = $context->getRoot();

        $checkEmail = $this->userRepository->findByEmail($user->getEmail());

        if (!preg_match('/^(?:(?:\+|00)33|0)\s*[1-9](?:[\s.-]*\d{2}){4}$/', $user->getPhone())) {
            $form->get('phone')->addError(
                new FormError("Le numero de téléphone n'est pas valide !")
            );
        }

        if(!empty($checkEmail))
        {
            $form->get('email')->addError(
                new FormError("Cette Email est déjà utilisé !")
            );
        }
    }
}
