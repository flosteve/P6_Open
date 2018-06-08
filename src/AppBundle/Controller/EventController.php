<?php

namespace AppBundle\Controller;
use AppBundle\Entity\Task;
use AppBundle\Form\EditUserProfileType;
use AppBundle\Entity\Event;
use AppBundle\Form\EventType;
use AppBundle\Form\TaskType;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class EventController extends Controller
{
    /**
     * Affiche la liste des eevènements
     * @Route("event/list/{type}", name="event_list")
     */
    public function listAction(Request $request, EntityManagerInterface $entityManager, $type)
    {
        $events = $entityManager->getRepository(Event::class)->findAll();
        return $this->render('event/event-list.html.twig', [
            'events' => $events,
            'type' => $type
        ]);
    }


    /**
     * Ajouter un évènement
     * @param Request $request
     * @param EntityManagerInterface $entityManager
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     *
     * @Route("event/add", name="event_add")
     */
    public function addAction(Request $request, EntityManagerInterface $entityManager)
    {
        $event = new Event();
        $form = $this->createForm(EventType::class, $event);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $entityManager->persist($event);
            $entityManager->flush();

            $this->addFlash('success', 'L\'évènement a bien été rajouté');

            return $this->redirectToRoute('event_list', [
                'type' => 'table'
            ]);
        }

        return $this->render('event/add.html.twig', [
            'form' => $form->createView()
        ]);
    }
    /**
     * Affiche les détails d'un évènement
     *
     * @param  Event $event
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("event/show/{event}", name="event_show")
     */
    public function showAction(Event $event)
    {
     return $this->render('event/show.html.twig', [
         'event' => $event
     ]);
    }

    /**
     * Modifier les informations d'une tâche
     *
     * @param Event $event
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("event/edit/{event}", name="event_edit")
     */
    public function editAction(Event $event, EntityManagerInterface $entityManager, Request $request)
    {
        $form = $this->createForm(EventType::class, $event);
        $form->handleRequest($request);

        if ($form->isValid() && $form->isSubmitted())
        {
            $entityManager->flush();
            $this->addFlash('success','L\'évènement a été modifié avec succès');
            return $this->redirectToRoute('event_list', [
                'type' => 'table'
            ]);
        }

        return $this->render('event/edit.html.twig', [
            'event' => $event,
            'form' => $form->createView()
        ]);
    }

    /**
     * Supprimer une tâche
     * @param Event $event
     * @param EntityManagerInterface $entityManager
     *
     * @Route("event/delete/{event}", name="event_delete")
     */
    public function deleteAction(Event $event, EntityManagerInterface $entityManager)
    {
        $deletedEvent = $entityManager->getRepository(Event::class)->find($event->getId());
        $entityManager->remove($deletedEvent);
        $entityManager->flush();

        $this->addFlash('success','L\'évènement a été supprimé avec succès');

        return $this->redirectToRoute('event_list', 'table');
    }

}
