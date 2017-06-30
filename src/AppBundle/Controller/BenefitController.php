<?php

namespace AppBundle\Controller;

use AppBundle\Entity\ProductOption;
use AppBundle\Entity\Benefit;
use AppBundle\Form\BenefitType;
use AppBundle\Form\ProductOptionType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Benefit controller.
 *
 * @Route("admin/benefit")
 */
class BenefitController extends Controller
{
    /**
     * Lists all benefit entities.
     *
     * @Route("/",    name="benefit_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $benefits = $em->getRepository('AppBundle:Benefit')->findAll();
        $products = $em->getRepository('AppBundle:Product')->findAll();
        return $this->render(
            'Admin/benefit/index.html.twig', array(
            'benefits' => $benefits, 'products' => $products,
            )
        );
    }

    /**
     * Creates a new benefit entity.
     *
     * @Route("/new",  name="benefit_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $benefit = new Benefit();

        $em = $this->getDoctrine()->getManager();
        $products = $em->getRepository('AppBundle:Product')->findAll();
        foreach ($products as $product) {
            $productOption = new ProductOption();
            $productOption->setProduct($product);
            $benefit->addProductOption($productOption);
        }
        $form = $this->createForm(BenefitType::class, $benefit);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($benefit);
            $em->flush();
            return $this->redirectToRoute('benefit_show', array('id' => $benefit->getId()));
        }
        return $this->render(
            'Admin/benefit/new.html.twig', array(
            'benefit' => $benefit,
            'form' => $form->createView(),
            )
        );
    }

    /**
     * Finds and displays a benefit entity.
     *
     * @Route("/{id}", name="benefit_show")
     * @Method("GET")
     */
    public function showAction(Benefit $benefit)
    {
        $deleteForm = $this->createDeleteForm($benefit);
        return $this->render(
            'Admin/benefit/show.html.twig', array(
            'benefit' => $benefit,
            'delete_form' => $deleteForm->createView(),
            )
        );
    }

    /**
     * Creates a form to delete a benefit entity.
     *
     * @param Benefit $benefit The benefit entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Benefit $benefit)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('benefit_delete', array('id' => $benefit->getId())))
            ->setMethod('DELETE')
            ->getForm();
    }

    /**
     * Displays a form to edit an existing benefit entity.
     *
     * @Route("/{id}/edit", name="benefit_edit")
     * @Method({"GET",      "POST"})
     */
    public function editAction(Request $request, Benefit $benefit)
    {
        $deleteForm = $this->createDeleteForm($benefit);
        $editForm = $this->createForm('AppBundle\Form\BenefitType', $benefit);
        $editForm->handleRequest($request);
        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            return $this->redirectToRoute('benefit_edit', array('id' => $benefit->getId()));
        }
        return $this->render(
            'Admin/benefit/edit.html.twig', array(
            'benefit' => $benefit,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            )
        );
    }

    /**
     * Deletes a benefit entity.
     *
     * @Route("/{id}",   name="benefit_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Benefit $benefit)
    {
        $form = $this->createDeleteForm($benefit);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($benefit);
            $em->flush();
        }
        return $this->redirectToRoute('benefit_index');
    }
}
