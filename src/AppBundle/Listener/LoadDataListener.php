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

class LoadDataListener
{
    private $entityManager;

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
//        $startDate = $calendarEvent->getStartAt();
//        $endDate = $calendarEvent->getEndAt();
//        $filters = $calendarEvent->getFilters();

        //You may want do a custom query to populate the events
        $allEvents = $this->entityManager->getRepository(Meeting::class)->findAll();

        foreach ($allEvents as $event)
        {
            $calendarEvent->addEvent(new ScheduledEvent($event->getName(), $event->getStartAt()));
        }

    }

}