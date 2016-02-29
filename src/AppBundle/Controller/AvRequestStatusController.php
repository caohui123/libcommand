<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use AppBundle\Entity\AvRequestStatus;
use AppBundle\Form\AvRequestStatusType;

/**
 * AvRequestStatus controller.
 *
 * @Route("/avrequeststatus")
 */
class AvRequestStatusController extends Controller
{

    /**
     * Lists all AvRequestStatus entities.
     *
     * @Route("/", name="avrequeststatus")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('AppBundle:AvRequestStatus')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new AvRequestStatus entity.
     *
     * @Route("/", name="avrequeststatus_create")
     * @Method("POST")
     * @Template("AppBundle:AvRequestStatus:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new AvRequestStatus();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('avrequeststatus_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a AvRequestStatus entity.
     *
     * @param AvRequestStatus $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(AvRequestStatus $entity)
    {
        $form = $this->createForm(new AvRequestStatusType(), $entity, array(
            'action' => $this->generateUrl('avrequeststatus_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new AvRequestStatus entity.
     *
     * @Route("/new", name="avrequeststatus_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new AvRequestStatus();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a AvRequestStatus entity.
     *
     * @Route("/{id}", name="avrequeststatus_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:AvRequestStatus')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find AvRequestStatus entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing AvRequestStatus entity.
     *
     * @Route("/{id}/edit", name="avrequeststatus_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:AvRequestStatus')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find AvRequestStatus entity.');
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
    * Creates a form to edit a AvRequestStatus entity.
    *
    * @param AvRequestStatus $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(AvRequestStatus $entity)
    {
        $form = $this->createForm(new AvRequestStatusType(), $entity, array(
            'action' => $this->generateUrl('avrequeststatus_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update', 'attr' => array('class' => 'btn btn-small btn-success')));

        return $form;
    }
    /**
     * Edits an existing AvRequestStatus entity.
     *
     * @Route("/{id}", name="avrequeststatus_update")
     * @Method("PUT")
     * @Template("AppBundle:AvRequestStatus:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:AvRequestStatus')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find AvRequestStatus entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('avrequeststatus_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a AvRequestStatus entity.
     *
     * @Route("/{id}", name="avrequeststatus_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AppBundle:AvRequestStatus')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find AvRequestStatus entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('avrequeststatus'));
    }

    /**
     * Creates a form to delete a AvRequestStatus entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('avrequeststatus_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete', 'attr' => array('class' => 'btn btn-small btn-danger')))
            ->getForm()
        ;
    }
}
