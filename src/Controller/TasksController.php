<?php

namespace App\Controller;

use App\Repository\TasksRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class TasksController extends AbstractController
{
    #[Route('/tasks', name: 'app_tasks')]
    public function index(TasksRepository $repository, EntityManagerInterface $em): Response
    {

        $tasks = $repository->findAll();

        // Si besoin de modifier la description manuellement
        $tasks[0]->setDescription('Aller faire des petites couses pour la semaine');

        // Si besoin de modifier la date manuellement
        $limitDateSetter = DateTime::createFromFormat('Y-m-d', '2024-03-20');
        $tasks[0]->setLimitDate($limitDateSetter);

        // Si besoin de remove
        // $em->remove($tasks[x])

        $em->flush();

        return $this->render('tasks/tasks.html.twig', [
            'controller_name' => 'TasksController',
            'tasks' => $tasks

        ]);
    }

    #[Route('/tasks/timeleft', name: 'sortByTimeLeft')]
    public function showTimeLeft(TasksRepository $repository): Response
    {

        $tasks = $repository->sortByTimeLeft();


        return $this->render('tasks/tasks.html.twig', [
            'controller_name' => 'TasksController',
            'tasks' => $tasks

        ]);
    }
}
