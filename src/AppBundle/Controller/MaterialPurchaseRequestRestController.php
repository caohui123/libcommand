<?php
/**
 * API for processing Materials Purchase Requests from the library website
 */
namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\FOSRestController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use AppBundle\Entity\MaterialPurchaseRequest;
use AppBundle\Form\MaterialPurchaseRequestType;
use Symfony\Component\HttpFoundation\JsonResponse;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Response;


class MaterialPurchaseRequestRestController extends FOSRestController{
  
  /**
     * Return all LiaisonSubject departments
     */
    public function getMaterialpurchaseFacultyliaisonsAction(){
      $em = $this->getDoctrine()->getManager();

      $entities = $em->getRepository('AppBundle:LiaisonSubject')->findBy(array('lvl' => 1), array('name' => 'ASC'));
      $serializer = $this->container->get('serializer');
      $serialized = $serializer->serialize($entities, 'json');
      $response = new Response($serialized, 200, array('Content-Type' => 'application/json'));

      return $response;
    }
    
  /**
     * Return all MediaItem entities
     */
    public function getMaterialpurchaseMediatypesAction(){
      $em = $this->getDoctrine()->getManager();

      $entities = $em->getRepository('AppBundle:MediaType')->findBy(array(), array('name' => 'ASC'));
      $serializer = $this->container->get('serializer');
      $serialized = $serializer->serialize($entities, 'json');
      $response = new Response($serialized, 200, array('Content-Type' => 'application/json'));

      return $response;
    }
    
    /**
     * Return all PatronGroup entities
     */
    public function getMaterialpurchasePatrongroupsAction(){
      $em = $this->getDoctrine()->getManager();

      $entities = $em->getRepository('AppBundle:PatronGroup')->findBy(array(), array('name' => 'ASC'));
      $serializer = $this->container->get('serializer');
      $serialized = $serializer->serialize($entities, 'json');
      $response = new Response($serialized, 200, array('Content-Type' => 'application/json'));

      return $response;
    }
    
    /**
     * Return all MaterialPurchaseRequestReason entities
     */
    public function getMaterialpurchaseReasonsAction(){
      $em = $this->getDoctrine()->getManager();

      $entities = $em->getRepository('AppBundle:MaterialPurchaseRequestReason')->findAll();
      $serializer = $this->container->get('serializer');
      $serialized = $serializer->serialize($entities, 'json');
      $response = new Response($serialized, 200, array('Content-Type' => 'application/json'));

      return $response;
    }
    
  /**
     * Receive feedback from the library webstie
     */
    public function postMaterialpurchaseAction(Request $request){
        $entity = new MaterialPurchaseRequest();
        
        $requestData = $request->request->all();
         
        $form = $this->get('form.factory')->createNamed('', new MaterialPurchaseRequestType(), $entity);
        $form->handleRequest($request);
        
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            
            //log the source of the material
            if($requestData['sourceRadio'] == 'other'){
              $entity->setSource($requestData['sourceOther']);
            } else {
              $entity->setSource($requestData['sourceRadio']);
            }
            
            $em->persist($entity);
            $em->flush();

            $serializer = $this->get('serializer');
            $serialized = $serializer->serialize($entity, 'json');
            
            if(null == $entity->getPatronDepartment()){
              $department = null;
            } else {
              $department = $entity->getPatronDepartment()->getName();
            }
            
            if(null == $entity->getMediaType()){
              $mediaType = null;
            } else {
              $mediaType = $entity->getMediaType()->getName();
            }
            
            if(null == $entity->getPatronGroup()){
              $patronGroup = null;
            } else {
              $patronGroup = $entity->getPatronGroup()->getName();
            }
            
            if(null == $entity->getReasonToAdd()){
              $reason = null;
            } else {
              $reason = $entity->getReasonToAdd()->getName();
            }

            //send the requestor an email
            $message = \Swift_Message::newInstance();
            $header_image = $message->embed(\Swift_Image::fromPath($this->container->get('kernel')->locateResource('@AppBundle/Resources/public/images/email_banner_640x75.jpg')));
            $message
                  ->setSubject('Your Material Purchase Request at EMU Library')
                  ->setFrom('materialrequest@emulibrary.com')
                  ->setTo($entity->getPatronEmail())
                  ->setBody(
                        $this->renderView(
                            'AppBundle:MaterialPurchaseRequest/Emails:materialpurchaserequest.html.twig',
                            array(
                              'form' => $requestData,
                              'department' => $department,
                              'mediaType' => $mediaType,
                              'academicStatus' => $patronGroup,
                              'reason' => $reason,
                              'header_image' => $header_image
                            )
                        ),
                        'text/html'
                    );
              $this->get('mailer')->send($message);
          
            return new Response($serialized, 201);
        }

        return new JsonResponse(array(
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


