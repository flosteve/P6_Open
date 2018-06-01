<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Event;
use AppBundle\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Fungio\GoogleCalendarBundle\DependencyInjection\FungioGoogleCalendarExtension;
use Fungio\GoogleCalendarBundle\FungioGoogleCalendarBundle;
use http\Env\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;

class OccupationController extends Controller
{

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("dashboard/occupation", name="occupation_dashboard")
     */
    public function occupationDashboardAction()
    {
        $user = $this->getUser();
        return $this->render(':Occupation:occupation.html.twig', [
            'user' => $user
        ]);
    }

    /**
     * @param EntityManagerInterface $em
     * @param FungioGoogleCalendarBundle $calendarBundle
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("dashboard/occupation/events", name="events_dashboard")
     */
    public function addEventAction(EntityManagerInterface $em)
    {

        $googleCalendar = $this->googleCalendarAuthorizationAction();
        $now = new \DateTime();
//        $currentDate = $now->format('Y-m-dTH:i:s.fffZ');
        $currentDate = $now->format(\DateTime::RFC3339);

        $eventsGoogle =  $googleCalendar->initEventsList('primary', ['maxResults' => 100, 'orderBy' => 'startTime', 'singleEvents' => true, 'timeMin' => $currentDate]);



        foreach ($eventsGoogle as $eventGoogle){
            $event = new Event();
            $event->setName($eventGoogle->getSummary());

            if (!$eventGoogle->getStart()->getDateTime()){
                $start = new \DateTime($eventGoogle->getStart()->getDate());
                $end = new \DateTime($eventGoogle->getEnd()->getDate());
//                $start->setTime(00,00,00);
//                $end->setTime(23,59,59);
                $end->sub(new \DateInterval('PT1S'));
                $event->setStartAt($start);
                $event->setEndAt($end);
            } else {
                $event->setStartAt(new \DateTime($eventGoogle->getStart()->getDateTime()));
                $event->setEndAt(new \DateTime($eventGoogle->getEnd()->getDateTime()));
            }
            $event->setIdGoogle($eventGoogle->getId());

            //Event with same ID
//            $even = $this->getDoctrine()->getRepository(Event::class)->findOneBy(['idGoogle' => $event->getIdGoogle()]);
            if (!$this->getDoctrine()->getRepository(Event::class)->findOneBy(['idGoogle' => $event->getIdGoogle()])){
                $em->persist($event);
                $em->flush();
            }

         }

        return $this->render(':Occupation:event.html.twig');
    }

    /**
     * @return \Fungio\GoogleCalendarBundle\Service\GoogleCalendar|object|RedirectResponse
     */
    public function googleCalendarAuthorizationAction()
    {
        $request = $this->get('request_stack')->getMasterRequest();

        $googleCalendar = $this->get('fungio.google_calendar');
        $redirectUri = 'http://p6.openclassrooms/app_dev.php/dashboard/1';
        $googleCalendar->setRedirectUri($redirectUri);

        if ($request->query->has('code') && $request->get('code')) {
            $client = $googleCalendar->getClient($request->get('code'));
        } else {
            $client = $googleCalendar->getClient();
        }

        if (is_string($client)) {
            return new RedirectResponse($client);
        }

        return $googleCalendar;

    }

}
