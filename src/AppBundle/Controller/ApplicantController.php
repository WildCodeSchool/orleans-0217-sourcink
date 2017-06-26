<?php

namespace AppBundle\Controller;

use AppBundle\Services\Api;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use GuzzleHttp\Client;


/**
 * @Route("/candidat")
 */
class ApplicantController extends Controller
{
    /**
     * @Route("/", name="app_applicant")
     */
    public function homeAction(Api $api)
    {
        $users = $api->getSearch('candidates', $this->getUser()->getFirstName());
        $user = $user->_embedded->candidates[0];

        return $this->render('AppBundle:Applicant:home.html.twig', ['user' => $user]);
    }
}
