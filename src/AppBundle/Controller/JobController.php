<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Services\Api;


/**
 * @Route("/job", name="app_job")
 */
class JobController extends Controller
{
    /**
     * @Route("/", name="job_list")
     *
     */

    public function jobAction(Api $service)
    {
        $data = $service->api('jobs',[ "field: duration", "filter: contains", "value: rejected", "custom_fields"]);

        foreach ($data->_embedded->jobs as $job) {
            $offers[$job->id] = [
                'title' => $job->title,
                'duration' => $job->duration,
                'description' => $job->description,
                'city' => $job->location->city,
                'statut'=>$job->_embedded->status->title,
                'maj' => $job->date_modified,
                'debut' => $job ->start_date,
            ];



        }
        //dump($data);
        //die();
        return $this->render('AppBundle:Job:home.html.twig', ['offers' => $offers]);
    }


}
