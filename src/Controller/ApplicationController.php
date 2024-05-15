<?php

/*
* Форма заполнения пользовательской заявки
*/

namespace App\Controller;

use App\Entity\Application;
use App\Form\ApplicationFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\ORM\EntityManagerInterface;

class ApplicationController extends AbstractController
{
    #[Route('/application', name: 'app_application')]
    public function index(Request $request, EntityManagerInterface $entityManager): Response
    {
        /* Авторизация пользователя */
        $this->denyAccessUnlessGranted('ROLE_USER');
        $user = $this->getUser();

        /* Попытка загрузки ранее сохранённой заявки */
        $application_collection = $user->getApplications();
        $application = $application_collection->current();

        /* Если не удалось найти, создать новую заявку */
        if(!$application) {
            $application = new Application();
            $application->setFIO($user->getFIO()); // Значение ФИО по умолчанию.
        }   

        /* Создание формы */
        $form = $this->createForm(ApplicationFormType::class, $application);

        /* Обработка формы */
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            /* Связывание сущностей пользователя и заявки */
            $application->setUserId($user);
            $user->addApplication($application);

            /* Сохранение заявки в БД */
            $entityManager->persist($application);
            $entityManager->flush();

            /* Переход на страницу редактора карты */
            return $this->redirectToRoute('app_map_editor');
        }


        /* Отображение страницы */
        return $this->render('application/application.html.twig', [
            'form' => $form,
        ]);
    }
}
