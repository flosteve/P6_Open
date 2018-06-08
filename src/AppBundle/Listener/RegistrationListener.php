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

class RegistrationListener implements EventSubscriberInterface
{

    /**
     * @var EntityManager $em
     */
    private $em;
    /**
     * @var \Twig_Environment
     */
    private $twig;
    /**
     * @var \Swift_Mailer
     */
    private $mailer;


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

    /**
     * @param UserEvent $event
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function onRegistrationCompleted(UserEvent $event)
    {
        //Disable the user first
        $user = $event->getUser();
        $user->setEnabled(false);

        //send an email to administrator
        $body = $this->renderTemplate($user);

        $message = \Swift_Message::newInstance()
            ->setSubject('Nouvel Utilisateur: ' . $user->getUsername())
            ->setFrom('eravillesteve@gmail.com')
            ->setTo('eravillesteve@gmail.com')
            ->setBody($body)
        ;

        $this->mailer->send($message);

        $this->em->persist($user);
        $this->em->flush();

    }

    /**
     * @param $user
     * @return string
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function renderTemplate($user)
    {
        return $this->twig->render(
            ':Email:registration-confirmation-new-user.html.twig',
            array(
                'user' => $user
            )
        );
    }
}