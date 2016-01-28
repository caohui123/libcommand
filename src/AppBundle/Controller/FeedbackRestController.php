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
use AppBundle\Entity\Feedback;
use AppBundle\Entity\FeedbackArea;
use AppBundle\Entity\FeedbackCategory;
use AppBundle\Form\FeedbackType;
use Symfony\Component\HttpFoundation\JsonResponse;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Response;


class FeedbackRestController extends FOSRestController{
    /**
     * Get feedback categories
     */
    public function getFeedbackCategoriesAction(){
        $em = $this->getDoctrine()->getManager();
        
        $categories = $em->getRepository('AppBundle:FeedbackCategory')->findBy(array(), array('name'=>'ASC'));
        
        if(!$categories){
          throw $this->createNotFoundException("No feedback categories were found.");
        }
        
        $serializer = $this->container->get('serializer');
        $serialized = $serializer->serialize($categories, 'json');
        $response = new Response($serialized, 200, array('Content-Type' => 'application/json'));
        
        return $response;
    }
    
    /**
     * Get patrongroup categories
     */
    public function getFeedbackPatrongroupsAction(){
        $em = $this->getDoctrine()->getManager();
        
        $categories = $em->getRepository('AppBundle:PatronGroup')->findBy(array(), array('name'=>'ASC'));
        
        if(!$categories){
          throw $this->createNotFoundException("No patron groups were found.");
        }
        
        $serializer = $this->container->get('serializer');
        $serialized = $serializer->serialize($categories, 'json');
        $response = new Response($serialized, 200, array('Content-Type' => 'application/json'));
        
        return $response;
    }
    
    /**
     * Receive feedback from the library webstie
     */
    public function postFeedbackAction(Request $request){
        $entity = new Feedback();
        
        $requestData = $request->request->all();
        $patronGroupId = $requestData['patronGroup'];
         
        $form = $this->get('form.factory')->createNamed('', new FeedbackType(), $entity);
        $form->add('body', null, array(
                'label' => 'Your feedback'
              ));
        $form->add('patronEmail');
        $form->add('patronFirstName', null, array(
          'required' => false
        ));
        $form->add('patronLastName', null, array(
          'required' => false
        ));
        $form->add('patronPhone', null, array(
          'required' => false
        ));
        $form->handleRequest($request);
        
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            $serializer = $this->get('serializer');
            $serialized = $serializer->serialize($entity, 'json');

            $message = \Swift_Message::newInstance()
                ->setSubject('EMU Library Feedback Received')
                ->setFrom('feedback@emulibrary.com')
                ->setTo($entity->getPatronEmail())
                ->setBody(
                    $this->renderView(
                        'AppBundle:Feedback/Emails:feedback.html.twig',
                        array('form' => $request->request->all())
                    ),
                    'text/html'
                )
            ;
            $this->get('mailer')->send($message);
          
            return new JsonResponse(array(
                $serialized
            ), 201);
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

