<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use AppBundle\Entity\RoomRequestEquipment;
use AppBundle\Form\RoomRequestEquipmentType;

/**
 * RoomRequestEquipment controller.
 *
 * @Route("/roomrequestequipment")
 */
class RoomRequestEquipmentController extends Controller
{

    /**
     * Lists all RoomRequestEquipment entities.
     *
     * @Route("/", name="roomrequestequipment")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $fixed_entities = $em->getRepository('AppBundle:RoomRequestEquipment')->findBy(array('isMobile'=>false), array('name'=>'ASC'));
        $mobile_entities = $em->getRepository('AppBundle:RoomRequestEquipment')->findBy(array('isMobile'=>true), array('name'=>'ASC'));
        
        return array(
            'fixed_entities' => $fixed_entities,
            'mobile_entities' => $mobile_entities,
        );
    }
    /**
     * Creates a new RoomRequestEquipment entity.
     *
     * @Route("/", name="roomrequestequipment_create")
     * @Method("POST")
     * @Template("AppBundle:RoomRequestEquipment:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new RoomRequestEquipment();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('roomrequestequipment_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a RoomRequestEquipment entity.
     *
     * @param RoomRequestEquipment $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(RoomRequestEquipment $entity)
    {
        $form = $this->createForm(new RoomRequestEquipmentType(), $entity, array(
            'action' => $this->generateUrl('roomrequestequipment_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new RoomRequestEquipment entity.
     *
     * @Route("/new", name="roomrequestequipment_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new RoomRequestEquipment();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a RoomRequestEquipment entity.
     *
     * @Route("/{id}", name="roomrequestequipment_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:RoomRequestEquipment')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find RoomRequestEquipment entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing RoomRequestEquipment entity.
     *
     * @Route("/{id}/edit", name="roomrequestequipment_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:RoomRequestEquipment')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find RoomRequestEquipment entity.');
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
    * Creates a form to edit a RoomRequestEquipment entity.
    *
    * @param RoomRequestEquipment $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(RoomRequestEquipment $entity)
    {
        $form = $this->createForm(new RoomRequestEquipmentType(), $entity, array(
            'action' => $this->generateUrl('roomrequestequipment_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update', 'attr'=>array('class'=>'btn btn-sm btn-success')));

        return $form;
    }
    /**
     * Edits an existing RoomRequestEquipment entity.
     *
     * @Route("/{id}", name="roomrequestequipment_update")
     * @Method("PUT")
     * @Template("AppBundle:RoomRequestEquipment:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:RoomRequestEquipment')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find RoomRequestEquipment entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('roomrequestequipment_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a RoomRequestEquipment entity.
     *
     * @Route("/{id}", name="roomrequestequipment_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AppBundle:RoomRequestEquipment')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find RoomRequestEquipment entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('roomrequestequipment'));
    }

    /**
     * Creates a form to delete a RoomRequestEquipment entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('roomrequestequipment_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete', 'attr'=>array('class'=>'btn btn-sm btn-danger')))
            ->getForm()
        ;
    }
}
