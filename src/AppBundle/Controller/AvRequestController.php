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
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\HttpFoundation\JsonResponse;


class AvRequestController extends Controller
{
    /**
     * @Rest\View()
     */
    public function getAvrequestsAction(Request $request){
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('AppBundle:AvRequest')->findAll();
        
        $serializer = $this->container->get('serializer');
        $serialized = $serializer->serialize($entities, 'json');
        $response = new Response($serialized, 200, array('Content-Type' => 'application/json'));
        
        return $response;
    }
    public function getAvrequestAction($id){
        
    }
    public function postAvrequestAction(Request $request){
        $entity = new AvRequest();

        $form = $this->get('form.factory')->createNamed('', new AvRequestType(), $entity);
        $form->handleRequest($request);
        
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            $serializer = $this->get('serializer');
            $serialized = $serializer->serialize($entity, 'json');
            return new Response($serialized, 201);
        }

        return new JsonResponse(array(
            'errors' => $this->getFormErrors($form)
        ));
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
