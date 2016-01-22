<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use AppBundle\Entity\Staff;
use AppBundle\Form\StaffType;
use JMS\SecurityExtraBundle\Annotation\Secure;

/**
 * Recurring date controller.
 *
 * @Route("/recurr")
 */
class RecurrController extends Controller
{

    /**
     *
     * @Route("/", name="recurr")
     * @Method("GET")
     * @Template()
     * 
     * //@Secure(roles="ROLE_STAFF_VIEW")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        
        $form = $this->createCreateForm();

        return array(
            'form' => $form->createView(),
        );
    }  
    
    /**
     * Create recurring date
     * 
     * @Route("/", name="recurr_create")
     * @Method("POST")
     * @Template("AppBundle:Recurr:new.html.twig")
     */
    public function createAction(Request $request){
        $requestData = $request->request->all();
        $startDate = $requestData['form']['startDate'];
        $endDate = $requestData['form']['endDate'];
        $frequency = $requestData['form']['frequency'];
        
        $startDateFormatted = new \DateTime('2012-12-22 11:11:11');
        $endDateFormatted = new \DateTime('2012-12-22 11:11:11');
        $rule = new \Recurr\Rule('FREQ=MONTHLY;COUNT=5', $startDate, $endDate);
        $transformer = new \Recurr\Transformer\ArrayTransformer();
        
        //$form = $this->createCreateForm();
        //$form->handleRequest($request);
        
        var_dump($rule);
        return new \Symfony\Component\HttpFoundation\JsonResponse($rule, 201);

    }
    
    public function createCreateForm(){
        $data = array();
        
        $form = $this->createFormBuilder($data)
                ->setAction($this->generateUrl('recurr_create'))
                ->setMethod('POST')
                ->add('startDate', 'date', array(
                    'widget' => 'single_text',
                    'format' => 'yyyy-MM-dd'
                ))
                ->add('endDate', 'date', array(
                    'widget' => 'single_text',
                    'format' => 'yyyy-MM-dd'
                ))
                ->add('frequency', 'choice', array(
                    'choices' => array(
                        'daily' => 'Daily',
                        'weekly' => 'Weekly',
                        'monthly' => 'Monthly',
                        'yearly' => 'Yearly'
                    )
                ))
                ->add('save', 'submit', array('label' => 'Create Date'))
                ->getForm();
        
        return $form;
    }
}
