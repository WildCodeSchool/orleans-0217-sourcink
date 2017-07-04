<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Work;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Work controller.
 *
 * @Route("admin/work")
 */
class WorkController extends Controller
{
    /**
     * Lists all work entities.
     *
     * @Route("/",    name="work_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $works = $em->getRepository('AppBundle:Work')->findAll();

        return $this->render(
            'Admin/work/index.html.twig', array(
            'works' => $works,
            )
        );
    }

    /**
     * Creates a new work entity.
     *
     * @Route("/new",  name="work_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $work = new Work();
        $form = $this->createForm('AppBundle\Form\WorkType', $work);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($work);
            $em->flush();

            return $this->redirectToRoute('work_index');
        }

        return $this->render(
            'Admin/work/new.html.twig', array(
                'work' => $work,
                'form' => $form->createView(),
            )
        );
    }

    /**
     * Displays a form to edit an existing work entity.
     *
     * @Route("/{id}/edit", name="work_edit")
     * @Method({"GET",      "POST"})
     */
    public function editAction(Request $request, Work $work)
    {
        $deleteForm = $this->createDeleteForm($work);
        $editForm = $this->createForm('AppBundle\Form\WorkType', $work);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('work_edit', array('id' => $work->getId()));
        }

        return $this->render(
            'Admin/work/edit.html.twig', array(
            'work' => $work,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            )
        );
    }

    /**
     * Deletes a work entity.
     *
     * @Route("/{id}",   name="work_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Work $work)
    {
        $form = $this->createDeleteForm($work);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($work);
            $em->flush();
        }

        return $this->redirectToRoute('work_index');
    }

    /**
     * Creates a form to delete a work entity.
     *
     * @param Work $work The work entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Work $work)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('work_delete', array('id' => $work->getId())))
            ->setMethod('DELETE')
            ->getForm();
    }
}
