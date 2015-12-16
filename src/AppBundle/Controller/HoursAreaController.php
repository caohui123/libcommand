<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use AppBundle\Entity\HoursArea;
use AppBundle\Form\HoursAreaType;
use AppBundle\Entity\HoursRegular;
use AppBundle\Form\HoursRegularType;
use AppBundle\Form\HoursSpecialType;

/**
 * HoursArea controller.
 *
 * @Route("/hoursarea")
 */
class HoursAreaController extends Controller
{

    /**
     * Lists all HoursArea entities.
     *
     * @Route("/", name="hoursarea")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('AppBundle:HoursArea')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new HoursArea entity.
     *
     * @Route("/", name="hoursarea_create")
     * @Method("POST")
     * @Template("AppBundle:HoursArea:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new HoursArea();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            
            //create empty hours for Sunday-Satruday for each newly-created area for each semester
            $semesters = $em->getRepository('AppBundle:HoursSemester')->findAll();
            if ($semesters) {
                foreach($semesters as $semester){
                    for($i=0; $i<7; $i++){
                        $regularHour = new HoursRegular();

                        $regularHour->setArea($entity);
                        $regularHour->setSemester($semester);
                        $regularHour->setCloseTime(new \DateTime('00:00:00'));
                        $regularHour->setOpenTime(new \DateTime('00:00:00'));
                        $regularHour->setDayOfWeek($i);
                        $regularHour->setIs24Hour(0);
                        $regularHour->setIsClosed(0);

                        $em->persist($regularHour);
                    }
                }
            }
            
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('hoursarea_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a HoursArea entity.
     *
     * @param HoursArea $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(HoursArea $entity)
    {
        $form = $this->createForm(new HoursAreaType(), $entity, array(
            'action' => $this->generateUrl('hoursarea_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new HoursArea entity.
     *
     * @Route("/new", name="hoursarea_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new HoursArea();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a HoursArea entity.
     *
     * @Route("/{id}", name="hoursarea_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:HoursArea')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find HoursArea entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing HoursArea entity.
     *
     * @Route("/{id}/edit", name="hoursarea_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:HoursArea')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find HoursArea entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);
        
        $semesters = $em->getRepository('AppBundle:HoursSemester')->findAll();
        
        if($semesters){
            foreach($semesters as $semester){
                $regularHours = $em->getRepository('AppBundle:HoursRegular')->findBy(array('area'=>$entity->getId(), 'semester'=>$semester->getId()));
                
                $day=0;
                foreach($regularHours as $regularHour){
                    $regularHoursForm = $this->createForm(new HoursRegularType(), $regularHour, array(
                        //'action' => $this->generateUrl('hoursregular_update', array('id' => $entity->getId())),
                        'method' => 'PUT',
                    ));
                    $regularHoursForm->add('submit', 'submit', array('label' => 'Update'));
                    
                    $day++;
                };
            }
        }
        
        /*$regularHoursForm = $this->createForm(new HoursRegularType(), $entity, array(
            'action' => $this->generateUrl('hoursregular_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));
        $regularHoursForm->add('submit', 'submit', array('label' => 'Update'));

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            //'regular_hours_form' => $regularHoursForm->createView(),
            //'special_hours_form' => $specialHoursForm->createView(),
        );*/
    }

    /**
    * Creates a form to edit a HoursArea entity.
    *
    * @param HoursArea $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(HoursArea $entity)
    {
        $form = $this->createForm(new HoursAreaType(), $entity, array(
            'action' => $this->generateUrl('hoursarea_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing HoursArea entity.
     *
     * @Route("/{id}", name="hoursarea_update")
     * @Method("PUT")
     * @Template("AppBundle:HoursArea:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:HoursArea')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find HoursArea entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('hoursarea_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a HoursArea entity.
     *
     * @Route("/{id}", name="hoursarea_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AppBundle:HoursArea')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find HoursArea entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('hoursarea'));
    }

    /**
     * Creates a form to delete a HoursArea entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('hoursarea_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
