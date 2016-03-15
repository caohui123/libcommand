<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\JsonResponse;
use AppBundle\Entity\HoursArea;
use AppBundle\Form\HoursAreaType;
use AppBundle\Entity\HoursRegular;
use AppBundle\Form\HoursRegularType;
use AppBundle\Form\HoursSpecialType;
use JMS\SecurityExtraBundle\Annotation\Secure;

/**
 * HoursRegular controller.
 *
 * @Route("/hoursregular")
 */
class HoursRegularController extends Controller
{
    /**
     * Edits an existing HoursRegular entity.
     *
     * @Route("/{id}", name="hoursregular_post")
     * @Method("POST")
     * 
     * @Secure(roles="ROLE_HOURS_EDIT")
     */
    public function postAction(Request $request, $id){
        $em = $this->getDoctrine()->getManager();
        
        $entity = $em->getRepository('AppBundle:HoursRegular')->find($id);
        
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find HoursRegular entity.');
        }
        
        //create blank named form for the RegularHour instead of calling the createEditForm
        $editForm = $this->get('form.factory')->createNamed('', new HoursRegularType(), $entity);
        $editForm->handleRequest($request);
        
        if ($editForm->isValid()) {
            $em->flush();

            $serializer = $this->get('serializer');
            $serialized = $serializer->serialize($entity, 'json');  
            
            return new JsonResponse($serialized, 201);
        }

        return new JsonResponse(array(
            $this->getFormErrors($editForm)
        ), 400);
    }
    
    /**
    * Creates a form to edit a HoursRegular entity.
    *
    * @param HoursRegular $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    public function createEditForm(HoursRegular $entity)
    {        
        $form = $this->createForm(new HoursRegularType(), $entity, array(
            'action' => $this->generateUrl('hoursregular_post', array('id' => $entity->getId())),
            'method' => 'POST',
            'attr' => array('class' => 'regularHours_form')
        ));

        $form->add('submit', 'submit', array('label' => 'Save Day'));

        return $form;
    }
    
    /**
     * Get regular hours for a semester.
     *
     * @Route("/bysemester", name="semester_reghours")
     * @Method("GET")
     * 
     * @Secure(roles="ROLE_HOURS_VIEW")
     */
    public function getHoursBySemesterAction(Request $request){
        //retreive the URL parameters
        $semesterId = $request->query->get('semesterId');
        $areaId = $request->query->get('areaId');
        
        $em = $this->getDoctrine()->getManager();
        
        $semester = $em->getRepository('AppBundle:HoursSemester')->find($semesterId);
        $area = $em->getRepository('AppBundle:HoursArea')->find($areaId);
        
        $areaController = $this->get('hoursArea_controller');
        
        $return = array(); //initialize forms array
        
        for($day = 0; $day < 7; $day++){
            $return['day_'.$day] = $areaController->getSemesterRegularHours($semester, $area, $day);
        }

        
        return $this->render('AppBundle:HoursArea:areaRegularHours.html.twig', $return);
    }
    
    /**
     * Get any global or individual field errors in a form
     * 
     * @param \Symfony\Component\Form\Form $form
     * @return array $errors  Global or field errors with the form
     */
    protected function getFormErrors(\Symfony\Component\Form\Form $form)
    {
        $errors = array();

        foreach ($form->getErrors() as $error) {
            $errors['global'][] = $error->getMessage();
        }

        foreach ($form as $field) {
            if (!$field->isValid()) {
                foreach ($field->getErrors() as $error) {
                    $errors['fields'][$field->getName()] = $error->getMessage();
                }
            }
        }

        return $errors;
    }
}
