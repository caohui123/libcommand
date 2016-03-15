<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use AppBundle\Entity\ExtendedPrivilegeRequest;
use AppBundle\Form\ExtendedPrivilegeRequestType;
use JMS\SecurityExtraBundle\Annotation\Secure;

/**
 * ExtendedPrivilegeRequest controller.
 *
 * @Route("/extendedprivilege")
 */
class ExtendedPrivilegeRequestController extends Controller
{

    /**
     * Lists all ExtendedPrivilegeRequest entities.
     *
     * @Route("/", name="extendedprivilege")
     * @Method("GET")
     * @Template()
     * 
     * @Secure(roles="ROLE_EXTENDEDPRIVILEGES_VIEW")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('AppBundle:ExtendedPrivilegeRequest')->findBy(array(), array('created'=>'DESC'));

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new ExtendedPrivilegeRequest entity.
     * --ROUTE COMMENTED OUT. THIS SHOULD ONLY BE AVAILABLE THROUGH THE REST API. USE FOR TESTING ONLY!--
     * //@Route("/", name="extendedprivilege_create")
     * //@Method("POST")
     * //@Template("AppBundle:ExtendedPrivilegeRequest:new.html.twig")
     * 
     * //@Secure(roles="ROLE_EXTENDEDPRIVILEGES_EDIT")
     */
    public function createAction(Request $request)
    {
        $entity = new ExtendedPrivilegeRequest();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('extendedprivilege_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a ExtendedPrivilegeRequest entity.
     *
     * @param ExtendedPrivilegeRequest $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(ExtendedPrivilegeRequest $entity)
    {
        $form = $this->createForm(new ExtendedPrivilegeRequestType(), $entity, array(
            'action' => $this->generateUrl('extendedprivilege_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new ExtendedPrivilegeRequest entity.
     * --ROUTE COMMENTED OUT. THIS SHOULD ONLY BE AVAILABLE THROUGH THE REST API. USE FOR TESTING ONLY!--
     * //@Route("/new", name="extendedprivilege_new")
     * //@Method("GET")
     * //@Template()
     * 
     * //@Secure(roles="ROLE_EXTENDEDPRIVILEGES_EDIT")
     */
    public function newAction()
    {
        $entity = new ExtendedPrivilegeRequest();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a ExtendedPrivilegeRequest entity.
     *
     * @Route("/{id}", name="extendedprivilege_show")
     * @Method("GET")
     * @Template()
     * 
     * @Secure(roles="ROLE_EXTENDEDPRIVILEGES_VIEW")
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:ExtendedPrivilegeRequest')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find ExtendedPrivilegeRequest entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing ExtendedPrivilegeRequest entity.
     *
     * @Route("/{id}/edit", name="extendedprivilege_edit")
     * @Method("GET")
     * @Template()
     * 
     * @Secure(roles="ROLE_EXTENDEDPRIVILEGES_VIEW")
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:ExtendedPrivilegeRequest')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find ExtendedPrivilegeRequest entity.');
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
    * Creates a form to edit a ExtendedPrivilegeRequest entity.
    *
    * @param ExtendedPrivilegeRequest $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(ExtendedPrivilegeRequest $entity)
    {
        $form = $this->createForm(new ExtendedPrivilegeRequestType(), $entity, array(
            'action' => $this->generateUrl('extendedprivilege_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update', 'attr' => array('class' => 'btn btn-sm btn-success')));

        return $form;
    }
    /**
     * Edits an existing ExtendedPrivilegeRequest entity.
     *
     * @Route("/{id}", name="extendedprivilege_update")
     * @Method("PUT")
     * @Template("AppBundle:ExtendedPrivilegeRequest:edit.html.twig")
     * 
     * @Secure(roles="ROLE_EXTENDEDPRIVILEGES_EDIT")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:ExtendedPrivilegeRequest')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find ExtendedPrivilegeRequest entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('extendedprivilege_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a ExtendedPrivilegeRequest entity.
     *
     * @Route("/{id}", name="extendedprivilege_delete")
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
            $entity = $em->getRepository('AppBundle:ExtendedPrivilegeRequest')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find ExtendedPrivilegeRequest entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('extendedprivilege'));
    }

    /**
     * Creates a form to delete a ExtendedPrivilegeRequest entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('extendedprivilege_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete',  'attr' => array('class' => 'btn btn-sm btn-danger')))
            ->getForm()
        ;
    }
}
