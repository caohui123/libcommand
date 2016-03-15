<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use AppBundle\Entity\ExtendedPrivilegeRequestStatus;
use AppBundle\Form\ExtendedPrivilegeRequestStatusType;
use JMS\SecurityExtraBundle\Annotation\Secure;

/**
 * ExtendedPrivilegeRequestStatus controller.
 *
 * @Route("/extendedprivilegestatus")
 */
class ExtendedPrivilegeRequestStatusController extends Controller
{

    /**
     * Lists all ExtendedPrivilegeRequestStatus entities.
     *
     * @Route("/", name="extendedprivilege_status")
     * @Method("GET")
     * @Template()
     * 
     * @Secure(roles="ROLE_EXTENDEDPRIVILEGES_VIEW")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('AppBundle:ExtendedPrivilegeRequestStatus')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new ExtendedPrivilegeRequestStatus entity.
     *
     * @Route("/", name="extendedprivilege_status_create")
     * @Method("POST")
     * @Template("AppBundle:ExtendedPrivilegeRequestStatus:new.html.twig")
     * 
     * @Secure(roles="ROLE_EXTENDEDPRIVILEGES_EDIT")
     */
    public function createAction(Request $request)
    {
        $entity = new ExtendedPrivilegeRequestStatus();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('extendedprivilege_status_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a ExtendedPrivilegeRequestStatus entity.
     *
     * @param ExtendedPrivilegeRequestStatus $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(ExtendedPrivilegeRequestStatus $entity)
    {
        $form = $this->createForm(new ExtendedPrivilegeRequestStatusType(), $entity, array(
            'action' => $this->generateUrl('extendedprivilege_status_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create', 'attr' => array('class' => 'btn btn-sm')));

        return $form;
    }

    /**
     * Displays a form to create a new ExtendedPrivilegeRequestStatus entity.
     *
     * @Route("/new", name="extendedprivilege_status_new")
     * @Method("GET")
     * @Template()
     * 
     * @Secure(roles="ROLE_EXTENDEDPRIVILEGES_EDIT")
     */
    public function newAction()
    {
        $entity = new ExtendedPrivilegeRequestStatus();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a ExtendedPrivilegeRequestStatus entity.
     *
     * @Route("/{id}", name="extendedprivilege_status_show")
     * @Method("GET")
     * @Template()
     * 
     * @Secure(roles="ROLE_EXTENDEDPRIVILEGES_VIEW")
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:ExtendedPrivilegeRequestStatus')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find ExtendedPrivilegeRequestStatus entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing ExtendedPrivilegeRequestStatus entity.
     *
     * @Route("/{id}/edit", name="extendedprivilege_status_edit")
     * @Method("GET")
     * @Template()
     * 
     * @Secure(roles="ROLE_EXTENDEDPRIVILEGES_EDIT")
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:ExtendedPrivilegeRequestStatus')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find ExtendedPrivilegeRequestStatus entity.');
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
    * Creates a form to edit a ExtendedPrivilegeRequestStatus entity.
    *
    * @param ExtendedPrivilegeRequestStatus $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(ExtendedPrivilegeRequestStatus $entity)
    {
        $form = $this->createForm(new ExtendedPrivilegeRequestStatusType(), $entity, array(
            'action' => $this->generateUrl('extendedprivilege_status_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update', 'attr'=>array('class'=>'btn btn-sm btn-success')));

        return $form;
    }
    /**
     * Edits an existing ExtendedPrivilegeRequestStatus entity.
     *
     * @Route("/{id}", name="extendedprivilege_status_update")
     * @Method("PUT")
     * @Template("AppBundle:ExtendedPrivilegeRequestStatus:edit.html.twig")
     * 
     * @Secure(roles="ROLE_EXTENDEDPRIVILEGES_EDIT")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:ExtendedPrivilegeRequestStatus')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find ExtendedPrivilegeRequestStatus entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('extendedprivilege_status_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a ExtendedPrivilegeRequestStatus entity.
     *
     * @Route("/{id}", name="extendedprivilege_status_delete")
     * @Method("DELETE")
     * 
     * @Secure(roles="ROLE_EXTENDEDPRIVILEGES_DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AppBundle:ExtendedPrivilegeRequestStatus')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find ExtendedPrivilegeRequestStatus entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('extendedprivilege_status'));
    }

    /**
     * Creates a form to delete a ExtendedPrivilegeRequestStatus entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('extendedprivilege_status_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete',  'attr' => array('class' => 'btn btn-sm btn-danger')))
            ->getForm()
        ;
    }
}
