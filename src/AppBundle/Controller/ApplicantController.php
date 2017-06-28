<?php

namespace AppBundle\Controller;

use AppBundle\Form\ProfileType;
use AppBundle\Services\Api;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

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
        $customFields = $api->candidateCustomFields();
        dump($customFields);
        die();
        return $this->render('AppBundle:Applicant:home.html.twig');
    }

    /**
     * @Route("/update", name="applicant_update")
     */
    public function updateAction(Request $request, Api $api)
    {
/*        $users = $api->getSearch('candidates', $this->getUser()->getEmail());
        $user = $users->_embedded->candidates[0];*/
        $form = $this->createForm(ProfileType::class, $this->getUser());
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
//            $api->updateCandidate($form->getData());
            $em = $this->getDoctrine()->getManager();
            $data = $form->getData();
            $em->persist($data);
            $em->flush();
            if($this->getUser()->getMobility()!=NULL&$this->getUser()->getSalary()!=NULL&$this->getUser()->getExperience()!=NULL&$this->getUser()->getWantedJob()!=NULL&$this->getUser()->getCurrentJob()!=NULL){
                $catsUser = $api->getSearch('candidates', $this->getUser()->getEmail());
                if($catsUser->count==0){
                    $api->createCandidateUser($this->getUser());
                }else{
                    $api->updateCandidate($this->getUser(), $catsUser->_embedded->candidates[0]);
                }


            }
            return $this->redirectToRoute('applicant_update');
        }
        return $this->render('AppBundle:Applicant:update.html.twig', ['form' => $form->createView()]);

    }
}
