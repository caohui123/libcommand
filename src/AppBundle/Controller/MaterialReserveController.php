<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use AppBundle\Entity\MaterialReserve;
use AppBundle\Form\MaterialReserveType;
use JMS\SecurityExtraBundle\Annotation\Secure;

/**
 * MaterialReserve controller.
 *
 * @Route("/materialreserve")
 */
class MaterialReserveController extends Controller
{

    /**
     * Lists all MaterialReserve entities.
     *
     * @Route("/", name="materialreserve")
     * @Method("GET")
     * @Template()
     * 
     * @Secure(roles="ROLE_MATERIALRESERVE_VIEW")
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('AppBundle:MaterialReserve')->findBy(array(), array('created'=>'DESC'));

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
     * Creates a new MaterialReserve entity.
     *
     * --ROUTE COMMENTED OUT. THIS SHOULD ONLY BE AVAILABLE THROUGH THE REST API. USE FOR TESTING ONLY!--
     * //@Route("/", name="materialreserve_create")
     * //@Method("POST")
     * //@Template("AppBundle:MaterialReserve:new.html.twig")
     * 
     * //@Secure(roles="ROLE_MATERIALRESERVE_EDIT")
     */
    public function createAction(Request $request)
    {
        $entity = new MaterialReserve();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('materialreserve_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a MaterialReserve entity.
     *
     * @param MaterialReserve $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(MaterialReserve $entity)
    {
        $form = $this->createForm(new MaterialReserveType(), $entity, array(
            'action' => $this->generateUrl('materialreserve_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new MaterialReserve entity.
     *
     * --ROUTE COMMENTED OUT. THIS SHOULD ONLY BE AVAILABLE THROUGH THE REST API. USE FOR TESTING ONLY!--
     * //@Route("/new", name="materialreserve_new")
     * //@Method("GET")
     * //@Template()
     * 
     * //@Secure(roles="ROLE_MATERIALRESERVE_EDIT")
     */
    public function newAction()
    {
        $entity = new MaterialReserve();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a MaterialReserve entity.
     *
     * @Route("/{id}", name="materialreserve_show")
     * @Method("GET")
     * @Template()
     * 
     * @Secure(roles="ROLE_MATERIALRESERVE_VIEW")
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:MaterialReserve')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find MaterialReserve entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing MaterialReserve entity.
     *
     * @Route("/{id}/edit", name="materialreserve_edit")
     * @Method("GET")
     * @Template()
     * 
     * @Secure(roles="ROLE_MATERIALRESERVE_EDIT")
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:MaterialReserve')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find MaterialReserve entity.');
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
    * Creates a form to edit a MaterialReserve entity.
    *
    * @param MaterialReserve $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(MaterialReserve $entity)
    {
        $form = $this->createForm(new MaterialReserveType(), $entity, array(
            'action' => $this->generateUrl('materialreserve_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update', 'attr' => array('class' => 'btn btn-sm btn-success')));

        return $form;
    }
    /**
     * Edits an existing MaterialReserve entity.
     *
     * @Route("/{id}", name="materialreserve_update")
     * @Method("PUT")
     * @Template("AppBundle:MaterialReserve:edit.html.twig")
     * 
     * @Secure(roles="ROLE_MATERIALRESERVE_EDIT")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:MaterialReserve')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find MaterialReserve entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('materialreserve_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a MaterialReserve entity.
     *
     * @Route("/{id}", name="materialreserve_delete")
     * @Method("DELETE")
     * 
     * @Secure(roles="ROLE_MATERIALRESERVE_DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AppBundle:MaterialReserve')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find MaterialReserve entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('materialreserve'));
    }

    /**
     * Creates a form to delete a MaterialReserve entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('materialreserve_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array(
                'label' => 'Delete', 
                'attr' => array(
                    'class' => 'btn btn-sm btn-danger',
                    'onclick' => 'return confirm("Are you sure you want to delete this request?")'
                    )
                )
            )
            ->getForm()
        ;
    }
}
