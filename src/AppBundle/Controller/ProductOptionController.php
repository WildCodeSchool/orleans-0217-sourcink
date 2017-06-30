<?php

namespace AppBundle\Controller;

use AppBundle\Entity\ProductOption;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Productoption controller.
 *
 * @Route("admin/productoption")
 */
class ProductOptionController extends Controller
{
    /**
     * Lists all productOption entities.
     *
     * @Route("/",    name="productoption_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $productOptions = $em->getRepository('AppBundle:ProductOption')->findAll();

        return $this->render(
            'Admin/productoption/index.html.twig', array(
            'productOptions' => $productOptions,
            )
        );
    }

    /**
     * Creates a new productOption entity.
     *
     * @Route("/new",  name="productoption_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $productOption = new Productoption();
        $form = $this->createForm('AppBundle\Form\ProductOptionType', $productOption);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($productOption);
            $em->flush();

            return $this->redirectToRoute('productoption_show', array('id' => $productOption->getId()));
        }

        return $this->render(
            'Admin/productoption/new.html.twig', array(
            'productOption' => $productOption,
            'form' => $form->createView(),
            )
        );
    }

    /**
     * Finds and displays a productOption entity.
     *
     * @Route("/{id}", name="productoption_show")
     * @Method("GET")
     */
    public function showAction(ProductOption $productOption)
    {
        $deleteForm = $this->createDeleteForm($productOption);

        return $this->render(
            'Admin/productoption/show.html.twig', array(
            'productOption' => $productOption,
            'delete_form' => $deleteForm->createView(),
            )
        );
    }

    /**
     * Displays a form to edit an existing productOption entity.
     *
     * @Route("/{id}/edit", name="productoption_edit")
     * @Method({"GET",      "POST"})
     */
    public function editAction(Request $request, ProductOption $productOption)
    {
        $deleteForm = $this->createDeleteForm($productOption);
        $editForm = $this->createForm('AppBundle\Form\ProductOptionType', $productOption);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('productoption_edit', array('id' => $productOption->getId()));
        }

        return $this->render(
            'Admin/productoption/edit.html.twig', array(
            'productOption' => $productOption,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            )
        );
    }

    /**
     * Deletes a productOption entity.
     *
     * @Route("/{id}",   name="productoption_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, ProductOption $productOption)
    {
        $form = $this->createDeleteForm($productOption);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($productOption);
            $em->flush();
        }

        return $this->redirectToRoute('productoption_index');
    }

    /**
     * Creates a form to delete a productOption entity.
     *
     * @param ProductOption $productOption The productOption entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(ProductOption $productOption)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('productoption_delete', array('id' => $productOption->getId())))
            ->setMethod('DELETE')
            ->getForm();
    }
}
