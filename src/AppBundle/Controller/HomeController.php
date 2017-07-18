<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Services\Api;
use Symfony\Component\HttpFoundation\Request;

class HomeController extends Controller
{
    /**
     * @Route("/", name="app_homepage")
     */
    public function homeAction(Api $api, Request $request)
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
                'updated' => $job->date_modified,
                'statut' => $job->_embedded->status->title,
                'maj' => $job->date_modified,
                'debut' => $job->start_date,
                'id' => $job->id,
                'attachment_id' => (property_exists($job->_embedded, 'attachments') ? $job->_embedded->attachments[0]->id : '')

            ];
            if ($offers[$job->id]['attachment_id'] != '') {

                $offers[$job->id]['image'] = $api->downloadImg(property_exists($job->_embedded, 'attachments') ? $job->_embedded->attachments[0]->id : '');

            }
        }

        $browser = $request->server->get('HTTP_USER_AGENT');
        if (preg_match('/Edge/', $browser)) {
            $browser = 'Edge';
        }

        return $this->render(
            'AppBundle:Home:home.html.twig',
            [
                'offers' => $offers,
                'videos' => $videos,
                'categories' => $categories,
                'team' => $team,
                'browser'=>$browser,
            ]
        );


    }

}


