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
        $data = $service->api('jobs', ["field: duration", "filter: contains", "value: rejected", "custom_fields"]);
        $i = 1;
        foreach ($data->_embedded->jobs as $job) {
            $offers[$job->id] = [
                'title' => $job->title,
                'duration' => $job->duration,
                'description' => $job->description,
                'city' => $job->location->city,
                //'name' => $job->_embedded->custom_fields->_embedded->definition->name
            ];
            if($i==3){
                break;
            }
            $i++;
        }
        //dump($data);
        //die();
        return $this->render('AppBundle:Home:home.html.twig', ['offers' => $offers]);
    }
}
