<?php

namespace SI\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class DefaultController extends Controller
{
    /**
     * @Route("/")
     */
    public function homeAction()
    {
        return $this->render('SIAppBundle:Vitrine:home.html.twig');
    }
}
