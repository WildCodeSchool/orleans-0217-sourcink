<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Services\Api;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SearchType;
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
                'statut' => $job->_embedded->status->title,
                'maj' => $job->date_modified,
                'debut' => $job->start_date,
            ];
        }
        $towns = array_column($offers, 'city', 'city');
        $cities = array_unique($towns);
        $types = array_column($offers, 'duration', 'duration');
        $durations = array_unique($types);


        $form = $this->createFormBuilder($offers)
            ->setMethod('GET')
            //->add('title', SearchType::class)
            ->add('city', ChoiceType::class, ['choices' => ($cities),
            ])
            ->add('duration', ChoiceType::class, ['choices' => ($durations)
            ])
            ->getForm();

        $form->handleRequest($request);


        if ($form->isValid() && $form->isSubmitted()) {
            $data = $form->getData();


            $contract = ['field' => 'duration', 'filter' => 'contains', 'value' => $data['duration']];
            $location = ['field' => 'location.city', 'filter' => 'contains', 'value' => $data['city']];
            $search = $service->filterJobs('jobs/search', [$contract, $location]);
        }

        return $this->render('AppBundle:Job:home.html.twig', ['offers' => $offers, 'durations' => $durations, 'form' => $form->createView()]);

    }

}
