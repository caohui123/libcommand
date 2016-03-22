<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use AppBundle\Entity\MaterialPurchaseRequestReason;
use AppBundle\Form\MaterialPurchaseRequestReasonType;
use JMS\SecurityExtraBundle\Annotation\Secure;

/**
 * MaterialPurchaseRequestReason controller.
 *
 * @Route("/materialpurchasereason")
 */
class MaterialPurchaseRequestReasonController extends Controller
{

    /**
     * Lists all MaterialPurchaseRequestReason entities.
     *
     * @Route("/", name="materialpurchaserequestreason")
     * @Method("GET")
     * @Template()
     * 
     * @Secure(roles="ROLE_MATERIALPURCHASE_VIEW")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('AppBundle:MaterialPurchaseRequestReason')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new MaterialPurchaseRequestReason entity.
     *
     * @Route("/", name="materialpurchaserequestreason_create")
     * @Method("POST")
     * @Template("AppBundle:MaterialPurchaseRequestReason:new.html.twig")
     * 
     * @Secure(roles="ROLE_MATERIALPURCHASE_EDIT")
     */
    public function createAction(Request $request)
    {
        $entity = new MaterialPurchaseRequestReason();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('materialpurchaserequestreason_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a MaterialPurchaseRequestReason entity.
     *
     * @param MaterialPurchaseRequestReason $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(MaterialPurchaseRequestReason $entity)
    {
        $form = $this->createForm(new MaterialPurchaseRequestReasonType(), $entity, array(
            'action' => $this->generateUrl('materialpurchaserequestreason_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new MaterialPurchaseRequestReason entity.
     *
     * @Route("/new", name="materialpurchaserequestreason_new")
     * @Method("GET")
     * @Template()
     * 
     * @Secure(roles="ROLE_MATERIALPURCHASE_EDIT")
     */
    public function newAction()
    {
        $entity = new MaterialPurchaseRequestReason();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a MaterialPurchaseRequestReason entity.
     *
     * @Route("/{id}", name="materialpurchaserequestreason_show")
     * @Method("GET")
     * @Template()
     * 
     * @Secure(roles="ROLE_MATERIALPURCHASE_VIEW")
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:MaterialPurchaseRequestReason')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find MaterialPurchaseRequestReason entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing MaterialPurchaseRequestReason entity.
     *
     * @Route("/{id}/edit", name="materialpurchaserequestreason_edit")
     * @Method("GET")
     * @Template()
     * 
     * @Secure(roles="ROLE_MATERIALPURCHASE_EDIT")
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:MaterialPurchaseRequestReason')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find MaterialPurchaseRequestReason entity.');
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
    * Creates a form to edit a MaterialPurchaseRequestReason entity.
    *
    * @param MaterialPurchaseRequestReason $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(MaterialPurchaseRequestReason $entity)
    {
        $form = $this->createForm(new MaterialPurchaseRequestReasonType(), $entity, array(
            'action' => $this->generateUrl('materialpurchaserequestreason_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update', 'attr' => array('class' => 'btn btn-sm btn-success')));

        return $form;
    }
    /**
     * Edits an existing MaterialPurchaseRequestReason entity.
     *
     * @Route("/{id}", name="materialpurchaserequestreason_update")
     * @Method("PUT")
     * @Template("AppBundle:MaterialPurchaseRequestReason:edit.html.twig")
     * 
     * @Secure(roles="ROLE_MATERIALPURCHASE_EDIT")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:MaterialPurchaseRequestReason')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find MaterialPurchaseRequestReason entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('materialpurchaserequestreason_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a MaterialPurchaseRequestReason entity.
     *
     * @Route("/{id}", name="materialpurchaserequestreason_delete")
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
            $entity = $em->getRepository('AppBundle:MaterialPurchaseRequestReason')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find MaterialPurchaseRequestReason entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('materialpurchaserequestreason'));
    }
    
    /**
     * Displays a printer-friendly MaterialPurchaseRequestReason entity.
     *
     * @Route("/{id}/print", name="materialpurchaserequestreason_print")
     * @Method("GET")
     * @Template()
     * 
     * @Secure(roles="ROLE_MATERIALPURCHASE_VIEW")
     */
    public function printAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:MaterialPurchaseRequestReason')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find MaterialPurchaseRequestReason entity.');
        }

        return array(
            'entity'      => $entity,
        );
    }

    /**
     * Creates a form to delete a MaterialPurchaseRequestReason entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('materialpurchaserequestreason_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array(
                'label' => 'Delete', 
                'attr' => array(
                    'class' => 'btn btn-sm btn-danger',
                    'onclick' => 'return confirm("Are you sure you want to delete this reason?")'
                    )
                )
            )
            ->getForm()
        ;
    }
}
