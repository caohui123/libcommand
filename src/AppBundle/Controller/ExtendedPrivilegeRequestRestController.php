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
use Symfony\Component\HttpFoundation\JsonResponse;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Entity\ExtendedPrivilegeRequest;
use AppBundle\Form\ExtendedPrivilegeRequestType;


class ExtendedPrivilegeRequestRestController extends FOSRestController{
    
  /**
     * Return all LiaisonSubject departments
     */
    public function getExtendedprivilegerequestFacultyliaisonsAction(){
      $em = $this->getDoctrine()->getManager();

      $entities = $em->getRepository('AppBundle:LiaisonSubject')->findBy(array('lvl' => 1), array('name' => 'ASC'));
      $serializer = $this->container->get('serializer');
      $serialized = $serializer->serialize($entities, 'json');
      $response = new Response($serialized, 200, array('Content-Type' => 'application/json'));

      return $response;
      
    }
    /**
     * Receive request from the library webstie
     */
    public function postExtendedprivilegerequestAction(Request $request){
        $entity = new ExtendedPrivilegeRequest();

        $form = $this->get('form.factory')->createNamed('', new ExtendedPrivilegeRequestType(), $entity);
        $form->handleRequest($request);
        
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            $serializer = $this->get('serializer');
            $serialized = $serializer->serialize($entity, 'json');

            $facultySubject = $entity->getFacultySubject()->getName();
            $message = \Swift_Message::newInstance();
            $header_image = $message->embed(\Swift_Image::fromPath($this->container->get('kernel')->locateResource('@AppBundle/Resources/public/images/email_banner_640x75.jpg')));
            $message
                ->setSubject('Your Extended Privilege Request at EMU Library')
                ->setFrom('extendedprivilege@emulibrary.com')
                ->setTo($entity->getFacultyEmail())
                ->setBody(
                    $this->renderView(
                        'AppBundle:ExtendedPrivilegeRequest/Emails:extendedprivilegerequest.html.twig',
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

