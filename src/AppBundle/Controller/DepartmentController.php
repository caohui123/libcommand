<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use AppBundle\Entity\Department;
use AppBundle\Form\DepartmentType;
use Symfony\Component\HttpFoundation\Response;
use JMS\SecurityExtraBundle\Annotation\Secure;

/**
 * Department controller.
 *
 * @Route("/department")
 */
class DepartmentController extends Controller
{

    /**
     * Lists all Department entities.
     *
     * @Route("/", name="department")
     * @Method("GET")
     * @Template()
     * 
     * @Secure(roles="ROLE_DEPARTMENTS_VIEW")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('AppBundle:Department')->findAll();

        $list_service = $this->get('list_service');
        $styled_list = $list_service->libraryDepartmentsList($entities);

        return array(
            'styled_list' => $styled_list
        );
    }
    /**
     * Creates a new Department entity.
     *
     * @Route("/", name="department_create")
     * @Method("POST")
     * @Template("AppBundle:Department:new.html.twig")
     * 
     * @Secure(roles="ROLE_DEPARTMENTS_EDIT")
     */
    public function createAction(Request $request)
    {
        $entity = new Department();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('department_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a Department entity.
     *
     * @param Department $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Department $entity)
    {
        $form = $this->createForm(new DepartmentType(), $entity, array(
            'action' => $this->generateUrl('department_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Department entity.
     *
     * @Route("/new", name="department_new")
     * @Method("GET")
     * @Template()
     * 
     * @Secure(roles="ROLE_DEPARTMENTS_EDIT")
     */
    public function newAction()
    {
        $entity = new Department();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Department entity.
     *
     * @Route("/{id}", name="department_show")
     * @Method("GET")
     * @Template()
     * 
     * @Secure(roles="ROLE_DEPARTMENTS_VIEW")
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $em2 = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('AppBundle:Department')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Department entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        
        //find staff who belong to this department (or any of this department's child departments)
        $members = $em2->createQuery('
            SELECT s FROM AppBundle:Staff s WHERE s.department = ANY (SELECT d FROM AppBundle:Department d WHERE d.id = :entity OR d.parent = :entity) ORDER BY s.lastName ASC
            ')->setParameter('entity', $entity)
            ->getResult();

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
            'members' => $members
        );
    }

    /**
     * Displays a form to edit an existing Department entity.
     *
     * @Route("/{id}/edit", name="department_edit")
     * @Method("GET")
     * @Template()
     * 
     * @Secure(roles="ROLE_DEPARTMENTS_EDIT")
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $em2 = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('AppBundle:Department')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Department entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);
        
        //find staff who belong to this department (or any of this department's child departments)
        $members = $em2->createQuery('
            SELECT s FROM AppBundle:Staff s WHERE s.department = ANY (SELECT d FROM AppBundle:Department d WHERE d.id = :entity OR d.parent = :entity) ORDER BY s.lastName ASC
            ')->setParameter('entity', $entity)
            ->getResult();

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'members'     => $members
        );
    }

    /**
    * Creates a form to edit a Department entity.
    *
    * @param Department $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Department $entity)
    {
        $form = $this->createForm(new DepartmentType(), $entity, array(
            'action' => $this->generateUrl('department_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update', 'attr' => array('class' => 'btn btn-sm btn-success')));

        return $form;
    }
    /**
     * Edits an existing Department entity.
     *
     * @Route("/{id}", name="department_update")
     * @Method("PUT")
     * @Template("AppBundle:Department:edit.html.twig")
     * 
     * @Secure(roles="ROLE_DEPARTMENTS_EDIT")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Department')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Department entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('department_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a Department entity.
     *
     * @Route("/{id}", name="department_delete")
     * @Method("DELETE")
     * 
     * @Secure(roles="ROLE_DEPARTMENTS_DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AppBundle:Department')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Department entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('department'));
    }

    /**
     * Creates a form to delete a Department entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('department_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete', 'attr' => array('class' => 'btn btn-sm btn-danger')))
            ->getForm()
        ;
    }
}
