<?php
/**
 * API for accessing Hours data from the library website
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


class HoursRestController extends FOSRestController{
    /**
     * @Rest\View()
     */
    public function getHoursrestAction(Request $request){
        $em = $this->getDoctrine()->getManager();
        
        $areas = $em->getRepository('AppBundle:HoursArea')->findAll();
        
        $hours = array();
        foreach($areas as $area){
            $hours[] = $em->getRepository('AppBundle:HoursRegular')->findBy(array('area'=>$area));
        }
        
        $serializer = $this->container->get('serializer');
        $serialized = $serializer->serialize($hours, 'json');
        $response = new Response($serialized, 200, array('Content-Type' => 'application/json'));
        
        return $response;
    }
    
    /**
     * @Rest\View()
     * 
     * Return all special events
     */
    public function getHoursrestEventsAction(){
        $em = $this->getDoctrine()->getManager();
        
        $events = $em->getRepository('AppBundle:HoursEvent')->findBy(array(), array('endDate'=>'DESC'));
        
        if(!$events){
            throw $this->createNotFoundException('No special events were found.');
        }
        
        $serializer = $this->container->get('serializer');
        $serialized = $serializer->serialize($events, 'json');
        $response = new Response($serialized, 200, array('Content-Type' => 'application/json'));
        
        return $response;
    }
    
    /**
     * @Rest\View()
     * 
     * Return all special semesters
     */
    public function getHoursrestSemestersAction(){
        $em = $this->getDoctrine()->getManager();
        
        $semesters = $em->getRepository('AppBundle:HoursSemester')->findBy(array(), array('chronOrder'=>'DESC'));
        
        if(!$semesters){
            throw new $this->createNotFoundException('No semesters were found.');
        }
        
        $serializer = $this->container->get('serializer');
        $serialized = $serializer->serialize($semesters, 'json');
        $response = new Response($serialized, 200, array('Content-Type' => 'application/json'));
        
        return $response;
    }
    
    /**
     * @Rest\View()
     * 
     * Return all areas
     */
    public function getHoursrestAreasAction(){
        $em = $this->getDoctrine()->getManager();
        
        $areas = $em->getRepository('AppBundle:HoursArea')->findBy(array(), array('name'=>'ASC'));
        
        if(!$areas){
            throw new $this->createNotFoundException('No areas were found.');
        }
        
        $serializer = $this->container->get('serializer');
        $serialized = $serializer->serialize($areas, 'json');
        $response = new Response($serialized, 200, array('Content-Type' => 'application/json'));
        
        return $response;
    }
    
    /**
     * @Rest\View()
     * 
     * Return hours for an area for a specified date range
     */
    public function getHoursrestAreadaterangeAction(Request $request){
        $em = $this->getDoctrine()->getManager();
        $em2 = $this->getDoctrine()->getEntityManager();
        
        $requestData = $request->query->all();
        
        $areaId = $requestData['areaId'];
        $area = $em->getRepository('AppBundle:HoursArea')->find($areaId);
        if(!$area){
            throw $this->createNotFoundException('Invalid area ID given.');
        }
        
        $startDate = new \DateTime($requestData['startDate']);
        $endDate = new \DateTime($requestData['endDate']);
        
        $totalDays = $startDate->diff($endDate, true);
        $totalDays = intval($totalDays->format('%a'));
        
        $hours = array(); //holds date range hours
        for($i = 0; $i <= $totalDays; $i++){
            $currentDate = clone $startDate; //clone otherwise start date will change as well
            $currentDate->add(new \DateInterval('P'.$i.'D')); //add the incrementer to the initial start date
            
            //find semester under which the current date falls
            $matchingSemester = $em2->createQuery(
                    'SELECT sm from AppBundle:HoursSemester sm WHERE sm.startDate <= :date AND sm.endDate >= :date'
                )
                    ->setParameter('date', $currentDate) 
                    ->setMaxResults(1)
                    ->getOneOrNullResult();

            $dayOfWeek = $currentDate->format('N');
            $dayOfWeek == 7 ? $dayOfWeek = 0 : $dayOfWeek = intval($dayOfWeek);
            
            //see if there are any special hours for the current date
            $specialHour = $em->getRepository('AppBundle:HoursSpecial')->findOneBy(array('area'=>$area, 'eventDate'=>$currentDate));
            if(!$specialHour){
                //no special hour? get regular hour for the day of week and semester given the area
                $regularHour = $em2->createQuery(
                        'SELECT rh from AppBundle:HoursRegular rh WHERE rh.area = :area AND rh.dayOfWeek = :dayOfWeek AND rh.semester = :semester'
                    )
                        ->setParameter('area', $area)
                        ->setParameter('dayOfWeek', $dayOfWeek)
                        ->setParameter('semester', $matchingSemester)
                        ->setMaxResults(1)
                        ->getOneOrNullResult();
                
                $hours[] = $regularHour;
            } else {
                $hours[] = $specialHour;
            }
        }
        
        $serializer = $this->container->get('serializer');
        $serialized = $serializer->serialize($hours, 'json');
        $response = new Response($serialized, 200, array('Content-Type' => 'application/json'));
        return $response;
    }
}

