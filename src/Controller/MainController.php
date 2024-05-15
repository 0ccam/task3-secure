<?php

/*
* Главная страница
*/

namespace App\Controller;

use App\Entity\Application;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\ORM\EntityManagerInterface;

class MainController extends AbstractController
{
    #[Route('/', name: 'app_main')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        /* Получение списка всех заявок */
        $repository = $entityManager->getRepository(Application::class);
        $markers = $repository->findAll();

        /* Отображение страницы */
        return $this->render('main/main.html.twig', [
            'markers' => $markers
        ]);
    }
}
