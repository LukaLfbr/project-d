<?php

namespace App\Controller;

use App\Repository\TasksRepository;
use App\Entity\Tasks;
use App\Form\TasksType;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\Entity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class TasksController extends AbstractController
{
    #[Route('/tasks', name: 'app_tasks')]
    public function index(TasksRepository $repository, EntityManagerInterface $em): Response
    {

        $tasks = $repository->findAll();

        // Si besoin de modifier la description manuellement
        // $tasks[0]->setDescription('Aller faire des petites couses pour la semaine');

        // Si besoin de modifier la date manuellement
        // $limitDateSetter = DateTime::createFromFormat('Y-m-d', '2024-03-20');
        // $tasks[0]->setLimitDate($limitDateSetter);

        // Si besoin de remove
        // $em->remove($tasks[x])

        // $em->flush();

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

    #[Route('/tasks/addtask', name: 'addtask')]
    public function addTask(Request $request, EntityManagerInterface $em): Response
    {

        $task = new Tasks();
        // Associe les données du formulaire aux données dans l'objet task
        $form = $this->createForm(TasksType::class, $task);
        // Récupère les données dans l'url
        $form->handleRequest($request);

        if ($form->isSubmitted() and $form->isValid()) {
            $em->persist($task);
            $em->flush();
            return $this->redirectToRoute('app_tasks');
        }

        return $this->render('/tasks/addTasks.html.twig', [

            'form' => $form,
        ]);
    }

    #[Route("/tasks/delete{id}", name: "deleteTask")]
    public function deleteTask(Tasks $task, EntityManagerInterface $em): Response
    {
        $em->remove($task);
        $em->flush();

        return $this->redirectToRoute('app_tasks');
    }
}
