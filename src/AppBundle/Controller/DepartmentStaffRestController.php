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
     * 
     * @var $employeeId  The employee's staffID (e.g. 'lib198')
     */
    public function getStaffAction($employeeId){
      $em = $this->getDoctrine()->getManager();
      
      $employee = $em->getRepository('AppBundle:Staff')->findBy(array('staffId' => $employeeId));
      
      if(!$employee){
        throw $this->createNotFoundException('No employee with that staff ID could be found.');
      }
      
      $serializer = $this->container->get('serializer');
      $serialized = $serializer->serialize($employee, 'json');
      $response = new Response($serialized, 200, array('Content-Type' => 'application/json'));
        
      return $response;
    }
    
    /**
     * Get a group of staff members by first letter of the last name
     * 
     * @var $letter  The first letter of the last name
     */
    public function getStaffByletterAction($letter){
      $em2 = $this->getDoctrine()->getEntityManager();
      
      $employees = $em2->createQuery('
            SELECT s FROM AppBundle:Staff s WHERE s.lastName LIKE :letter ORDER BY s.lastName ASC
            ')
            ->setParameter('letter', $letter . '%')
            ->getResult();
      
      if(!$employees){
        throw $this->createNotFoundException('No employees with last name beginning with '.$letter.' could be found.');
      }
      
      $serializer = $this->container->get('serializer');
      $serialized = $serializer->serialize($employees, 'json');
      $response = new Response($serialized, 200, array('Content-Type' => 'application/json'));
        
      return $response;
    }
    
    /**
     * Get all liaison departments in College>Department>Program order
     */
    public function getLiaisonsAllAction(){
      $em2 = $this->getDoctrine()->getEntityManager();
      
      $liaisonDepts = $em2->createQuery('
            SELECT l FROM AppBundle:LiaisonSubject l ORDER BY l.root, l.lft ASC
            ')
            ->getResult();
      
      $serializer = $this->container->get('serializer');
      $serialized = $serializer->serialize($liaisonDepts, 'json');
      $response = new Response($serialized, 200, array('Content-Type' => 'application/json'));
        
      return $response;
    }
    
    /**
     * Get top-level liaison colleges
     */
    public function getLiaisonsToplevelAction(){
      $em = $this->getDoctrine()->getManager();
      
      $topLevels = $em->getRepository('AppBundle:LiaisonSubject')->findBy(array('lvl' => 0), array('name'=>'ASC'));
      
      if(!$topLevels){
        throw $this->createNotFoundException('No top-level departments found.');
      }
      
      $serializer = $this->container->get('serializer');
      $serialized = $serializer->serialize($topLevels, 'json');
      $response = new Response($serialized, 200, array('Content-Type' => 'application/json'));
        
      return $response;
    }
    
    /**
     * Get all departments and services
     */
    public function getDepartmentsAction(){
      $em2 = $this->getDoctrine()->getEntityManager();
      
      $liaisonDepts = $em2->createQuery('
            SELECT l FROM AppBundle:Department l ORDER BY l.root, l.lft ASC
            ')
            ->getResult();
      
      $serializer = $this->container->get('serializer');
      $serialized = $serializer->serialize($liaisonDepts, 'json');
      $response = new Response($serialized, 200, array('Content-Type' => 'application/json'));
        
      return $response;
    }
    
    /**
     * Get top-level departments
     */
    public function getDepartmentsToplevelAction(){
      $em = $this->getDoctrine()->getManager();
      
      $topLevels = $em->getRepository('AppBundle:Department')->findBy(array('lvl' => 0), array('name'=>'ASC'));
      
      if(!$topLevels){
        throw $this->createNotFoundException('No top-level departments found.');
      }
      
      $serializer = $this->container->get('serializer');
      $serialized = $serializer->serialize($topLevels, 'json');
      $response = new Response($serialized, 200, array('Content-Type' => 'application/json'));
        
      return $response;
    }
    
     /**
     * Get individual department
     * 
     * @var id The department's id
     */
    public function getDepartmentAction($id){
      $em = $this->getDoctrine()->getManager();
      
      $department = $em->getRepository('AppBundle:Department')->find($id);
      
      if(!$department){
        throw $this->createNotFoundException('No department with that ID could be found.');
      }
      
      $serializer = $this->container->get('serializer');
      $serialized = $serializer->serialize($department, 'json');
      $response = new Response($serialized, 200, array('Content-Type' => 'application/json'));
        
      return $response;
    }
}

