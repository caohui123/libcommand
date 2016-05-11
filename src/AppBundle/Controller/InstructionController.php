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
        
        $currentStaffMember = $currentUser->getStaffMember();
        
        // ALL instructions for logged in user
        $entities = $em->getRepository('AppBundle:Instruction')->findBy(array('createdBy' => $currentUser), array('instructionDate' => 'DESC'));

        $requestData = $request->query->all();
        isset($requestData['maxItems']) ? $maxItems = $requestData['maxItems'] : $maxItems = 10;
      
        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $entities, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            $maxItems/*limit per page*/
        );

        //Instruction preliminary search form 
        $searchForm = $this->createPreliminarySearchInstructionForm();
        
        //Use the Instruction Service to get user instruction statistic counts
        $instructionService = $this->get('instruction_service');
        $statistics = $instructionService->generateStaffRecentInstructionStatistics($currentStaffMember);
        
        return array(
            'pagination' => $pagination,
            'filter' => 'filter-all', //varable for ajax pagination purposes in the view
            'paginationPath' => 'instruction',
            'search_form' => $searchForm->createView(),
            'statistics' => $statistics,
        );
    }

    /**
     * A preliminary search form to filter the main instruction search form
     * @return  \Symfony\Component\Form\Form The form
     */
    public function createPreliminarySearchInstructionForm(){
        $form = $this->createFormBuilder(null, array('attr' => array('id' => 'preliminary-instruction-criteria-form'), 'csrf_protection' => false))
            ->setMethod('GET')
            ->add('instructionType', 'choice', array(
                'label' => 'Instruction Types',
                'expanded' => true,
                'multiple' => false,
                'choices' => array(
                    'all' => 'Group and Individual',
                    'group' => 'Group Only',
                    'individual' => 'Individual Only',
                ),
            ))
            ->add('dateRange', 'choice', array(
                'label' => 'Filter By',
                'expanded' => true,
                'multiple' => false,
                'choices' => array(
                    'fiscal' => 'Fiscal Year',
                    'academic' => 'Academic Year',
                    'calendar' => 'Calendar Year',
                    'semester' => 'Semester',
                    'custom' => 'Custom Date Range'
                ),
            ))
            ->add('sumbit', 'submit', array(
                'label' => 'Next Step',
                'attr' => array(
                    'class' => 'btn btn-sm btn-info'
                ),
            ))
            ->getForm();
        
        return $form;
    }
    
    /**
     * Fetch the instruction search form
     * @return  \Symfony\Component\Form\Form The form
     */
    public function createSearchInstructionForm($instruction_type = null, $filter = null){
        $form = $this->createForm(new InstructionSearchType(), null, array(
            'action' => $this->generateUrl('instruction_results'),
            'method' => 'GET',
            'attr' => array('id' => 'instrsearch'),
            'data' => array(
                'instructionType' => $instruction_type,
                'filterCriteria' => $filter
            ),
        ));
        $form->add('submit', 'submit', array(
            'label' => 'Search',
            'attr' => array(
                'class' => 'btn btn-sm btn-info',
                )
            ));
        //use back button with AJAX to go back to the createPreliminarySearchInstructionForm()
        $form->add('back', 'button', array(
            'label' => 'Start Over',
            'attr' => array(
                'class' => 'btn btn-sm btn-default',
            ),
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
        
        $searchForm = $this->createSearchInstructionForm($requestData['instrsearch']['instructionType'], $requestData['instrsearch']['filterCriteria']);
        $searchForm->handleRequest($request);
        
        if($searchForm->isValid()){
            $instructionService = $this->get('instruction_service');
            $matchingEntities = $instructionService->getInstructionsByCriteria($searchForm->getData());
            
            $paginator  = $this->get('knp_paginator');
            $pagination = $paginator->paginate(
                $matchingEntities, /* query NOT result */
                $request->query->getInt('page', 1)/*page number*/,
                $maxItems/*limit per page*/
            );

            //Instruction preliminary search form 
            $searchForm = $this->createPreliminarySearchInstructionForm();
            
            //Prepare submitted filters for display on results page
            $filters = $instructionService->formatFilters($requestData['instrsearch']);
            
            return array(
                'pagination' => $pagination,
                'filters' => $filters,
                'requestData' => $requestData,
                'search_form' => $searchForm->createView(),
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
