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
    public function homeAction(Api $api)
    {

        $em = $this->getDoctrine()->getManager();
        $videos = $em->getRepository('AppBundle:Header')->findAll();
        $categories = $em->getRepository('AppBundle:Category')->findAll();
        $team = $em->getRepository('AppBundle:Team')->findAll();

        $data = $api->get('jobs');
        foreach ($data->_embedded->jobs as $job) {
            $offers[$job->id] = [
                'title' => $job->title,
                'duration' => $job->duration,
                'description' => $job->description,
                'city' => $job->location->city,
                'statut' => $job->_embedded->status->title,
            ];

        }

        return $this->render(
            'AppBundle:Home:home.html.twig',
            ['offers' => $offers, 'videos' => $videos, 'categories' => $categories, 'team' => $team, ]
        );
    }

}


