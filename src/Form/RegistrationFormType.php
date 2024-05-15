<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder

            ->add('username', TextType::class, [
                'constraints' => [
                    new NotBlank([
                        'message' => 'Введите логин.',
                    ]),
                    new Length([
                        'min' => 2,
                        'minMessage' => 'Ваш логин должен содержать не менее {{ limit }} символов.',
                        'max' => 20,
                        'maxMessage' => 'Ваш логин должен содержать не более {{ limit }} символов.',
                    ]),
                    new Regex([
                        'pattern' => '/^([a-z]|\d)+$/',
                        'message' => 'Логин должен включать прописные латинские буквы или цифры.',
                    ]),
                ],
            ])

            ->add('password', PasswordType::class, [
                // instead of being set onto the object directly,
                // this is read and encoded in the controller
                'mapped' => false,
                'attr' => ['autocomplete' => 'new-password'],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Введите пароль.',
                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Ваш пароль должен содержать не менее {{ limit }} символов.',
                        'max' => 20,
                        'maxMessage' => 'Ваш пароль должен содержать не более {{ limit }} символов.',
                    ]),
                ],
            ])

            ->add('fio', TextType::class, [
                'constraints' => [
                    new NotBlank([
                        'message' => 'Введите ФИО.',
                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Ваше ФИО должно содержать не менее {{ limit }} символов.',
                        'max' => 100,
                        'maxMessage' => 'Ваш пароль должен содержать не более {{ limit }} символов.',
                    ]),
                    new Regex([
                        'pattern' => '/^[А-ЯЁ][а-яё]+\s[А-ЯЁ][а-яё]+\s[А-ЯЁ][а-яё]+$/u',
                        'message' => 'ФИО должно быть написано на кириллице с большой буквы через пробел, например "Иванов Иван Иванович".',
                    ]),
                ],
            ])
        ;

    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
