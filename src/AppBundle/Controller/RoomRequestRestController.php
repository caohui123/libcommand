<?php
namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\JsonResponse;
use AppBundle\Entity\RoomRequest;
use AppBundle\Form\RoomRequestType;

class RoomRequestRestController extends FOSRestController{

    /**
     * Return all LiaisonSubject departments
     */
    public function getRoomrequestFacultyliaisonsAction(){
      $em = $this->getDoctrine()->getManager();

      $entities = $em->getRepository('AppBundle:LiaisonSubject')->findBy(array('lvl' => 1), array('name' => 'ASC'));
      $serializer = $this->container->get('serializer');
      $serialized = $serializer->serialize($entities, 'json');
      $response = new Response($serialized, 200, array('Content-Type' => 'application/json'));

      return $response;
    }
    
    /**
     * Return all fixed Equipment types
     */
    public function getRoomrequestFixedequipmentAction(){
      $em = $this->getDoctrine()->getManager();

      $entities = $em->getRepository('AppBundle:RoomRequestEquipment')->findBy(array('isMobile'=>false), array('name' => 'ASC'));
      $serializer = $this->container->get('serializer');
      $serialized = $serializer->serialize($entities, 'json');
      $response = new Response($serialized, 200, array('Content-Type' => 'application/json'));

      return $response;
    }
    
    /**
     * Return all mobile Equipment types
     */
    public function getRoomrequestMobileequipmentAction(){
      $em = $this->getDoctrine()->getManager();

      $entities = $em->getRepository('AppBundle:RoomRequestEquipment')->findBy(array('isMobile'=>true), array('name' => 'ASC'));
      $serializer = $this->container->get('serializer');
      $serialized = $serializer->serialize($entities, 'json');
      $response = new Response($serialized, 200, array('Content-Type' => 'application/json'));

      return $response;
    }
    
    /**
     * Return all room types
     */
    public function getRoomrequestRoomtypesAction(){
      $em = $this->getDoctrine()->getManager();

      $entities = $em->getRepository('AppBundle:RoomRequestRoom')->findBy(array(), array('name' => 'ASC'));
      $serializer = $this->container->get('serializer');
      $serialized = $serializer->serialize($entities, 'json');
      $response = new Response($serialized, 200, array('Content-Type' => 'application/json'));

      return $response;
    }

    /**
     * Handle an AV Request from the library website
     */
    public function postRoomrequestAction(Request $request){
        $entity = new RoomRequest();
        
        $requestData = $request->request->all();
        
        /* Forms on client side must follow naming format of 'roomrequest[formfieldname]' */
        $form = $this->get('form.factory')->createNamed('roomrequest', new RoomRequestType(), $entity);
        $form->handleRequest($request);
        
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            
            //set training to true or false
            if($requestData['roomrequest']['isTrainingNeeded'] == 1){
                $entity->setIsTrainingNeeded(1);
            } else {
                $entity->setIsTrainingNeeded(0);
            }
            
            foreach($requestData['roomrequest']['equipment'] as $equipment){
                $addedEquipment = $em->getRepository('AppBundle:RoomRequestEquipment')->find($equipment);
                if(!$addedEquipment){
                    throw $this->createNotFoundException('RoomRequestEquipment entity not found.');
                }
                $entity->addEquipment($addedEquipment);
            }
            
            $em->persist($entity);
            $em->flush();

            $serializer = $this->get('serializer');
            $serialized = $serializer->serialize($entity, 'json');
            
            $message = \Swift_Message::newInstance();
            $header_image = $message->embed(\Swift_Image::fromPath($this->container->get('kernel')->locateResource('@AppBundle/Resources/public/images/email_banner_640x75.jpg')));
            $message
                ->setSubject('Your Room Request at EMU Library')
                ->setFrom(array('noreply@emulibrary' => 'EMU Library'))
                ->setTo($entity->getFacultyEmail())
                ->setBody(
                    $this->renderView(
                        'AppBundle:RoomRequest/Emails:roomrequest.html.twig',
                        array(
                          'entity' => $entity,
                          'header_image' => $header_image
                        )
                    ),
                    'text/html'
                )
            ;
            $this->get('mailer')->send($message);
            
            return new Response($serialized, 201);
        }

        return new Response(array(
            'errors' => $this->getFormErrors($form)
        ), 400);
       
    }
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
