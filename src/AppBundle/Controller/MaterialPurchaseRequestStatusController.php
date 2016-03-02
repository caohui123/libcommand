<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use AppBundle\Entity\MaterialPurchaseRequestStatus;
use AppBundle\Form\MaterialPurchaseRequestStatusType;

/**
 * MaterialPurchaseRequestStatus controller.
 *
 * @Route("/materialpurchasestatus")
 */
class MaterialPurchaseRequestStatusController extends Controller
{

    /**
     * Lists all MaterialPurchaseRequestStatus entities.
     *
     * @Route("/", name="materialpurchasestatus")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('AppBundle:MaterialPurchaseRequestStatus')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new MaterialPurchaseRequestStatus entity.
     *
     * @Route("/", name="materialpurchasestatus_create")
     * @Method("POST")
     * @Template("AppBundle:MaterialPurchaseRequestStatus:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new MaterialPurchaseRequestStatus();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('materialpurchasestatus_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a MaterialPurchaseRequestStatus entity.
     *
     * @param MaterialPurchaseRequestStatus $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(MaterialPurchaseRequestStatus $entity)
    {
        $form = $this->createForm(new MaterialPurchaseRequestStatusType(), $entity, array(
            'action' => $this->generateUrl('materialpurchasestatus_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new MaterialPurchaseRequestStatus entity.
     *
     * @Route("/new", name="materialpurchasestatus_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new MaterialPurchaseRequestStatus();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a MaterialPurchaseRequestStatus entity.
     *
     * @Route("/{id}", name="materialpurchasestatus_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:MaterialPurchaseRequestStatus')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find MaterialPurchaseRequestStatus entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing MaterialPurchaseRequestStatus entity.
     *
     * @Route("/{id}/edit", name="materialpurchasestatus_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:MaterialPurchaseRequestStatus')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find MaterialPurchaseRequestStatus entity.');
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
    * Creates a form to edit a MaterialPurchaseRequestStatus entity.
    *
    * @param MaterialPurchaseRequestStatus $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(MaterialPurchaseRequestStatus $entity)
    {
        $form = $this->createForm(new MaterialPurchaseRequestStatusType(), $entity, array(
            'action' => $this->generateUrl('materialpurchasestatus_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update', 'attr' => array('class' => 'btn btn-sm btn-success')));

        return $form;
    }
    /**
     * Edits an existing MaterialPurchaseRequestStatus entity.
     *
     * @Route("/{id}", name="materialpurchasestatus_update")
     * @Method("PUT")
     * @Template("AppBundle:MaterialPurchaseRequestStatus:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:MaterialPurchaseRequestStatus')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find MaterialPurchaseRequestStatus entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('materialpurchasestatus_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a MaterialPurchaseRequestStatus entity.
     *
     * @Route("/{id}", name="materialpurchasestatus_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AppBundle:MaterialPurchaseRequestStatus')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find MaterialPurchaseRequestStatus entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('materialpurchasestatus'));
    }

    /**
     * Creates a form to delete a MaterialPurchaseRequestStatus entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('materialpurchasestatus_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete', 'attr' => array('class' => 'btn btn-sm btn-danger')))
            ->getForm()
        ;
    }
}
