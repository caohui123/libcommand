<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use AppBundle\Entity\LiaisonSubject;
use AppBundle\Form\LiaisonSubjectType;
use JMS\SecurityExtraBundle\Annotation\Secure;
use Symfony\Component\HttpFoundation\Response;

/**
 * LiaisonSubject controller.
 *
 * @Route("/liaisonsubject")
 */
class LiaisonSubjectController extends Controller
{

    /**
     * Lists all LiaisonSubject entities.
     *
     * @Route("/", name="liaisonsubject")
     * @Method("GET")
     * @Template()
     * 
     * //@Secure(roles="ROLE_LIAISON_VIEW")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('AppBundle:LiaisonSubject')->findBy(array(), array('name'=>'ASC'));
        
        $list_service = $this->get('list_service');
        $styled_list = $list_service->liaisonSubjectsList($entities);

        return array(
            //'entities' => $entities,
            'styled_list' => $styled_list
        );
    }
    /**
     * Creates a new LiaisonSubject entity.
     *
     * @Route("/", name="liaisonsubject_create")
     * @Method("POST")
     * @Template("AppBundle:LiaisonSubject:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new LiaisonSubject();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('liaisonsubject_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a LiaisonSubject entity.
     *
     * @param LiaisonSubject $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(LiaisonSubject $entity)
    {
        $form = $this->createForm(new LiaisonSubjectType(), $entity, array(
            'action' => $this->generateUrl('liaisonsubject_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new LiaisonSubject entity.
     *
     * @Route("/new", name="liaisonsubject_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new LiaisonSubject();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a LiaisonSubject entity.
     *
     * @Route("/{id}", name="liaisonsubject_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:LiaisonSubject')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find LiaisonSubject entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing LiaisonSubject entity.
     *
     * @Route("/{id}/edit", name="liaisonsubject_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:LiaisonSubject')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find LiaisonSubject entity.');
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
    * Creates a form to edit a LiaisonSubject entity.
    *
    * @param LiaisonSubject $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(LiaisonSubject $entity)
    {
        $form = $this->createForm(new LiaisonSubjectType(), $entity, array(
            'action' => $this->generateUrl('liaisonsubject_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing LiaisonSubject entity.
     *
     * @Route("/{id}", name="liaisonsubject_update")
     * @Method("PUT")
     * @Template("AppBundle:LiaisonSubject:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:LiaisonSubject')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find LiaisonSubject entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('liaisonsubject_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a LiaisonSubject entity.
     *
     * @Route("/{id}", name="liaisonsubject_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AppBundle:LiaisonSubject')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find LiaisonSubject entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('liaisonsubject'));
    }

    /**
     * Creates a form to delete a LiaisonSubject entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('liaisonsubject_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
    
    /**
     * Returns the 'lvl' field of a liaisonSubject
     *
     * @Route("/parent/{id}", name="liaisonsubject_parentlvl")
     * @Method("GET")
     */
    public function getLevelAction($id){
      $em = $this->getDoctrine()->getManager();
      
      $liaisonSubject = $em->getRepository('AppBundle:LiaisonSubject')->find($id);
      
      if(!$liaisonSubject){
        throw $this->createNotFoundException('No LiaisonSubject entity found with that ID');
      }
      
      $liaisonId = $liaisonSubject->getLvl();
      
      $response = new Response($liaisonId, 200, array('Content-Type' => 'text/plain'));
      return $response;
    }
}
