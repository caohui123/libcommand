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
use AppBundle\Entity\FindText;
use AppBundle\Form\FindTextType;


class FindTextRestController extends FOSRestController{
    
    /**
     * Receive FindText+ problem from the library webstie
     */
    public function postFindtextAction(Request $request){
        $entity = new FindText();
        
        $form = $this->get('form.factory')->createNamed('', new FindTextType(), $entity);
        $form->handleRequest($request);
        
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            $serializer = $this->get('serializer');
            $serialized = $serializer->serialize($entity, 'json');

            $message = \Swift_Message::newInstance();
            $header_image = $message->embed(\Swift_Image::fromPath($this->container->get('kernel')->locateResource('@AppBundle/Resources/public/images/email_banner_640x75.jpg')));
            $message
                ->setSubject('EMU Library FindText+ Problem Received')
                ->setFrom('findtext@emulibrary.com')
                ->setTo($entity->getPatronEmail())
                ->setBody(
                    $this->renderView(
                        'AppBundle:FindText/Emails:findtext.html.twig',
                        array(
                            'entity' => $entity,
                            'header_image' => $header_image
                        )
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

