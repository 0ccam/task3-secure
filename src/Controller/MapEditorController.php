<?php

/*
* Редактор карты
*/

namespace App\Controller;

use App\Entity\User;
use App\Entity\Blank;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\ORM\EntityManagerInterface;

class MapEditorController extends AbstractController
{
    #[Route('/map/editor', name: 'app_map_editor')]
    public function index(Request $request, EntityManagerInterface $entityManager): Response
    {
        /* Авторизация пользователя */
        $this->denyAccessUnlessGranted('ROLE_USER');
        $user = $this->getUser();

        /* Попытка загрузки ранее сохранённой заявки */
        $application_collection = $user->getApplications();
        $application = $application_collection->current();

        /* Если не удалось найти, перейти на страницу создания заявки */
        if(!$application) return $this->redirectToRoute('app_application');

        /* Получение координат от скрипта*/
        $str_ltd = $request->query->get('ltd'); // Широта.
        $str_lng = $request->query->get('lng'); // Долгота.

        /* Проверка корректности координат */
        $pattern = "/^-?\d{1,2}(\.\d+)*$/";
        if (preg_match($pattern, $str_ltd) and 
            preg_match($pattern, $str_lng))
        {
            $float_ltd = floatval($str_ltd);
            $float_lng = floatval($str_lng);
            if (abs($float_ltd) < 90 and
                abs($float_lng) < 180)
            {
                /* Добавление координат к заявке */
                $application->setLatitude($float_ltd);
                $application->setLongitude($float_lng);

                /* Сохранение заявки в БД */
                $entityManager->persist($application);
                $entityManager->flush();

                /* Переход на главную страницу */
                return $this->redirectToRoute('app_main');
            }
        }


        /* Отображение страницы */
        return $this->render('map_editor/map_editor.html.twig', [
            'controller_name' => 'MapEditorController',
        ]);
    }
}
