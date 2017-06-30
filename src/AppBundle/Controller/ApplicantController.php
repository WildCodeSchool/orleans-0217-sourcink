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
    public function homeAction()
    {
        return $this->render('AppBundle:Applicant:home.html.twig');
    }

    /**
     * @Route("/update", name="applicant_update")
     */
    public function updateAction(Request $request, Api $api)
    {
        $em = $this->getDoctrine()->getManager();
        $regions = $em->getRepository('AppBundle:Mobility')->findAll();
        $mobility = [];
        foreach ($regions as $region){
            $mobility[$region->getName()] = $region->getName();
        }
        $form = $this->createForm(ProfileType::class, $this->getUser(), array('mobility' => $mobility));
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $em->persist($data);
            $em->flush();
            $catsUser = $api->getSearch('candidates', $this->getUser()->getEmail());
            if ($catsUser->count == 0) {
                $api->createCandidateUser($this->getUser());
            } else {
                $api->updateCandidate($this->getUser(), $catsUser->_embedded->candidates[0]);
            }
            return $this->redirectToRoute('applicant_update');
        }
        return $this->render('AppBundle:Applicant:update.html.twig', ['form' => $form->createView()]);
    }
    /**
     * @Route("/delete", name="applicant_delete")
     */
    public function deleteAction(Api $api)
    {
        $user = $api->getSearch('candidates', $this->getUser()->getEmail());
        if($user->count>0){
            $api->deleteCandidate($user->_embedded->candidates[0]->id);
        }
        $em = $this->getDoctrine()->getManager();
        $em->remove($this->getUser());
        $em->flush();
        return $this->redirectToRoute('app_homepage');
    }
}
