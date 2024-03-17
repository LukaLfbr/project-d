<?php

namespace App\Controller;

use App\Repository\TasksRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class TasksController extends AbstractController
{
    #[Route('/tasks', name: 'app_tasks')]
    public function index(TasksRepository $repository): Response
    {

        $tasks = $repository->findAll();


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
