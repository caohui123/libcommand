<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use AppBundle\Entity\AnnualReportStaffing;
use AppBundle\Form\AnnualReportStaffingType;

/**
 * AnnualReportStaffing controller.
 *
 * @Route("/annualreportstaffing")
 */
class AnnualReportStaffingController extends Controller
{

    /**
     * Lists all AnnualReportStaffing entities.
     *
     * @Route("/", name="annualreportstaffing")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('AppBundle:AnnualReportStaffing')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new AnnualReportStaffing entity.
     *
     * @Route("/", name="annualreportstaffing_create")
     * @Method("POST")
     * @Template("AppBundle:AnnualReportStaffing:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new AnnualReportStaffing();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('annualreportstaffing_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a AnnualReportStaffing entity.
     *
     * @param AnnualReportStaffing $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(AnnualReportStaffing $entity)
    {
        $form = $this->createForm(new AnnualReportStaffingType(), $entity, array(
            'action' => $this->generateUrl('annualreportstaffing_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new AnnualReportStaffing entity.
     *
     * @Route("/new", name="annualreportstaffing_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new AnnualReportStaffing();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a AnnualReportStaffing entity.
     *
     * @Route("/{id}", name="annualreportstaffing_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:AnnualReportStaffing')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find AnnualReportStaffing entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing AnnualReportStaffing entity.
     *
     * @Route("/{id}/edit", name="annualreportstaffing_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:AnnualReportStaffing')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find AnnualReportStaffing entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
    * Creates a form to edit a AnnualReportStaffing entity.
    *
    * @param AnnualReportStaffing $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(AnnualReportStaffing $entity)
    {
        $form = $this->createForm(new AnnualReportStaffingType(), $entity, array(
            'action' => $this->generateUrl('annualreportstaffing_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing AnnualReportStaffing entity.
     *
     * @Route("/{id}", name="annualreportstaffing_update")
     * @Method("PUT")
     * @Template("AppBundle:AnnualReportStaffing:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:AnnualReportStaffing')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find AnnualReportStaffing entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('annualreportstaffing_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a AnnualReportStaffing entity.
     *
     * @Route("/{id}", name="annualreportstaffing_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AppBundle:AnnualReportStaffing')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find AnnualReportStaffing entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('annualreportstaffing'));
    }

    /**
     * Creates a form to delete a AnnualReportStaffing entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('annualreportstaffing_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
