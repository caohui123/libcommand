<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use AppBundle\Entity\MaterialReserveMedia;
use AppBundle\Form\MaterialReserveMediaType;

/**
 * MaterialReserveMedia controller.
 *
 * @Route("/materialreservemedia")
 */
class MaterialReserveMediaController extends Controller
{

    /**
     * Lists all MaterialReserveMedia entities.
     *
     * @Route("/", name="materialreservemedia")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('AppBundle:MaterialReserveMedia')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new MaterialReserveMedia entity.
     *
     * @Route("/", name="materialreservemedia_create")
     * @Method("POST")
     * @Template("AppBundle:MaterialReserveMedia:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new MaterialReserveMedia();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('materialreservemedia_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a MaterialReserveMedia entity.
     *
     * @param MaterialReserveMedia $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(MaterialReserveMedia $entity)
    {
        $form = $this->createForm(new MaterialReserveMediaType(), $entity, array(
            'action' => $this->generateUrl('materialreservemedia_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new MaterialReserveMedia entity.
     *
     * @Route("/new", name="materialreservemedia_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new MaterialReserveMedia();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a MaterialReserveMedia entity.
     *
     * @Route("/{id}", name="materialreservemedia_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:MaterialReserveMedia')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find MaterialReserveMedia entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing MaterialReserveMedia entity.
     *
     * @Route("/{id}/edit", name="materialreservemedia_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:MaterialReserveMedia')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find MaterialReserveMedia entity.');
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
    * Creates a form to edit a MaterialReserveMedia entity.
    *
    * @param MaterialReserveMedia $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(MaterialReserveMedia $entity)
    {
        $form = $this->createForm(new MaterialReserveMediaType(), $entity, array(
            'action' => $this->generateUrl('materialreservemedia_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing MaterialReserveMedia entity.
     *
     * @Route("/{id}", name="materialreservemedia_update")
     * @Method("PUT")
     * @Template("AppBundle:MaterialReserveMedia:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:MaterialReserveMedia')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find MaterialReserveMedia entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('materialreservemedia_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a MaterialReserveMedia entity.
     *
     * @Route("/{id}", name="materialreservemedia_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AppBundle:MaterialReserveMedia')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find MaterialReserveMedia entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('materialreservemedia'));
    }

    /**
     * Creates a form to delete a MaterialReserveMedia entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('materialreservemedia_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
