<?php

namespace AppBundle\Controller;
use AppBundle\Entity\Meeting;
use AppBundle\Entity\Task;
use AppBundle\Form\EditUserProfileType;
use AppBundle\Entity\Event;
use AppBundle\Form\EventType;
use AppBundle\Form\MeetingType;
use AppBundle\Form\TaskType;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class MeetingController extends Controller
{
    /**
     * Affiche la liste des eevènements
     * @Route("meeting/list/{type}", name="meeting_list")
     */
    public function listAction(Request $request, EntityManagerInterface $entityManager, $type)
    {
        $meetings = $entityManager->getRepository(Meeting::class)->findAll();
        return $this->render('meeting/meeting-list.html.twig', [
            'meetings' => $meetings,
            'type' => $type
        ]);
    }


    /**
     * Ajouter un évènement
     * @param Request $request
     * @param EntityManagerInterface $entityManager
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     *
     * @Route("meeting/add", name="meeting_add")
     */
    public function addAction(Request $request, EntityManagerInterface $entityManager)
    {
        $meeting = new Meeting();
        $form = $this->createForm(MeetingType::class, $meeting);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $entityManager->persist($meeting);
            $entityManager->flush();

            $this->addFlash('success', 'L\'évènement a bien été rajouté');

            return $this->redirectToRoute('meeting_list', [
                'type' => 'table'
            ]);
        }

        return $this->render('meeting/add.html.twig', [
            'form' => $form->createView()
        ]);
    }
    /**
     * Affiche les détails d'un évènement
     *
     * @param  Meeting $meeting
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("meeting/show/{meeting}", name="meeting_show")
     */
    public function showAction(Meeting $meeting)
    {
     return $this->render('meeting/show.html.twig', [
         'meeting' => $meeting
     ]);
    }

    /**
     * Modifier les informations d'une tâche
     *
     * @param Meeting $meeting
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("meeting/edit/{meeting}", name="meeting_edit")
     */
    public function editAction(Meeting $meeting, EntityManagerInterface $entityManager, Request $request)
    {
        $form = $this->createForm(MeetingType::class, $meeting);
        $form->handleRequest($request);

        if ($form->isValid() && $form->isSubmitted())
        {
            $entityManager->flush();
            $this->addFlash('success','L\'évènement a été modifié avec succès');
            return $this->redirectToRoute('meeting_list', [
                'type' => 'table'
            ]);
        }

        return $this->render('meeting/edit.html.twig', [
            'meeting' => $meeting,
            'form' => $form->createView()
        ]);
    }

    /**
     * Supprimer une tâche
     * @param Meeting $meeting
     * @param EntityManagerInterface $entityManager
     *
     * @Route("meeting/delete/{meeting}", name="meeting_delete")
     */
    public function deleteAction(Meeting $meeting, EntityManagerInterface $entityManager)
    {
        $deletedEvent = $entityManager->getRepository(Event::class)->find($meeting->getId());
        $entityManager->remove($deletedEvent);
        $entityManager->flush();

        $this->addFlash('success','L\'évènement a été supprimé avec succès');

        return $this->redirectToRoute('meeting_list', [
            'type' => 'table'
        ]);
    }

}
