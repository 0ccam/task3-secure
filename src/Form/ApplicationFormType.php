<?php

namespace App\Form;

use App\Entity\Application;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;

class ApplicationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
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
            ->add('text', TextareaType::class, [
                'attr' => ['cols' => '50', 'rows' => '10',],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Введите текст заявки.',
                    ]),
                    new Length([
                        'max' => 200,
                        'maxMessage' => 'Текст заявки должен содержать не более {{ limit }} символов.',
                    ]),
                ],
            ])
            ->add('city', TextType::class, [
                'constraints' => [
                    new NotBlank([
                        'message' => 'Введите название города.',
                    ]),
                    new Length([
                        'max' => 30,
                        'maxMessage' => 'Название города должно содержать не более {{ limit }} символов.',
                    ]),
                ],
            ])
            ->add('address', TextType::class, [
                'constraints' => [
                    new NotBlank([
                        'message' => 'Введите адрес.',
                    ]),
                    new Length([
                        'max' => 100,
                        'maxMessage' => 'Адрес должен содержать не более {{ limit }} символов.',
                    ]),
                ],
            ])
            ->add('submit', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Application::class,
        ]);
    }
}
