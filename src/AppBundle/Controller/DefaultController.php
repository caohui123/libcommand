<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', array(
            'base_dir' => realpath($this->container->getParameter('kernel.root_dir').'/..'),
        ));
    }
    
    /**
     * //@Route("/testemail", name="testemail")
     */
    public function testEmailAction(){
        
        return $this->render('default/testemail.html.twig', array(
            'base_dir' => realpath($this->container->getParameter('kernel.root_dir').'/..'),
            'emailForm' => $this->createTestForm()->createView()
        ));
    }
    
    /**
     * //@Route("/testemailtest", name="testemail_test")
     * //@Method("POST")
     */
    public function sendEmailAction(Request $request){
      $requestData = $request->request->all();
      
        $form = $this->createTestForm();
        $form->handleRequest($request);
        if ($form->isValid()) {
          
            $message = \Swift_Message::newInstance()
                  ->setSubject('TEST EMAIL FROM SYMFONY')
                  ->setFrom('feedback@emulibrary.com')
                  ->setTo($requestData['editForm']['email'])
                  ->setBody(
                        "It works!"
                      );
              $this->get('mailer')->send($message);

            return $this->render('default/testemail.html.twig', array(
              'base_dir' => realpath($this->container->getParameter('kernel.root_dir').'/..'),
              'emailForm' => $this->createTestForm()->createView(),
              'message' => $requestData['editForm']['email']
            ));
        }
      
      
      return $this->render('default/testemail.html.twig', array(
          'base_dir' => realpath($this->container->getParameter('kernel.root_dir').'/..'),
          'emailForm' => $this->createTestForm()->createView(),
          'message' => 'FORM NOT VALID'
      ));
    }
    
    public function createTestForm(){
      $emailForm = $this->get('form.factory')->createNamedBuilder('editForm', 'form')
            ->setMethod('POST')
            ->setAction($this->generateUrl('testemail_test'))
            ->add('email', 'email', ['label'=>'Your Email Address'])
            ->add('submit', 'submit', ['label' => 'Send Email to this address'])
            ->getForm();
      
      return $emailForm;
    }
}
