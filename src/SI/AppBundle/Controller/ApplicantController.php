<?php

namespace SI\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;


/**
 * @Route("/candidat", name="si_app_applicant")
 */
class ApplicantController extends Controller
{
    /**
     * @Route("/", name="si_app_applicant")
     */
    public function homeAction()
    {
        return $this->render('SIAppBundle:Applicant:home.html.twig');
    }
}
