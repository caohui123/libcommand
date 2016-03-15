<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use AppBundle\Entity\HoursSemester;
use AppBundle\Form\HoursSemesterType;
use AppBundle\Entity\HoursRegular;
use JMS\SecurityExtraBundle\Annotation\Secure;

/**
 * HoursSemester controller.
 *
 * @Route("/hourssemester")
 */
class HoursSemesterController extends Controller
{

    /**
     * Lists all HoursSemester entities.
     *
     * @Route("/", name="hourssemester")
     * @Method("GET")
     * @Template()
     * 
     * @Secure(roles="ROLE_HOURS_VIEW")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('AppBundle:HoursSemester')->findBy(array(), array('chronOrder'=>'DESC'));

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new HoursSemester entity.
     *
     * @Route("/", name="hourssemester_create")
     * @Method("POST")
     * @Template("AppBundle:HoursSemester:new.html.twig")
     * 
     * @Secure(roles="ROLE_HOURS_EDIT")
     */
    public function createAction(Request $request)
    {
        $entity = new HoursSemester();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            
            //create empty hours for Sunday-Satruday for each newly-created semester for each area
            $areas = $em->getRepository('AppBundle:HoursArea')->findAll();
            if ($areas) {
                foreach($areas as $area){
                    for($i=0; $i<7; $i++){
                        $regularHour = new HoursRegular();

                        $regularHour->setArea($area);
                        $regularHour->setSemester($entity);
                        $regularHour->setCloseTime(new \DateTime('00:00:00'));
                        $regularHour->setOpenTime(new \DateTime('00:00:00'));
                        $regularHour->setDayOfWeek($i);
                        $regularHour->setStatus(0);

                        $em->persist($regularHour);
                    }
                }
            }
            
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('hourssemester_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a HoursSemester entity.
     *
     * @param HoursSemester $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(HoursSemester $entity)
    {
        $form = $this->createForm(new HoursSemesterType(), $entity, array(
            'action' => $this->generateUrl('hourssemester_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new HoursSemester entity.
     *
     * @Route("/new", name="hourssemester_new")
     * @Method("GET")
     * @Template()
     * 
     * @Secure(roles="ROLE_HOURS_EDIT")
     */
    public function newAction()
    {
        $entity = new HoursSemester();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a HoursSemester entity.
     *
     * @Route("/{id}", name="hourssemester_show")
     * @Method("GET")
     * @Template()
     * 
     * @Secure(roles="ROLE_HOURS_VIEW")
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:HoursSemester')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find HoursSemester entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing HoursSemester entity.
     *
     * @Route("/{id}/edit", name="hourssemester_edit")
     * @Method("GET")
     * @Template()
     * 
     * @Secure(roles="ROLE_HOURS_EDIT")
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:HoursSemester')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find HoursSemester entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView()
        );
    }

    /**
    * Creates a form to edit a HoursSemester entity.
    *
    * @param HoursSemester $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(HoursSemester $entity)
    {
        $form = $this->createForm(new HoursSemesterType(), $entity, array(
            'action' => $this->generateUrl('hourssemester_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update', 'attr'=>array('class'=>'btn btn-sm btn-success')));

        return $form;
    }
    /**
     * Edits an existing HoursSemester entity.
     *
     * @Route("/{id}", name="hourssemester_update")
     * @Method("PUT")
     * @Template("AppBundle:HoursSemester:edit.html.twig")
     * 
     * @Secure(roles="ROLE_HOURS_EDIT")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:HoursSemester')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find HoursSemester entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('hourssemester_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a HoursSemester entity.
     *
     * @Route("/{id}", name="hourssemester_delete")
     * @Method("DELETE")
     * 
     * @Secure(roles="ROLE_HOURS_DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AppBundle:HoursSemester')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find HoursSemester entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('hourssemester'));
    }

    /**
     * Creates a form to delete a HoursSemester entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('hourssemester_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete', 'attr'=>array('class'=>'btn btn-sm btn-danger')))
            ->getForm()
        ;
    }
}
