<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use AppBundle\Entity\Instruction;
use Doctrine\ORM\EntityRepository;
use AppBundle\Form\InstructionSearchType;
use AppBundle\Entity\GroupInstruction;

/**
 * Instruction controller.
 *
 * @Route("/instruction")
 */
class InstructionController extends Controller
{

    /**
     * Lists all Instruction entities.
     *
     * @Route("/", name="instruction")
     * @Method("GET")
     * @Template()
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        
        $currentUser = $this->get('security.token_storage')->getToken()->getUser();
        
        if(null === $currentUser->getStaffMember()){
            throw new NoAssociatedStaffException();
        }
        
        // GROUP instructions for logged in user
        $entities = $em->getRepository('AppBundle:Instruction')->findBy(array('createdBy' => $currentUser), array('instructionDate' => 'DESC'));

        $requestData = $request->query->all();
        isset($requestData['maxItems']) ? $maxItems = $requestData['maxItems'] : $maxItems = 10;
      
        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $entities, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            $maxItems/*limit per page*/
        );

        return array(
            'pagination' => $pagination,
            'filter' => 'filter-all', //varable for ajax pagination purposes in the view
            'paginationPath' => 'instruction',
        );
    }
    
    /**
     * Form to search all, individual or group records.
     * 
     * @Route("/instructionsearch/form", name="instruction_form")
     * @Method("GET")
     * @Template("AppBundle:Instruction:snippets/searchform.html.twig")
     */
    public function searchInstructionAction(){
        $searchForm = $this->createSearchInstructionForm();
                
        return array(
          'search_form' => $searchForm->createView(),
          'requestData' => null,
        );
    }
    protected function createSearchInstructionForm(){
        $form = $this->createForm(new InstructionSearchType(), null, array(
            'action' => $this->generateUrl('instruction_results'),
            'method' => 'GET',
        ));
        $form->add('submit', 'submit', array(
            'label' => 'Search',
            'attr' => array(
                'class' => 'btn btn-sm btn-info',
                )
            ));
        
        return $form;
    }
    
    /**
     * Show search results.
     * 
     * @Route("/instructionsearch/results", name="instruction_results")
     * @Method("GET")
     * @Template("AppBundle:Instruction:results-search.html.twig")
     */
    public function showSearchResultsAction(Request $request){
        $requestData = $request->query->all();
        
        isset($requestData['maxItems']) ? $maxItems = $requestData['maxItems'] : $maxItems = 10;
        $em = $this->getDoctrine()->getManager();
        
        $searchForm = $this->createSearchInstructionForm();
        $searchForm->handleRequest($request);
        
        if($searchForm->isValid()){
            
            $matchingEntities = $this->getInstructionsByCriteria($searchForm->getData());
            
            $paginator  = $this->get('knp_paginator');
            $pagination = $paginator->paginate(
                $matchingEntities, /* query NOT result */
                $request->query->getInt('page', 1)/*page number*/,
                $maxItems/*limit per page*/
            );

            return array(
                'pagination' => $pagination,
                'requestData' => $searchForm->getData(),
            );
        }
        
        //form was not valid, send the user a flash message and redirect to the instruction homepage
        $this->addFlash(
            'flash-danger',
            'Search was invalid. Please try again.'
        );
        return $this->redirectToRoute("instruction");
    }
    
    /**
     * Return a list of Instruction entites based on the criteria from the search form
     * 
     * @var array $criteria  Form data with criteria.
     * @return array
     */
    protected function getInstructionsByCriteria($criteria){
        $em = $this->getDoctrine()->getManager();
        
        $options = array();
        
        $em = $this->getDoctrine()->getEntityManager();

        $query = "SELECT i FROM AppBundle:Instruction i WHERE i.id IS NOT NULL ";
        
       if($criteria['librarian'] instanceof \AppBundle\Entity\Staff && $criteria['librarian'] != null){
            $options['librarian'] = $criteria['librarian'];
            $query .= "AND i.librarian = :librarian ";
        }
        if($criteria['program'] instanceof \AppBundle\Entity\LiaisonSubject && $criteria['program'] != null){
            $options['program'] = $criteria['program'];
            $query .= "AND i.program = :program ";
        }
        
        if( ($criteria['startDate'] instanceof \DateTime && $criteria['startDate'] != null) && ($criteria['endDate'] instanceof \DateTime && $criteria['endDate'] != null) ){
            //start and end date set
            $options['instructionStartDate'] = $criteria['startDate'];
            $options['instructionEndDate'] = $criteria['endDate'];
            $query .= "AND i.instructionDate >= :instructionStartDate AND i.instructionDate <= :instructionEndDate ";
        } else if ( ($criteria['startDate'] instanceof \DateTime && $criteria['startDate'] != null) && ( !($criteria['endDate'] instanceof \DateTime) || $criteria['endDate'] == null) ){
            // start date set but NOT end date
            $options['instructionStartDate'] = $criteria['startDate'];
            $query .= "AND i.instructionDate >= :instructionStartDate ";
        } else if ( ( !($criteria['startDate'] instanceof \DateTime) || $criteria['startDate'] == null) && ( $criteria['endDate'] instanceof \DateTime && $criteria['endDate'] != null) ) {
            // end date set but NOT start date
            $options['instructionEndDate'] = $criteria['endDate'];
            $query .= "AND i.instructionDate <= :instructionEndDate ";
        }
        
        $query .= " ORDER BY i.instructionDate DESC";
        
        $qb = $em->createQuery($query)->setParameters($options);
        
        return $qb->getResult();
    }

    /**
     * Finds and displays a Instruction entity.
     *
     * @Route("/{id}", name="instruction_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Instruction')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Instruction entity.');
        }

        return array(
            'entity'      => $entity,
        );
    }
}
