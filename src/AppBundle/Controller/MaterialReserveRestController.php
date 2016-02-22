<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use AppBundle\Entity\MaterialReserve;
use AppBundle\Form\MaterialReserveType;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\JsonResponse;

class MaterialReserveRestController extends FOSRestController
{
    /**
     * Get all MaterialReserveMedia entities
     * @return Response
     */
    public function getMaterialreserveMediaAction(){
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('AppBundle:MaterialReserveMedia')->findBy(array(), array('name'=>'ASC'));
        $serializer = $this->container->get('serializer');
        $serialized = $serializer->serialize($entities, 'json');
        $response = new Response($serialized, 200, array('Content-Type' => 'application/json'));
        
        return $response;
    }
    
    public function postMaterialreserveAction(Request $request){
      
      $entity = new MaterialReserve();
        
      $formData = $request->request->all();
      
        /* Forms on client side must follow naming format of 'materialreserve[formfieldname]' */
        $form = $this->get('form.factory')->createNamed('materialreserve', new MaterialReserveType(), $entity);
        $form->handleRequest($request);
        
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            $serializer = $this->get('serializer');
            $serialized = $serializer->serialize($entity, 'json');
          
            $message = \Swift_Message::newInstance()
                ->setSubject('Your Material Reserve Submission at EMU Library')
                ->setFrom('facultymaterialreserve@emulibrary.com')
                ->setTo('cpuzzuol@emich.edu')
                ->setBody(
                    $this->renderView(
                        'AppBundle:MaterialReserve/Emails:materialreserve.html.twig',
                        array(
                          'form' => $formData['materialreserve'],
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
