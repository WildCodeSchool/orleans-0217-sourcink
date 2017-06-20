<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Services\Api;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SearchType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;


/**
 * @Route("/job", name="app_job")
 */
class JobController extends Controller
{
    /**
     * @Route("/", name="job_list")
     *
     */

    public function jobAction(Api $api, Request $request)
    {
        $data = $api->get('jobs');

        foreach ($data->_embedded->jobs as $job) {
            $offers[$job->id] = [
                'title' => $job->title,
                'duration' => $job->duration,
                'description' => $job->description,
                'city' => trim(ucfirst(strtolower($job->location->city))),
                'statut'=>$job->_embedded->status->title,
                'maj' => $job->date_modified,
                'debut' => $job ->start_date,
            ];
        }
        $town = array_column($offers, 'city');
        $city = array_unique($town);
        $type = array_column($offers, 'duration');
        $duration = array_unique($type);


        $form = $this->createFormBuilder($offers)
                    ->setMethod('GET')
                    ->add ('title', SearchType::class)
                    ->add ('city', ChoiceType::class)
                    ->add ('duration', ChoiceType::class)
                    ->getForm();

        $form -> handleRequest($request);

        $duration = $title = $city = '';

        if ($form->isValid() && $form->isSubmitted()) {
            $title = $offers[$job->id] = [
                'title' => $job->title];
        }

        return $this->render('AppBundle:Job:home.html.twig', ['offers' => $offers, 'citys' => $city, 'durations' => $duration, 'titles' => $title, 'form' => $form->createView()]);

        }

}
