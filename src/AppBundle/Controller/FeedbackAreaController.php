<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use AppBundle\Entity\FeedbackArea;
use AppBundle\Form\FeedbackAreaType;
use Symfony\Component\HttpFoundation\Response;
use JMS\SecurityExtraBundle\Annotation\Secure;

/**
 * FeedbackArea controller.
 *
 * @Route("/feedbackarea")
 */
class FeedbackAreaController extends Controller
{

    /**
     * Lists all FeedbackArea entities.
     *
     * @Route("/", name="feedbackarea")
     * @Method("GET")
     * @Template()
     * 
     * @Secure(roles="ROLE_FEEDBACK_VIEW")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('AppBundle:FeedbackArea')->findBy(array(), array('name'=>'ASC'));

        $list_service = $this->get('list_service');
        $styled_list = $list_service->feedbackAreasList($entities);

        return array(
            'styled_list' => $styled_list
        );
    }
    /**
     * Creates a new FeedbackArea entity.
     *
     * @Route("/", name="feedbackarea_create")
     * @Method("POST")
     * @Template("AppBundle:FeedbackArea:new.html.twig")
     * 
     * @Secure(roles="ROLE_FEEDBACK_EDIT")
     */
    public function createAction(Request $request)
    {
        $entity = new FeedbackArea();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('feedbackarea_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a FeedbackArea entity.
     *
     * @param FeedbackArea $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(FeedbackArea $entity)
    {
        $form = $this->createForm(new FeedbackAreaType(), $entity, array(
            'action' => $this->generateUrl('feedbackarea_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new FeedbackArea entity.
     *
     * @Route("/new", name="feedbackarea_new")
     * @Method("GET")
     * @Template()
     * 
     * @Secure(roles="ROLE_FEEDBACK_EDIT")
     */
    public function newAction()
    {
        $entity = new FeedbackArea();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a FeedbackArea entity.
     *
     * @Route("/{id}", name="feedbackarea_show")
     * @Method("GET")
     * @Template()
     * 
     * @Secure(roles="ROLE_FEEDBACK_VIEW")
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:FeedbackArea')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find FeedbackArea entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing FeedbackArea entity.
     *
     * @Route("/{id}/edit", name="feedbackarea_edit")
     * @Method("GET")
     * @Template()
     * 
     * @Secure(roles="ROLE_FEEDBACK_EDIT")
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:FeedbackArea')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find FeedbackArea entity.');
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
    * Creates a form to edit a FeedbackArea entity.
    *
    * @param FeedbackArea $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(FeedbackArea $entity)
    {
        $form = $this->createForm(new FeedbackAreaType(), $entity, array(
            'action' => $this->generateUrl('feedbackarea_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update', 'attr'=>array('class'=>'btn btn-sm btn-success')));

        return $form;
    }
    /**
     * Edits an existing FeedbackArea entity.
     *
     * @Route("/{id}", name="feedbackarea_update")
     * @Method("PUT")
     * @Template("AppBundle:FeedbackArea:edit.html.twig")
     * 
     * @Secure(roles="ROLE_FEEDBACK_EDIT")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:FeedbackArea')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find FeedbackArea entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $requestData = $request->request->all();
            var_dump($requestData);
          
            //feedback areas can't have more than one sub-level.
            //if placing an area with children under another category, those children must now become siblings of that area
            if($requestData['appbundle_feedbackarea']['parent'] != null){
              //find parent area
              $parent = $em->getRepository('AppBundle:FeedbackArea')->find($requestData['appbundle_feedbackarea']['parent']);

              $children = $em->getRepository('AppBundle:FeedbackArea')->findBy(array('parent' => $entity));
              if($children){
                foreach($children as $child){
                  $child->setParent($parent);
                  $child->setLvl(1);

                  $em->persist($child);
                }
              }
            }
            
            //if no parent, make sure this area's lvl is set to 0
            else {
              $entity->setLvl(0);
              $em->persist($entity);
            }
          
            $em->flush();

            return $this->redirect($this->generateUrl('feedbackarea_edit', array('id' => $id)));
        }
        
        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a FeedbackArea entity.
     *
     * @Route("/{id}", name="feedbackarea_delete")
     * @Method("DELETE")
     * 
     * @Secure(roles="ROLE_FEEDBACK_DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AppBundle:FeedbackArea')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find FeedbackArea entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('feedbackarea'));
    }

    /**
     * Creates a form to delete a FeedbackArea entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('feedbackarea_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete', 'attr'=>array('class'=>'btn btn-sm btn-danger')))
            ->getForm()
        ;
    }
    
    /**
     * Returns the 'lvl' field of a feebackArea
     *
     * @Route("/parent/{id}", name="feedbackarea_parentlvl")
     * @Method("GET")
     */
    public function getLevelAction($id){
      $em = $this->getDoctrine()->getManager();
      
      $feedbackArea = $em->getRepository('AppBundle:FeedbackArea')->find($id);
      
      if(!$feedbackArea){
        throw $this->createNotFoundException('No FeedbackArea entity found with that ID');
      }
      
      $areaId = $feedbackArea->getLvl();
      
      $response = new Response($areaId, 200, array('Content-Type' => 'text/plain'));
      return $response;
    }
}
