<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use AppBundle\Entity\StaffFunctionalArea;
use AppBundle\Form\StaffFunctionalAreaType;
use Symfony\Component\HttpFoundation\ParameterBag;

/**
 * StaffFunctionalArea controller.
 *
 * @Route("/admin/staffarea")
 */
class StaffFunctionalAreaController extends Controller
{

    /**
     * Lists all StaffFunctionalArea entities.
     *
     * @Route("/", name="admin_staffarea")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('AppBundle:StaffFunctionalArea')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new StaffFunctionalArea entity.
     *
     * @Route("/", name="admin_staffarea_create")
     * @Method("POST")
     * @Template("AppBundle:StaffFunctionalArea:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $formData = $request->get('appbundle_stafffunctionalarea'); //the name of the form
        $departmentId = $formData['dept'];
        
        $entity = new StaffFunctionalArea();
        $form = $this->createCreateForm($entity, $departmentId);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('admin_staffarea_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a StaffFunctionalArea entity.
     *
     * @param StaffFunctionalArea $entity The entity
     * @param int $departmentId The id of the department under which the functional areas is to be created.
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(StaffFunctionalArea $entity, $departmentId = null)
    {
        $form = $this->createForm(new StaffFunctionalAreaType($this->getDoctrine()->getManager(), $departmentId), $entity, array(
            'action' => $this->generateUrl('admin_staffarea_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create', 'attr'=>array('class'=>'btn btn-sm btn-success')));

        return $form;
    }

    /**
     * Displays a form to create a new StaffFunctionalArea entity.
     * Optionally, pass the department ID to auto-select which department the are belongs to.
     * 
     * @Route("/new/{departmentId}", defaults={"departmentId" = 1}, name="admin_staffarea_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction($departmentId)
    {
        $entity = new StaffFunctionalArea();
        $form   = $this->createCreateForm($entity, $departmentId);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a StaffFunctionalArea entity.
     *
     * @Route("/{id}", name="admin_staffarea_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:StaffFunctionalArea')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find StaffFunctionalArea entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing StaffFunctionalArea entity.
     *
     * @Route("/{id}/edit", name="admin_staffarea_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:StaffFunctionalArea')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find StaffFunctionalArea entity.');
        }

        $editForm = $this->createEditForm($entity, $entity->getDept()->getId());
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
    * Creates a form to edit a StaffFunctionalArea entity.
    *
    * @param StaffFunctionalArea $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(StaffFunctionalArea $entity, $departmentId = null)
    {
        $form = $this->createForm(new StaffFunctionalAreaType($this->getDoctrine()->getManager(), $departmentId), $entity, array(
            'action' => $this->generateUrl('admin_staffarea_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update', 'attr' => array('class'=>'btn btn-sm btn-default')));

        return $form;
    }
    /**
     * Edits an existing StaffFunctionalArea entity.
     *
     * @Route("/{id}", name="admin_staffarea_update")
     * @Method("PUT")
     * @Template("AppBundle:StaffFunctionalArea:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $formData = $request->get('appbundle_stafffunctionalarea'); //the name of the form
        $departmentId = $formData['dept'];
        
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:StaffFunctionalArea')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find StaffFunctionalArea entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity, $departmentId);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('admin_staffarea_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a StaffFunctionalArea entity.
     *
     * @Route("/{id}", name="admin_staffarea_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AppBundle:StaffFunctionalArea')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find StaffFunctionalArea entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('admin_staffarea'));
    }

    /**
     * Creates a form to delete a StaffFunctionalArea entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_staffarea_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete', 'attr' => array('class' => 'btn btn-sm btn-danger')))
            ->getForm()
        ;
    }
}
