<?php
/**
 * Created by PhpStorm.
 * User: EravilleSteve
 * Date: 08/03/2018
 * Time: 16:09
 */

namespace AppBundle\Listener;



use AncaRebeca\FullCalendarBundle\Event\CalendarEvent;
use AncaRebeca\FullCalendarBundle\Model\FullCalendarEvent;
use AncaRebeca\FullCalendarBundle\Model\Event as ScheduledEvent;
use AppBundle\Entity\Event;
use AppBundle\Entity\Meeting;
use Doctrine\ORM\EntityManagerInterface;
use Fungio\GoogleCalendarBundle\FungioGoogleCalendarBundle;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Validator\Constraints\DateTime;

class LoadDataListener
{
    private $entityManager;

    /**
     * LoadDataListener constructor.
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }
    /**
     * @param CalendarEvent $calendarEvent
     *
     * @return FullCalendarEvent[]
     */
    public function loadData(CalendarEvent $calendarEvent)
    {

        $events = $this->entityManager->getRepository(Event::class)->findAll();


        foreach ($events as $event)
        {
            //Compare to see if Full day event
            $startDate = $event->getStartAt();
            $endDate = $event->getEndAt();
            $interval = $startDate->diff($endDate);
            $intervalInt = intval($interval->format('%h')) ;
            $startDate->format(\DateTime::ISO8601);
            $endDate->format(\DateTime::ISO8601);
            $eventEntity = new ScheduledEvent($event->getName(), $startDate);


            // if not all day event
            if ($intervalInt <= 8 && $intervalInt !== 0) {
                $eventEntity->setAllDay(false);
            }

            $eventEntity->setEndDate($endDate);
            $eventEntity->setEditable(true);
            $eventEntity->setStartEditable(true);
            $eventEntity->setDurationEditable(true);

            $calendarEvent->addEvent($eventEntity);
        }

        return $calendarEvent->getEvents();

    }

}