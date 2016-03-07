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

      $entities = $em->getRepository('AppBundle:AvRequestEquipment')->findBy(array('isMobile'=>false), array('name' => 'ASC'));
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

      $entities = $em->getRepository('AppBundle:AvRequestEquipment')->findBy(array('isMobile'=>true), array('name' => 'ASC'));
      $serializer = $this->container->get('serializer');
      $serialized = $serializer->serialize($entities, 'json');
      $response = new Response($serialized, 200, array('Content-Type' => 'application/json'));

      return $response;
    }

    /**
     * Handle an AV Request from the library website
     */
    public function postRoomrequestAction(Request $request){
        $entity = new AvRequest();
        
        $formData = $request->request->all();
        
        /* Forms on client side must follow naming format of 'avrequest[formfieldname]' */
        $form = $this->get('form.factory')->createNamed('avrequest', new AvRequestType(), $entity);
        $form->handleRequest($request);
        
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            
            $status = $em->getRepository('AppBundle:AvRequestStatus')->findOneBy(array('name' => 'pending'));
            $entity->setStatus($status); //set status to 'Pending'
            
            $em->persist($entity);
            $em->flush();

            $serializer = $this->get('serializer');
            $serialized = $serializer->serialize($entity, 'json');
            
            /*
            // creating the ACL
            $aclProvider = $this->get('security.acl.provider');
            $objectIdentity = ObjectIdentity::fromDomainObject($entity);
            $acl = $aclProvider->createAcl($objectIdentity);

            // retrieving the security identity of the currently logged-in user
            $tokenStorage = $this->get('security.token_storage');
            $users = $em->getRepository('AppBundle:User')->findAll();
            
            //$tokenStorage->getToken()->getUser();
            foreach($users as $user){
              $securityIdentity = UserSecurityIdentity::fromAccount($user);
              
              // grant owner access based on owner's overall permissions for this type of entity
              $acl->insertObjectAce($securityIdentity, 0);
              $aclProvider->updateAcl($acl);
            }
            */
            
            $facultySubject = $entity->getFacultySubject()->getName();
            $message = \Swift_Message::newInstance();
            $header_image = $message->embed(\Swift_Image::fromPath($this->container->get('kernel')->locateResource('@AppBundle/Resources/public/images/email_banner_640x75.jpg')));
            $message
                ->setSubject('Your Audio/Visual Request at EMU Library')
                ->setFrom(array('avrequest@emulibrary.com' => 'EMU Library'))
                ->setTo($entity->getFacultyEmail())
                ->setBody(
                    $this->renderView(
                        'AppBundle:AvRequest/Emails:avrequest.html.twig',
                        array(
                          'form' => $formData['avrequest'],
                          'facultySubject' => $facultySubject,
                          'events' => $entity->getEvent(),
                          'equipment' => $entity->getEquipment(),
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
