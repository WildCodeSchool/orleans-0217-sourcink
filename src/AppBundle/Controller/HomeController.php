<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Services\Api;

class HomeController extends Controller
{
    /**
     * @Route("/", name="app_homepage")
     * @method ("GET")
     */
    public function homeAction(Api $service)
    {

        $data = $service->api('jobs',[ "field: duration", "filter: contains", "value: rejected", "custom_fields"]);

        foreach ($data->_embedded->jobs as $job) {
            $offers[$job->id] = [
                'title' => $job->title,
                'duration' => $job->duration,
                'description' => $job->description,
                'city' => $job->location->city,
                'updated' => $job->date_modified,
                'statut'=>$job->_embedded->status->title,
                'debut' => $job ->start_date,
                'idoffre'=>$job -> id
            ];

        }
        //dump($offers);
        //die();
        return $this->render('AppBundle:Home:home.html.twig', ['offers' => $offers]);
    }
}

