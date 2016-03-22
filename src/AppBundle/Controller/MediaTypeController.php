<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use AppBundle\Entity\MediaType;
use AppBundle\Form\MediaTypeType;
use JMS\SecurityExtraBundle\Annotation\Secure;

/**
 * MediaType controller (for MATERIAL PURCHASE REQUESTS).
 *
 * @Route("/mediatype")
 */
class MediaTypeController extends Controller
{

    /**
     * Lists all MediaType entities.
     *
     * @Route("/", name="mediatype")
     * @Method("GET")
     * @Template()
     * 
     * @Secure(roles="ROLE_MATERIALPURCHASE_VIEW")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('AppBundle:MediaType')->findBy(array(), array('name' => 'ASC'));

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new MediaType entity.
     *
     * @Route("/", name="mediatype_create")
     * @Method("POST")
     * @Template("AppBundle:MediaType:new.html.twig")
     * 
     * @Secure(roles="ROLE_MATERIALPURCHASE_EDIT")
     */
    public function createAction(Request $request)
    {
        $entity = new MediaType();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('mediatype_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a MediaType entity.
     *
     * @param MediaType $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(MediaType $entity)
    {
        $form = $this->createForm(new MediaTypeType(), $entity, array(
            'action' => $this->generateUrl('mediatype_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new MediaType entity.
     *
     * @Route("/new", name="mediatype_new")
     * @Method("GET")
     * @Template()
     * 
     * @Secure(roles="ROLE_MATERIALPURCHASE_EDIT")
     */
    public function newAction()
    {
        $entity = new MediaType();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a MediaType entity.
     *
     * @Route("/{id}", name="mediatype_show")
     * @Method("GET")
     * @Template()
     * 
     * @Secure(roles="ROLE_MATERIALPURCHASE_VIEW")
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:MediaType')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find MediaType entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing MediaType entity.
     *
     * @Route("/{id}/edit", name="mediatype_edit")
     * @Method("GET")
     * @Template()
     * 
     * @Secure(roles="ROLE_MATERIALPURCHASE_EDIT")
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:MediaType')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find MediaType entity.');
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
    * Creates a form to edit a MediaType entity.
    *
    * @param MediaType $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(MediaType $entity)
    {
        $form = $this->createForm(new MediaTypeType(), $entity, array(
            'action' => $this->generateUrl('mediatype_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update', 'attr'=>array('class' => 'btn btn-sm btn-success')));

        return $form;
    }
    /**
     * Edits an existing MediaType entity.
     *
     * @Route("/{id}", name="mediatype_update")
     * @Method("PUT")
     * @Template("AppBundle:MediaType:edit.html.twig")
     * 
     * @Secure(roles="ROLE_MATERIALPURCHASE_EDIT")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:MediaType')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find MediaType entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('mediatype_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a MediaType entity.
     *
     * @Route("/{id}", name="mediatype_delete")
     * @Method("DELETE")
     * 
     * @Secure(roles="ROLE_MATERIALPURCHASE_DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AppBundle:MediaType')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find MediaType entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('mediatype'));
    }

    /**
     * Creates a form to delete a MediaType entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('mediatype_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array(
                'label' => 'Delete', 
                'attr' => array(
                    'class' => 'btn btn-sm btn-danger',
                    'onclick' => 'return confirm("Are you sure you want to delete this media type?")'
                    )
                )
            )
            ->getForm()
        ;
    }
    
    /**
     * Displays a printer-friendly MediaType entity.
     *
     * @Route("/{id}/print", name="mediatype_print")
     * @Method("GET")
     * @Template()
     * 
     * @Secure(roles="ROLE_MATERIALPURCHASE_VIEW")
     */
    public function printAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:MediaType')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find MediaType entity.');
        }

        return array(
            'entity'      => $entity,
        );
    }
}
