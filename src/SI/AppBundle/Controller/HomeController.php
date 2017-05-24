<?php

namespace SI\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class HomeController extends Controller
{
    /**
     * @Route("/", name="si_app_homepage")
     */
    public function homeAction()
    {
        return $this->render('SIAppBundle:Home:home.html.twig');
    }
}
