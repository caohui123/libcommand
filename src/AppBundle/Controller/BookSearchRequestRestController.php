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
use AppBundle\Entity\BookSearchRequest;
use AppBundle\Form\BookSearchRequestType;
use Symfony\Component\HttpFoundation\JsonResponse;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Response;


class BookSearchRequestRestController extends FOSRestController{

    /**
     * Receive book search request from the library webstie
     */
    public function postBooksearchrequestAction(Request $request){
        $entity = new BookSearchRequest();
        
        $requestData = $request->request->all();
         
        $form = $this->get('form.factory')->createNamed('', new BookSearchRequestType(), $entity);
        $form->add('usefulDate', 'datetime', array(
            'widget' => 'single_text',
            'format' => 'yyyy-MM-dd HH:mm:ss',
        ));
        $form->add('patronFirstName');
        $form->add('patronLastName');
        $form->add('patronPhone');
        $form->add('patronENumber');
        $form->add('patronEmail' , 'email');
        $form->handleRequest($request);
        
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            $serializer = $this->get('serializer');
            $serialized = $serializer->serialize($entity, 'json');

            $message = \Swift_Message::newInstance()
                ->setSubject('EMU Library Book Request Received')
                ->setFrom('bookrequest@emulibrary.com')
                ->setTo($entity->getPatronEmail())
                ->setBody(
                    $this->renderView(
                        'AppBundle:BookSearchRequest/Emails:booksearchrequest.html.twig',
                        array('form' => $request->request->all())
                    ),
                    'text/html'
                )
            ;
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

