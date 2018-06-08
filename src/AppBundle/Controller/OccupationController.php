<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Event;
use AppBundle\Entity\User;
use AppBundle\Service\ImportGoogleEvents;
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
     *
     * @Route("dashboard/occupation", name="occupation_dashboard")
     * @param ImportGoogleEvents $importGoogleEvents
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     */
    public function occupationDashboardAction(ImportGoogleEvents $importGoogleEvents)
    {
        $importGoogleEvents->persistEvents();

        return $this->render(':Occupation:occupation.html.twig');
    }

    /**
     * @param EntityManagerInterface $em
     * @param ImportGoogleEvents $importGoogleEvents
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     * @Route("dashboard/occupation/events", name="events_dashboard")
     */
    public function addEventAction(EntityManagerInterface $em, ImportGoogleEvents $importGoogleEvents)
    {
        //Import Google Events
        $importGoogleEvents->persistEvents();

        return $this->render(':Occupation:event.html.twig');
    }

}
