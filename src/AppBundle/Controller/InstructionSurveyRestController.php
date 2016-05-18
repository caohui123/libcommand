<?php
/**
 * Delivers content to and receives from the external instruction survey form located in:
 * /home/apache2/htdocs/survey/instruction/index.php (as of 5/18/16)
 */
namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\FOSRestController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use AppBundle\Entity\Instruction;
use AppBundle\Entity\InstructionSurvey;
use AppBundle\Form\InstructionSurveyType;

/**
 * Instruction REST controller.
 */
class InstructionSurveyRestController extends FOSRestController
{

    /**
     * Get instruction session data based on the id.
     */
    public function getInstructionsurveySessiondataAction(Request $request)
    {
        $requestData = $request->query->all();
        
        $sessionId = $requestData['id'];
        
        $em = $this->getDoctrine()->getManager();
        
        $session = $em->getRepository('AppBundle:Instruction')->find($sessionId);
        
        if(!$session){
            throw $this->createNotFoundException('Unable to find Instruction entity.');
        }
                
        $serializer = $this->container->get('serializer');
        $serialized = $serializer->serialize($session, 'json');
        $response = new Response($serialized, 200, array('Content-Type' => 'application/json'));
        
        return $response;
    }
    
    /**
     * Create a new instruction survey based on the user input from the external form.
     */
    public function postInstructionsurveyAction(Request $request){
        $entity = new InstructionSurvey();
        
        $formData = $request->request->all();
        
        //var_dump($formData);
        
        /* Forms on client side must follow naming format of 'avrequest[formfieldname]' */
        $form = $this->get('form.factory')->createNamed('instructionsurvey', new InstructionSurveyType(), $entity);
        $form->handleRequest($request);
        
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            
            $em->persist($entity);
            $em->flush();

            $serializer = $this->get('serializer');
            $serialized = $serializer->serialize($entity, 'json');
            
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
