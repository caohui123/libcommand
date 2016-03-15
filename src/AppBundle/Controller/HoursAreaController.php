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
use AppBundle\Entity\HoursSpecial;
use AppBundle\Form\HoursRegularType;
use AppBundle\Form\HoursSpecialType;
use AppBundle\Resources\Services\HoursService;
use Symfony\Component\HttpFoundation\Response;
use JMS\SecurityExtraBundle\Annotation\Secure;

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
     * 
     * @Secure(roles="ROLE_HOURS_VIEW")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('AppBundle:HoursArea')->findBy(array(), array('displayOrder' => 'ASC'));

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
     * 
     * @Secure(roles="ROLE_HOURS_EDIT")
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
                        $regularHour->setStatus(0);

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
        $form->add('displayOrder', 'hidden', array('data' => 0));
        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new HoursArea entity.
     *
     * @Route("/new", name="hoursarea_new")
     * @Method("GET")
     * @Template()
     * 
     * @Secure(roles="ROLE_HOURS_EDIT")
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
     * 
     * @Secure(roles="ROLE_HOURS_VIEW")
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
     * 
     * @Secure(roles="ROLE_HOURS_EDIT")
     */
    public function editAction($id)
    {
        $return = array(); //initialize the array of items to return to the view
        
        $em = $this->getDoctrine()->getManager();
        $em2 = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('AppBundle:HoursArea')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find HoursArea entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);
        
        $service = $this->get('hours_service'); //the hours service
        
        $semesterForm = $service->createSemesterDropdown(); //dropdown of semesters
        $return['semester_form'] = $semesterForm;
        
        //regular hours for most recent semester
        $semesterQuery = $em2->createQuery(
                    'SELECT s FROM AppBundle:HoursSemester s ORDER BY s.chronOrder DESC'
                )->setMaxResults(1);
        $semester = $semesterQuery->getSingleResult();
        if($semester){
            for($day = 0; $day < 7; $day++){
                $return['day_'.$day] = $this->getSemesterRegularHours($semester, $entity, $day);
            }
        }
        
        //date range for current week
        $weekRange = $service->getWeekDateRange(new \DateTime());
        
        for($dayOfWeek = 0; $dayOfWeek < 7; $dayOfWeek++){

            //query any special hours for the area and the date
            $specialHour = $em2->createQuery(
                'SELECT sh from AppBundle:HoursSpecial sh WHERE sh.area = :area AND sh.eventDate = :eventDate'
            )
                ->setParameter('area', $entity)
                ->setParameter('eventDate', $weekRange[$dayOfWeek])
                ->setMaxResults(1)
                ->getOneOrNullResult();
            
            //date of current day of week in loop 
            $return['date_'.$dayOfWeek] = date('n/j/y', strtotime($weekRange[$dayOfWeek]));
            
            //entity edit form
            $return['specialday_'.$dayOfWeek] = $this->getAreaSpecialHours($weekRange[$dayOfWeek], $entity);
            //entity delete form
            if($specialHour){
                $return['specialdayDelete_'.$dayOfWeek] = $this->getSpecialHourDeleteForm($specialHour);
            }
            
        }
        
        $return['entity'] = $entity;
        $return['edit_form'] = $editForm->createView();
        $return['delete_form'] =$deleteForm->createView();

        return $return;
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
            'attr' => array(
                'id' => 'appbundle_hoursarea'
            )
        ));

        $form->add('submit', 'submit', array('label' => 'Update Area', 'attr'=>array('class'=>'btn btn-sm btn-success')));

        return $form;
    }
    /**
     * Edits an existing HoursArea entity.
     *
     * @Route("/{id}", name="hoursarea_update")
     * @Method("PUT")
     * @Template("AppBundle:HoursArea:edit.html.twig")
     * 
     * @Secure(roles="ROLE_HOURS_EDIT")
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
     * 
     * @Secure(roles="ROLE_HOURS_DELETE")
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
            ->add('submit', 'submit', array(
                'label' => 'Delete Area',
                'attr' => array(
                    'class' => 'btn btn-sm btn-danger'
                )
            ))
            ->getForm()
        ;
    }
    
    /**
     * Update areas via AJAX 
     * 
     * @Route("/displayorder", name="displayorder_update")
     * @Method("POST")
     * 
     * @Secure(roles="ROLE_HOURS_EDIT")
     */
    public function updateDisplayOrderAction(Request $request){
      $em = $this->getDoctrine()->getManager();
      
      $requestData = $request->request->all();
      
      $areas = $requestData['area'];
      
      $displayOrder = 0;
      foreach($areas as $area){
        $findArea = $em->getRepository('AppBundle:HoursArea')->find($area);
        
        if(!$findArea){
          throw $this->createNotFoundException('Area with id ' . $area . ' not found.');
        }
        //update the area's display order
        $findArea->setDisplayOrder($displayOrder);
        
        $displayOrder++;
      }
      $em->flush();
      
      $response = new Response('Area display order has been updated.', 200, array('Content-Type' => 'text/plain'));
        
      return $response;
    }
    
    /**
     * Get the regular hours for an area during a given semester on a given day of the week
     * 
     * @param int $semester  The semester entity to use as criteria
     * @param int $area      The area entity to use as criteria
     * @param int $dayOfWeek 0-6 (Sunday-Saturday)
     * @return Form $regularHoursForm
     */
    public function getSemesterRegularHours($semester, $area, $dayOfWeek){
        $em = $this->getDoctrine()->getManager();
        
        $regularHour = $em->getRepository('AppBundle:HoursRegular')->findOneBy(array('area'=>$area, 'semester'=>$semester, 'dayOfWeek'=>$dayOfWeek));

        //Help on using other Controllers as services: http://stackoverflow.com/questions/24889961/symfony-2-error-call-to-a-member-function-get-on-a-non-object
        $hoursController = $this->get('hoursRegular_controller');
        $regularHoursForm = $hoursController->createEditForm($regularHour);
        
        return $regularHoursForm->createView();
    } 
    
    /**
     * Get the special hours for an area on a given date
     * 
     * @param String $date
     * @param HoursArea $area
     * @return Form $specialHoursForm
     */
    public function getAreaSpecialHours($date, HoursArea $area){
        $em = $this->getDoctrine()->getManager();
        
        $specialHoursController = $this->get('hoursSpecial_controller');
        $specialHour = $em->getRepository('AppBundle:HoursSpecial')->findOneBy(array('area'=>$area, 'eventDate'=> new \DateTime($date) ));
        
        if(!$specialHour){
            $specialHour = new HoursSpecial();
            $specialHoursForm = $specialHoursController->createCreateForm($specialHour, $area, new \DateTime($date));

            return $specialHoursForm->createView();
        }
        
        $specialHoursForm = $specialHoursController->createEditForm($specialHour, $area, new \DateTime($date));
        
        
        return $specialHoursForm->createView();
    }
    
    /**
     * Get the special hours delete form for a SpecialHour entity
     * 
     * @param HoursSpecial $entity
     * @return Form $specialHoursForm
     */
    public function getSpecialHourDeleteForm(HoursSpecial $entity = null){
        
        //will be null if no hour exists for the given date
        if(!$entity){
            return null;
        }
        
        $specialHoursController = $this->get('hoursSpecial_controller');
        $specialHoursForm = $specialHoursController->createDeleteForm($entity->getId());
        
        return $specialHoursForm->createView();
    }
}
