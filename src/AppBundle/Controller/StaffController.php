<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use AppBundle\Entity\Staff;
use AppBundle\Form\StaffType;
use JMS\SecurityExtraBundle\Annotation\Secure;

/**
 * Staff controller.
 *
 * @Route("/staff")
 */
class StaffController extends Controller
{

    /**
     * Lists all Staff entities.
     *
     * @Route("/", name="staff")
     * @Method("GET")
     * @Template()
     * 
     * @Secure(roles="ROLE_STAFF_VIEW")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('AppBundle:Staff')->findAll(array('lastName'=>'ASC'));

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new Staff entity.
     *
     * @Route("/", name="staff_create")
     * @Method("POST")
     * @Template("AppBundle:Staff:new.html.twig")
     * 
     * @Secure(roles="ROLE_STAFF_EDIT")
     */
    public function createAction(Request $request)
    {
        $entity = new Staff();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('staff_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a Staff entity.
     *
     * @param Staff $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Staff $entity)
    {
        $form = $this->createForm(new StaffType(), $entity, array(
            'action' => $this->generateUrl('staff_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Staff entity.
     *
     * @Route("/new", name="staff_new")
     * @Method("GET")
     * @Template()
     * 
     * @Secure(roles="ROLE_STAFF_EDIT")
     */
    public function newAction()
    {
        $entity = new Staff();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Staff entity.
     *
     * @Route("/{id}", name="staff_show")
     * @Method("GET")
     * @Template()
     * 
     * @Secure(roles="ROLE_STAFF_VIEW")
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Staff')->find($id);
        
        $ldapUser = $em->getRepository('AppBundle:User')->findOneBy(array('staffMember'=>$id));
        if($ldapUser == null){
          $ldapUser = "No associated LDAP User";
        } 

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Staff entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'ldap_user'   => $ldapUser,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Staff entity.
     *
     * @Route("/{id}/edit", name="staff_edit")
     * @Method("GET")
     * @Template()
     * 
     * @Secure(roles="ROLE_STAFF_EDIT")
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Staff')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Staff entity.');
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
    * Creates a form to edit a Staff entity.
    *
    * @param Staff $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Staff $entity)
    {
        $form = $this->createForm(new StaffType(), $entity, array(
            'action' => $this->generateUrl('staff_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Staff entity.
     *
     * @Route("/{id}", name="staff_update")
     * @Method("PUT")
     * @Template("AppBundle:Staff:edit.html.twig")
     * 
     * @Secure(roles="ROLE_STAFF_EDIT")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Staff')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Staff entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('staff_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a Staff entity.
     *
     * @Route("/{id}", name="staff_delete")
     * @Method("DELETE")
     * 
     * @Secure(roles="ROLE_STAFF_DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AppBundle:Staff')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Staff entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('staff'));
    }

    /**
     * Creates a form to delete a Staff entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('staff_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete', 'attr' => array('class' => 'btn btn-sm btn-danger')))
            ->getForm()
        ;
    }
}
