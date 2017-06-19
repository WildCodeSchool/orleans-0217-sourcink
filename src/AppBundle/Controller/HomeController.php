<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Services\Api;

class HomeController extends Controller
{
    /**
     * @Route("/", name="app_homepage")
     */
    public function homeAction(Api $service)
    {


        $data = $service->api('jobs',[ "field: duration", "filter: contains", "value: rejected", "custom_fields"]);

        $em = $this->getDoctrine()->getManager();
        $videos = $em->getRepository('AppBundle:Header')->findAll();
        $categories = $em->getRepository('AppBundle:Category')->findAll();
        $team = $em->getRepository('AppBundle:Team')->findAll();
        $data = $service->api('jobs', ["field: duration", "filter: contains", "value: rejected", "custom_fields"]);


        foreach ($data->_embedded->jobs as $job) {
            $offers[$job->id] = [
                'title' => $job->title,
                'duration' => $job->duration,
                'description' => $job->description,
                'city' => $job->location->city,
                'updated' => $job->date_modified,
                'statut'=>$job->_embedded->status->title,
                'maj' => $job->date_modified,
                'debut' => $job ->start_date,
                'idoffre' => $job-> id,
            ];

        }
        //dump($data);
        //die();

        return $this->render('AppBundle:Home:home.html.twig',
            ['offers' => $offers, 'videos' => $videos, 'categories' => $categories, 'team' => $team, ]);

    }
}
