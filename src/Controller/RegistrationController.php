<?php

/*
* Форма регистрации пользователя
*/

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;

class RegistrationController extends AbstractController
{
    #[Route('/register', name: 'app_register')]
    public function register(Request $request, UserPasswordHasherInterface $userPasswordHasher, Security $security, EntityManagerInterface $entityManager): Response
    {
        /* Создание формы */
        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);

        /* Обработка формы */
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            /* Хэширование пароля */
            $password = $form->get('password')->getData();
            $hash = $userPasswordHasher->hashPassword($user, $password);
            $user->setPassword($hash);

            /* Сохранение пользователя в БД */
            $entityManager->persist($user);
            $entityManager->flush();

            /* Перход на страницу входа */
            return $this->redirectToRoute('app_login');
            //return $security->login($user, 'form_login', 'main');
        }


        /* Отображение страницы */
        return $this->render('registration/register.html.twig', [
            'form' => $form,
        ]);
    }
}
