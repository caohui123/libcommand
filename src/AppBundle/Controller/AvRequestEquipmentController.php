<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use AppBundle\Entity\AvRequestEquipment;
use AppBundle\Form\AvRequestEquipmentType;

/**
 * AvRequestEquipment controller.
 *
 * @Route("/avrequest/equipment")
 */
class AvRequestEquipmentController extends Controller
{

    /**
     * Lists all AvRequestEquipment entities.
     *
     * @Route("/", name="avrequest_equipment")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('AppBundle:AvRequestEquipment')->findBy(array(), array('name' => 'ASC'));

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new AvRequestEquipment entity.
     *
     * @Route("/", name="avrequest_equipment_create")
     * @Method("POST")
     * @Template("AppBundle:AvRequestEquipment:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new AvRequestEquipment();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('avrequest_equipment_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a AvRequestEquipment entity.
     *
     * @param AvRequestEquipment $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(AvRequestEquipment $entity)
    {
        $form = $this->createForm(new AvRequestEquipmentType(), $entity, array(
            'action' => $this->generateUrl('avrequest_equipment_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new AvRequestEquipment entity.
     *
     * @Route("/new", name="avrequest_equipment_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new AvRequestEquipment();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a AvRequestEquipment entity.
     *
     * @Route("/{id}", name="avrequest_equipment_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:AvRequestEquipment')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find AvRequestEquipment entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing AvRequestEquipment entity.
     *
     * @Route("/{id}/edit", name="avrequest_equipment_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:AvRequestEquipment')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find AvRequestEquipment entity.');
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
    * Creates a form to edit a AvRequestEquipment entity.
    *
    * @param AvRequestEquipment $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(AvRequestEquipment $entity)
    {
        $form = $this->createForm(new AvRequestEquipmentType(), $entity, array(
            'action' => $this->generateUrl('avrequest_equipment_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update', 'attr' => array('class' => 'btn btn-small btn-success')));

        return $form;
    }
    /**
     * Edits an existing AvRequestEquipment entity.
     *
     * @Route("/{id}", name="avrequest_equipment_update")
     * @Method("PUT")
     * @Template("AppBundle:AvRequestEquipment:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:AvRequestEquipment')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find AvRequestEquipment entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('avrequest_equipment_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a AvRequestEquipment entity.
     *
     * @Route("/{id}", name="avrequest_equipment_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AppBundle:AvRequestEquipment')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find AvRequestEquipment entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('avrequest_equipment'));
    }

    /**
     * Creates a form to delete a AvRequestEquipment entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('avrequest_equipment_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete', 'attr' => array('class' => 'btn btn-small btn-danger')))
            ->getForm()
        ;
    }
}
