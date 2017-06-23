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
    public function homeAction(Api $service)
    {
    }
}
