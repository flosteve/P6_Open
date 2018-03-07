<?php

namespace AppBundle\Controller;
use AppBundle\Entity\Task;
use AppBundle\Entity\User;
use AppBundle\Form\EditUserProfileType;
use AppBundle\Form\TaskType;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class TaskController extends Controller
{
    /**
     * Affiche la lste des taches
     * @Route("task/list", name="task_list")
     */
    public function listAction(Request $request, EntityManagerInterface $entityManager)
    {
        $tasks = $entityManager->getRepository(Task::class)->findAll();
        return $this->render('task/task-list.html.twig', [
            'tasks' => $tasks
        ]);
    }

    /**
     * Ajouter unetâche
     * @param Request $request
     * @param EntityManagerInterface $entityManager
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     *
     * @Route("task/add", name="task_add")
     */
    public function addAction(Request $request, EntityManagerInterface $entityManager)
    {
        $task = new Task();
        $form = $this->createForm(TaskType::class, $task);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $entityManager->persist($task);
            $entityManager->flush();

            return $this->redirectToRoute('task_list');
        }

        return $this->render('task/add.html.twig', [
            'form' => $form->createView()
        ]);
    }
    /**
     * Affiche les détails d'une tâche
     *
     * @param Task $task
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("task/show/{task}", name="task_show")
     */
    public function showAction(Task $task)
    {
     return $this->render('task/show.html.twig', [
         'task' => $task
     ]);
    }

    /**
     * Modifier les informations d'une tâche
     *
     * @param Task $task
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("task/edit/{task}", name="task_edit")
     */
    public function editAction(Task $task, EntityManagerInterface $entityManager, Request $request)
    {
        $form = $this->createForm(EditUserProfileType::class, $task);
        $form->handleRequest($request);

        if ($form->isValid() && $form->isSubmitted())
        {
            $entityManager->flush();
            $this->addFlash('success','L\'utilisateur a été supprimé avec succès');
            return $this->redirectToRoute('user_list');
        }

        return $this->render('task/edit.html.twig', [
            'task' => $task,
            'form' => $form->createView()
        ]);
    }

    /**
     * Supprimer une tâche
     * @param Task $task
     * @param EntityManagerInterface $entityManager
     *
     * @Route("task/delete/{task}", name="task_delete")
     */
    public function deleteAction(Task $task, EntityManagerInterface $entityManager)
    {
        $deletedUser = $entityManager->getRepository(User::class)->find($task->getId());
        $entityManager->remove($deletedUser);
        $entityManager->flush();

        $this->addFlash('success','L\'utilisateur a été supprimé avec succès');

        return $this->redirectToRoute('user_list');
    }

}
