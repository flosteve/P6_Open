<?php
/**
 * User: EravilleSteve
 * Date: 08/06/2018
 * Time: 10:59
 */

namespace AppBundle\Service;


use AppBundle\Entity\Event;
use Doctrine\ORM\EntityManagerInterface;
use Fungio\GoogleCalendarBundle\DependencyInjection\FungioGoogleCalendarExtension;
use Fungio\GoogleCalendarBundle\FungioGoogleCalendarBundle;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\RequestStack;

class ImportGoogleEvents
{
    /**
     * @var RequestStack
     */
    private $requestStack;
    /**
     * @var ContainerInterface
     */
    private $container;
    /**
     * @var EntityManagerInterface
     */
    private $em;


    /**
     * ImportGoogleEvents constructor.
     * @param RequestStack $requestStack
     * @param ContainerInterface $container
     * @param EntityManagerInterface $em
     */
    public function __construct(RequestStack $requestStack, ContainerInterface $container, EntityManagerInterface $em)
    {
        $this->requestStack = $requestStack;
        $this->container = $container;
        $this->em = $em;
    }

    /**
     * Get Google events from online Calendar
     * @return object
     */
    public function getGoogleEvents()
    {
        $googleCalendar = $this->googleCalendarAuthorizationAction();
        $now = new \DateTime();
        $currentDate = $now->format(\DateTime::RFC3339);

        $eventsGoogle =  $googleCalendar->initEventsList('primary', [
            'maxResults' => 100, 'orderBy' => 'startTime',
            'singleEvents' => true,
            'timeMin' => $currentDate
        ]);

        return $eventsGoogle;
    }

    /**
     * Import Events into Database
     * @throws \Exception
     */
    public function persistEvents()
    {
        $eventsGoogle = $this->getGoogleEvents();

        foreach ($eventsGoogle as $eventGoogle){
            $event = new Event();
            $event->setName($eventGoogle->getSummary());

            //If it's not existing
            if (!$eventGoogle->getStart()->getDateTime()){
                $start = new \DateTime($eventGoogle->getStart()->getDate());
                $end = new \DateTime($eventGoogle->getEnd()->getDate());

                $end->sub(new \DateInterval('PT1S'));
                $event->setStartAt($start);
                $event->setEndAt($end);
            } else {
                $event->setStartAt(new \DateTime($eventGoogle->getStart()->getDateTime()));
                $event->setEndAt(new \DateTime($eventGoogle->getEnd()->getDateTime()));
            }
            $event->setIdGoogle($eventGoogle->getId());

            //Event with same ID

            if (!$this->em->getRepository(Event::class)->findOneBy(['idGoogle' => $event->getIdGoogle()])){

                $this->em->persist($event);
                $this->em->flush();
            }

        }

    }

    /**
     * Connexion to Google calendar API
     * @return \Fungio\GoogleCalendarBundle\Service\GoogleCalendar|object|RedirectResponse
     */
    public function googleCalendarAuthorizationAction()
    {
        $request = $this->requestStack->getMasterRequest();
//        $request = $this->get('request_stack')->getMasterRequest();

        $googleCalendar = $this->container->get('fungio.google_calendar');
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