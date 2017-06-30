<?php
/**
 * Created by PhpStorm.
 * User: Quentin
 * Date: 30/06/2017
 * Time: 10:01
 */

namespace AppBundle\Services;


use Symfony\Component\DependencyInjection\ContainerInterface;
use UserBundle\Entity\User;

class Email
{
    private $templating;
    private $email_adress;

    public function __construct(ContainerInterface $container, $emailAdress)
    {
        $this->setTemplating($container->get('templating'))->setEmailAdress($emailAdress);
    }
    public function applyJob(\Swift_Mailer $mailer, User $user)
    {
        $message = new \Swift_Message('Hello Email');
        $message->setFrom($this->getEmailAdress())
            ->setTo($user->getEmail())
            ->setBody($this->getTemplating()->render('AppBundle:Email:job.html.twig'), 'text/html');
        $mailer->send($message);
        return $message;
    }

    /**
     * @return mixed
     */
    public function getTemplating()
    {
        return $this->templating;
    }

    /**
     * @param mixed $templating
     * @return Email
     */
    public function setTemplating($templating)
    {
        $this->templating = $templating;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getEmailAdress()
    {
        return $this->email_adress;
    }

    /**
     * @param mixed $email_adress
     * @return Email
     */
    public function setEmailAdress($email_adress)
    {
        $this->email_adress = $email_adress;
        return $this;
    }

}