<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use AppBundle\Entity\StaffDepartment;
use AppBundle\Form\StaffDepartmentType;

/**
 * StaffDepartment controller.
 *
 * @Route("/admin/staffdepartment")
 */
class StaffDepartmentController extends Controller
{

    /**
     * Lists all StaffDepartment entities.
     *
     * @Route("/", name="admin_staffdepartment")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('AppBundle:StaffDepartment')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new StaffDepartment entity.
     *
     * @Route("/", name="admin_staffdepartment_create")
     * @Method("POST")
     * @Template("AppBundle:StaffDepartment:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new StaffDepartment();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('admin_staffdepartment_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a StaffDepartment entity.
     *
     * @param StaffDepartment $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(StaffDepartment $entity)
    {
        $form = $this->createForm(new StaffDepartmentType(), $entity, array(
            'action' => $this->generateUrl('admin_staffdepartment_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new StaffDepartment entity.
     *
     * @Route("/new", name="admin_staffdepartment_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new StaffDepartment();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a StaffDepartment entity.
     *
     * @Route("/{id}", name="admin_staffdepartment_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:StaffDepartment')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find StaffDepartment entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing StaffDepartment entity.
     *
     * @Route("/{id}/edit", name="admin_staffdepartment_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:StaffDepartment')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find StaffDepartment entity.');
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
    * Creates a form to edit a StaffDepartment entity.
    *
    * @param StaffDepartment $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(StaffDepartment $entity)
    {
        $form = $this->createForm(new StaffDepartmentType(), $entity, array(
            'action' => $this->generateUrl('admin_staffdepartment_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing StaffDepartment entity.
     *
     * @Route("/{id}", name="admin_staffdepartment_update")
     * @Method("PUT")
     * @Template("AppBundle:StaffDepartment:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:StaffDepartment')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find StaffDepartment entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('admin_staffdepartment_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a StaffDepartment entity.
     *
     * @Route("/{id}", name="admin_staffdepartment_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AppBundle:StaffDepartment')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find StaffDepartment entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('admin_staffdepartment'));
    }

    /**
     * Creates a form to delete a StaffDepartment entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_staffdepartment_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
