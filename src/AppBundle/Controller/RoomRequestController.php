<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use AppBundle\Entity\RoomRequest;
use AppBundle\Form\RoomRequestType;
use JMS\SecurityExtraBundle\Annotation\Secure;

/**
 * RoomRequest controller.
 *
 * @Route("/roomrequest")
 */
class RoomRequestController extends Controller
{

    /**
     * Lists all RoomRequest entities.
     *
     * @Route("/", name="roomrequest")
     * @Method("GET")
     * @Template()
     * 
     * @Secure(roles="ROLE_ROOMREQUEST_VIEW")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('AppBundle:RoomRequest')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new RoomRequest entity.
     * --ROUTE COMMENTED OUT. THIS SHOULD ONLY BE AVAILABLE THROUGH THE REST API. USE FOR TESTING ONLY!--
     * //@Route("/", name="roomrequest_create")
     * //@Method("POST")
     * //@Template("AppBundle:RoomRequest:new.html.twig")
     * 
     * //@Secure(roles="ROLE_ROOMREQUEST_EDIT")
     */
    public function createAction(Request $request)
    {
        $entity = new RoomRequest();
        
        $requestData = $request->request->all();
        
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            
            foreach($requestData['appbundle_roomrequest']['fixedEquipment'] as $equipment){
                $fixedEquipment = $em->getRepository('AppBundle:RoomRequestEquipment')->find($equipment);
                if(!$fixedEquipment){
                    throw $this->createNotFoundException('RoomRequestEquipment entity not found.');
                }
                $entity->addEquipment($fixedEquipment);
            }
            foreach($requestData['appbundle_roomrequest']['mobileEquipment'] as $equipment){
                $mobileEquipment = $em->getRepository('AppBundle:RoomRequestEquipment')->find($equipment);
                if(!$mobileEquipment){
                    throw $this->createNotFoundException('RoomRequestEquipment entity not found.');
                }
                $entity->addEquipment($mobileEquipment);
            }
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('roomrequest_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a RoomRequest entity.
     *
     * @param RoomRequest $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(RoomRequest $entity)
    {
        $form = $this->createForm(new RoomRequestType(), $entity, array(
            'action' => $this->generateUrl('roomrequest_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new RoomRequest entity.
     * --ROUTE COMMENTED OUT. THIS SHOULD ONLY BE AVAILABLE THROUGH THE REST API. USE FOR TESTING ONLY!--
     * //@Route("/new", name="roomrequest_new")
     * //@Method("GET")
     * //@Template()
     * 
     * //@Secure(roles="ROLE_ROOMREQUEST_EDIT")
     */
    public function newAction()
    {
        $entity = new RoomRequest();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a RoomRequest entity.
     *
     * @Route("/{id}", name="roomrequest_show")
     * @Method("GET")
     * @Template()
     * 
     * @Secure(roles="ROLE_ROOMREQUEST_VIEW")
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:RoomRequest')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find RoomRequest entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing RoomRequest entity.
     *
     * @Route("/{id}/edit", name="roomrequest_edit")
     * @Method("GET")
     * @Template()
     * 
     * @Secure(roles="ROLE_ROOMREQUEST_EDIT")
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:RoomRequest')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find RoomRequest entity.');
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
    * Creates a form to edit a RoomRequest entity.
    *
    * @param RoomRequest $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(RoomRequest $entity)
    {
        $form = $this->createForm(new RoomRequestType(), $entity, array(
            'action' => $this->generateUrl('roomrequest_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update', 'attr'=>array('class'=>'btn btn-sm btn-success')));

        return $form;
    }
    /**
     * Edits an existing RoomRequest entity.
     *
     * @Route("/{id}", name="roomrequest_update")
     * @Method("PUT")
     * @Template("AppBundle:RoomRequest:edit.html.twig")
     * 
     * @Secure(roles="ROLE_ROOMREQUEST_EDIT")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:RoomRequest')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find RoomRequest entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('roomrequest_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a RoomRequest entity.
     *
     * @Route("/{id}", name="roomrequest_delete")
     * @Method("DELETE")
     * 
     * @Secure(roles="ROLE_ROOMREQUEST_DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AppBundle:RoomRequest')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find RoomRequest entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('roomrequest'));
    }

    /**
     * Creates a form to delete a RoomRequest entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('roomrequest_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete', 'attr'=>array('class'=>'btn btn-sm btn-danger')))
            ->getForm()
        ;
    }
}
