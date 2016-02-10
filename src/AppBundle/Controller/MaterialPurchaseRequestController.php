<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use AppBundle\Entity\MaterialPurchaseRequest;
use AppBundle\Form\MaterialPurchaseRequestType;

/**
 * MaterialPurchaseRequest controller.
 *
 * @Route("/materialpurchase")
 */
class MaterialPurchaseRequestController extends Controller
{

    /**
     * Lists all MaterialPurchaseRequest entities.
     *
     * @Route("/", name="materialpurchase")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('AppBundle:MaterialPurchaseRequest')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new MaterialPurchaseRequest entity.
     *
     * @Route("/", name="materialpurchase_create")
     * @Method("POST")
     * @Template("AppBundle:MaterialPurchaseRequest:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new MaterialPurchaseRequest();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('materialpurchase_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a MaterialPurchaseRequest entity.
     *
     * @param MaterialPurchaseRequest $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(MaterialPurchaseRequest $entity)
    {
        $form = $this->createForm(new MaterialPurchaseRequestType(), $entity, array(
            'action' => $this->generateUrl('materialpurchase_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new MaterialPurchaseRequest entity.
     *
     * @Route("/new", name="materialpurchase_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new MaterialPurchaseRequest();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a MaterialPurchaseRequest entity.
     *
     * @Route("/{id}", name="materialpurchase_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:MaterialPurchaseRequest')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find MaterialPurchaseRequest entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing MaterialPurchaseRequest entity.
     *
     * @Route("/{id}/edit", name="materialpurchase_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:MaterialPurchaseRequest')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find MaterialPurchaseRequest entity.');
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
    * Creates a form to edit a MaterialPurchaseRequest entity.
    *
    * @param MaterialPurchaseRequest $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(MaterialPurchaseRequest $entity)
    {
        $form = $this->createForm(new MaterialPurchaseRequestType(), $entity, array(
            'action' => $this->generateUrl('materialpurchase_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing MaterialPurchaseRequest entity.
     *
     * @Route("/{id}", name="materialpurchase_update")
     * @Method("PUT")
     * @Template("AppBundle:MaterialPurchaseRequest:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:MaterialPurchaseRequest')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find MaterialPurchaseRequest entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('materialpurchase_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a MaterialPurchaseRequest entity.
     *
     * @Route("/{id}", name="materialpurchase_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AppBundle:MaterialPurchaseRequest')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find MaterialPurchaseRequest entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('materialpurchase'));
    }

    /**
     * Creates a form to delete a MaterialPurchaseRequest entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('materialpurchase_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
