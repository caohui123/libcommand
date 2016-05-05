<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use AppBundle\Entity\GroupInstruction;
use AppBundle\Form\GroupInstructionType;
use AppBundle\Exception\NoAssociatedStaffException;

/**
 * GroupInstruction controller.
 *
 * @Route("/groupinstruction")
 */
class GroupInstructionController extends Controller
{

    /**
     * Lists all GroupInstruction entities.
     *
     * @Route("/", name="groupinstruction")
     * @Method("GET")
     * @Template()
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        
        $currentUser = $this->get('security.token_storage')->getToken()->getUser();

        $entities = $em->getRepository('AppBundle:GroupInstruction')->findBy(array('createdBy' => $currentUser), array('instructionDate' => 'DESC'));

        $requestData = $request->query->all();
        isset($requestData['maxItems']) ? $maxItems = $requestData['maxItems'] : $maxItems = 10;
      
        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $entities, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            $maxItems/*limit per page*/
        );

        return array(
            'pagination' => $pagination
        );
    }
    /**
     * Creates a new GroupInstruction entity.
     *
     * @Route("/", name="groupinstruction_create")
     * @Method("POST")
     * @Template("AppBundle:GroupInstruction:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new GroupInstruction();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('groupinstruction_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a GroupInstruction entity.
     *
     * @param GroupInstruction $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(GroupInstruction $entity)
    {
        $currentUser = $this->get('security.token_storage')->getToken()->getUser();
        
        if(null === $currentUser->getStaffMember()){
            throw new NoAssociatedStaffException();
        }
        
        $form = $this->createForm(new GroupInstructionType($this->getDoctrine()->getManager(), $currentUser->getStaffMember()), $entity, array(
            'action' => $this->generateUrl('groupinstruction_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new GroupInstruction entity.
     *
     * @Route("/new", name="groupinstruction_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new GroupInstruction();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a GroupInstruction entity.
     *
     * @Route("/{id}", name="groupinstruction_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:GroupInstruction')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find GroupInstruction entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing GroupInstruction entity.
     *
     * @Route("/{id}/edit", name="groupinstruction_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:GroupInstruction')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find GroupInstruction entity.');
        }
        
        $this->denyAccessUnlessGranted('edit', $entity, 'Unauthorized Access!');

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
    * Creates a form to edit a GroupInstruction entity.
    *
    * @param GroupInstruction $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(GroupInstruction $entity)
    {
        $currentUser = $this->get('security.token_storage')->getToken()->getUser();
        
        if(null === $currentUser->getStaffMember()){
            throw new NoAssociatedStaffException();
        }
        
        $form = $this->createForm(new GroupInstructionType($this->getDoctrine()->getManager(), $currentUser->getStaffMember()), $entity, array(
            'action' => $this->generateUrl('groupinstruction_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update', 'attr' => array('class' => 'btn btn-sm btn-success')));

        return $form;
    }
    /**
     * Edits an existing GroupInstruction entity.
     *
     * @Route("/{id}", name="groupinstruction_update")
     * @Method("PUT")
     * @Template("AppBundle:GroupInstruction:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:GroupInstruction')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find GroupInstruction entity.');
        }
        
        $this->denyAccessUnlessGranted('edit', $entity, 'Unauthorized Access!');

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('groupinstruction_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a GroupInstruction entity.
     *
     * @Route("/{id}", name="groupinstruction_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AppBundle:GroupInstruction')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find GroupInstruction entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('groupinstruction'));
    }

    /**
     * Creates a form to delete a GroupInstruction entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('groupinstruction_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array(
                'label' => 'Delete',
                'attr' => array(
                    'class' => 'btn btn-sm btn-danger',
                    'onclick' => 'return confirm("Are you sure you want to delete this session?")'
                    )
                ))
            ->getForm()
        ;
    }
    
    /**
     * Displays a printer-friendly GroupInstruction entity.
     *
     * @Route("/{id}/print", name="groupinstruction_print")
     * @Method("GET")
     * @Template()
     */
    public function printAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:GroupInstruction')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find GroupInstruction entity.');
        }
        
        $this->denyAccessUnlessGranted('edit', $entity, 'Unauthorized Access!');

        return array(
            'entity'      => $entity,
        );
    }
}
