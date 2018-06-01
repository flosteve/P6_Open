<?php
/**
 * Created by PhpStorm.
 * User: EravilleSteve
 * Date: 15/03/2018
 * Time: 11:49
 */

namespace AppBundle\Listener;


use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use FOS\UserBundle\Event\UserEvent;
use FOS\UserBundle\FOSUserEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class EditProfilListener implements EventSubscriberInterface
{



    public function __construct(EntityManagerInterface $em, \Twig_Environment $twig, \Swift_Mailer $mailer)
    {
        $this->em = $em;
        $this->twig = $twig;
        $this->mailer = $mailer;
    }

    public static function getSubscribedEvents()
    {
        return array(
            FOSUserEvents::REGISTRATION_CONFIRMED => 'onRegistrationCompleted'
        );
    }

}