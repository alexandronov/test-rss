<?php

namespace App\Form;

use App\Entity\User;
use App\Validator\Constraint\UniqueValueInEntity;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\NotBlank;

class EmailValidationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', TextType::class, [
                'constraints' => [
                    new NotBlank([
                        'message' => 'This email is invalid',
                    ]),
                    new Email([
                        'message' => 'This email is invalid',
                    ]),
                    new UniqueValueInEntity([
                        'field' => 'email',
                        'entityClass' => User::class,
                        'message' => 'This email is already in use',
                    ]),
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefault('csrf_protection', false);

        parent::configureOptions($resolver);
    }
}
