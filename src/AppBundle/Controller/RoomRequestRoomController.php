<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use AppBundle\Entity\RoomRequestRoom;
use AppBundle\Form\RoomRequestRoomType;
use JMS\SecurityExtraBundle\Annotation\Secure;

/**
 * RoomRequestRoom controller.
 *
 * @Route("/roomrequestroom")
 */
class RoomRequestRoomController extends Controller
{

    /**
     * Lists all RoomRequestRoom entities.
     *
     * @Route("/", name="roomrequestroom")
     * @Method("GET")
     * @Template()
     * 
     * @Secure(roles="ROLE_ROOMREQUEST_VIEW")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('AppBundle:RoomRequestRoom')->findBy(array(), array('name'=>'ASC'));

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new RoomRequestRoom entity.
     *
     * @Route("/", name="roomrequestroom_create")
     * @Method("POST")
     * @Template("AppBundle:RoomRequestRoom:new.html.twig")
     * 
     * @Secure(roles="ROLE_ROOMREQUEST_EDIT")
     */
    public function createAction(Request $request)
    {
        $entity = new RoomRequestRoom();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('roomrequestroom_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a RoomRequestRoom entity.
     *
     * @param RoomRequestRoom $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(RoomRequestRoom $entity)
    {
        $form = $this->createForm(new RoomRequestRoomType(), $entity, array(
            'action' => $this->generateUrl('roomrequestroom_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new RoomRequestRoom entity.
     *
     * @Route("/new", name="roomrequestroom_new")
     * @Method("GET")
     * @Template()
     * 
     * @Secure(roles="ROLE_ROOMREQUEST_EDIT")
     */
    public function newAction()
    {
        $entity = new RoomRequestRoom();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a RoomRequestRoom entity.
     *
     * @Route("/{id}", name="roomrequestroom_show")
     * @Method("GET")
     * @Template()
     * 
     * @Secure(roles="ROLE_ROOMREQUEST_VIEW")
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:RoomRequestRoom')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find RoomRequestRoom entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing RoomRequestRoom entity.
     *
     * @Route("/{id}/edit", name="roomrequestroom_edit")
     * @Method("GET")
     * @Template()
     * 
     * @Secure(roles="ROLE_ROOMREQUEST_EDIT")
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:RoomRequestRoom')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find RoomRequestRoom entity.');
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
    * Creates a form to edit a RoomRequestRoom entity.
    *
    * @param RoomRequestRoom $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(RoomRequestRoom $entity)
    {
        $form = $this->createForm(new RoomRequestRoomType(), $entity, array(
            'action' => $this->generateUrl('roomrequestroom_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update', 'attr'=>array('class'=>'btn btn-sm btn-success')));

        return $form;
    }
    /**
     * Edits an existing RoomRequestRoom entity.
     *
     * @Route("/{id}", name="roomrequestroom_update")
     * @Method("PUT")
     * @Template("AppBundle:RoomRequestRoom:edit.html.twig")
     * 
     * @Secure(roles="ROLE_ROOMREQUEST_EDIT")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:RoomRequestRoom')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find RoomRequestRoom entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('roomrequestroom_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a RoomRequestRoom entity.
     *
     * @Route("/{id}", name="roomrequestroom_delete")
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
            $entity = $em->getRepository('AppBundle:RoomRequestRoom')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find RoomRequestRoom entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('roomrequestroom'));
    }

    /**
     * Creates a form to delete a RoomRequestRoom entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('roomrequestroom_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array(
                'label' => 'Delete', 
                'attr' => array(
                    'class' => 'btn btn-sm btn-danger',
                    'onclick' => 'return confirm("Are you sure you want to delete this room?")'
                    )
                )
            )
            ->getForm()
        ;
    }
}
