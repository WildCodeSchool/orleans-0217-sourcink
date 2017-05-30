<?php

namespace SI\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class JobController extends Controller
{
    /**
     * @Route("/job", name="si_app_job")
     */
    public function jobAction()
    {
        return $this->render('SIAppBundle:Job:home.html.twig');
    }
}
