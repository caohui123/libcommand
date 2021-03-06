<?php
namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use AppBundle\Entity\AvRequest;
use AppBundle\Form\AvRequestType;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\JsonResponse;

class AvRequestRestController extends FOSRestController{

    public function getAvrequestsAction(Request $request){
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('AppBundle:AvRequest')->findAll();
        $serializer = $this->container->get('serializer');
        $serialized = $serializer->serialize($entities, 'json');
        $response = new Response($serialized, 200, array('Content-Type' => 'application/json'));
        
        return $response;
    }

    /**
     * Return all LiaisonSubject departments
     */
    public function getAvrequestFacultyliaisonsAction(){
      $em = $this->getDoctrine()->getManager();

      $entities = $em->getRepository('AppBundle:LiaisonSubject')->findBy(array('lvl' => 1), array('name' => 'ASC'));
      $serializer = $this->container->get('serializer');
      $serialized = $serializer->serialize($entities, 'json');
      $response = new Response($serialized, 200, array('Content-Type' => 'application/json'));

      return $response;
    }
    
    /**
     * Return all Equipment types
     */
    public function getAvrequestEquipmentAction(){
      $em = $this->getDoctrine()->getManager();

      $entities = $em->getRepository('AppBundle:AvRequestEquipment')->findBy(array(), array('name' => 'ASC'));
      $serializer = $this->container->get('serializer');
      $serialized = $serializer->serialize($entities, 'json');
      $response = new Response($serialized, 200, array('Content-Type' => 'application/json'));

      return $response;
    }

    /**
     * Handle an AV Request from the library website
     */
    public function postAvrequestAction(Request $request){
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
                          //'form' => $formData['avrequest'],
                          //'facultySubject' => $facultySubject,
                          //'events' => $entity->getEvent(),
                          //'equipment' => $entity->getEquipment(),
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
