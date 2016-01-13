<?php
/**
 * API for accessing DEPARTMENTS AND STAFF!
 */
namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\FOSRestController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use AppBundle\Entity\HoursSemester;
use AppBundle\Form\HoursSemesterType;
use AppBundle\Entity\HoursRegular;
use Symfony\Component\HttpFoundation\JsonResponse;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Response;


class DepartmentStaffRestController extends FOSRestController{
    /**
     * Get all staff members
     */
    public function getStaffAllAction(){
        $em = $this->getDoctrine()->getManager();
        
        $staff = $em->getRepository('AppBundle:Staff')->findBy(array(), array('lastName'=>'ASC'));
        
        $serializer = $this->container->get('serializer');
        $serialized = $serializer->serialize($staff, 'json');
        $response = new Response($serialized, 200, array('Content-Type' => 'application/json'));
        
        return $response;
    }
    
    /**
     * Get individual staff member by employee id (not entity record id)
     */
    public function getStaffAction(Request $request){
      $requestData = $request->query->all();
      
      $employeeId = $requestData['id'];
      
      $em = $this->getDoctrine()->getManager();
      
      $employee = $em->getRepository('AppBundle:Staff')->findBy(array('staffId' => $employeeId));
      
      if(!$employee){
        throw $this->createNotFoundException('No employee with that ID could be found.');
      }
      
      $serializer = $this->container->get('serializer');
      $serialized = $serializer->serialize($employee, 'json');
      $response = new Response($serialized, 200, array('Content-Type' => 'application/json'));
        
      return $response;
    }
    
}

