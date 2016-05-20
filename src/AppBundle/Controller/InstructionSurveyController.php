<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use AppBundle\Entity\InstructionSurvey;
use AppBundle\Form\InstructionSurveyType;

/**
 * InstructionSurvey controller.
 *
 * @Route("/instructionsurvey")
 */
class InstructionSurveyController extends Controller
{

    /**
     * Lists all InstructionSurvey entities.
     *
     * //@Route("/", name="instruction_survey")
     * //@Method("GET")
     * //@Template()
     * 
     * LEAVE THIS ROUTE CLOSED UNLESS FOR TESTING PURPOSES.
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('AppBundle:InstructionSurvey')->findAll();

        return array(
            'entities' => $entities,
        );
    }

    /**
     * Creates a form to create a InstructionSurvey entity.
     *
     * @param InstructionSurvey $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(InstructionSurvey $entity)
    {
        $form = $this->createForm(new InstructionSurveyType(), $entity, array(
            'action' => $this->generateUrl('instructionsurvey_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }
    /**
     * Finds and displays a InstructionSurvey entity.
     *
     * @Route("/{id}", name="instructionsurvey_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:InstructionSurvey')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find InstructionSurvey entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }
    
    /**
     * Finds and displays list of InstructionSurvey entities based on an Instruction record.
     *
     * @Route("/list/{instruction_id}", name="instructionsurvey_list")
     * @Method("GET")
     * @Template("AppBundle:InstructionSurvey:index.html.twig")
     */
    public function showSurveysForInstructionAction($instruction_id)
    {
        $currentUser = $this->get('security.token_storage')->getToken()->getUser();
        
        if(null === $currentUser->getStaffMember()){
            throw new NoAssociatedStaffException();
        }
                
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('AppBundle:InstructionSurvey')->findBy(array('instruction' => $instruction_id), array('created' => 'DESC'));
      
        // Get the creator of the instruction session to which these surveys belong
        $instruction_session = $em->getRepository('AppBundle:Instruction')->find($instruction_id);
        
        if (!$instruction_session) {
            throw $this->createNotFoundException('Unable to find Instruction entity.');
        }
        
        // If the current user did not create the original instruction session to which these surveys belong, deny them access to this list
        $this->denyAccessUnlessGranted('edit', $instruction_session, 'In order to view these surveys, you must be the person who created the instruction session to which these surveys belong.');
        
        //Get the aggregate rating for all surveys taken for the instruction session. 
        $instructionService = $this->get('instruction_service');
        $average_survey_rating = $instructionService->getAverageSurveyScoreBySession($instruction_session);
        
        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $entities, 
            1/*page number*/,
            10/*limit per page*/
        );

        return array(
            'pagination'    => $pagination,
            'session_id'    => $instruction_id,
            'average_survey_rating' => $average_survey_rating,
        );
    }
    

    /**
     * Displays a form to edit an existing InstructionSurvey entity.
     *
     * @Route("/{id}/edit", name="instructionsurvey_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:InstructionSurvey')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find InstructionSurvey entity.');
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
    * Creates a form to edit a InstructionSurvey entity.
    *
    * @param InstructionSurvey $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(InstructionSurvey $entity)
    {
        $form = $this->createForm(new InstructionSurveyType(), $entity, array(
            'action' => $this->generateUrl('instructionsurvey_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing InstructionSurvey entity.
     *
     * @Route("/{id}", name="instructionsurvey_update")
     * @Method("PUT")
     * @Template("AppBundle:InstructionSurvey:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:InstructionSurvey')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find InstructionSurvey entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('instructionsurvey_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a InstructionSurvey entity.
     *
     * @Route("/{id}", name="instructionsurvey_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AppBundle:InstructionSurvey')->find($id);
            
            // Get the corresponding Instruction id of this entity to send the user back to the list of remaining surveys for this instruction session.
            $instruction_session_id = $entity->getInstruction()->getId();

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find InstructionSurvey entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('instructionsurvey_list', array('instruction_id' => $instruction_session_id)));
    }

    /**
     * Creates a form to delete a InstructionSurvey entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('instructionsurvey_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array(
                    'label' => 'Delete',
                    'attr' => array(
                        'class' => 'btn btn-sm btn-danger',
                        'onclick' => 'return confirm("Are you sure you want to delete this survey?")'
                        )
                ))
            ->getForm()
        ;
    }
    
    /**
     * Displays a printer-friendly InstructionSurvey entity.
     *
     * @Route("/{id}/print", name="instructionsurvey_print")
     * @Method("GET")
     * @Template()
     */
    public function printAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:InstructionSurvey')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find InstructionSurvey entity.');
        }

        return array(
            'entity'      => $entity,
        );
    }
}
