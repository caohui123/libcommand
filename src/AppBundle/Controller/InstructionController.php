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
use Ddeboer\DataImport\Writer\CsvWriter;
use Ddeboer\DataImport\Reader\DbalReader;
use Ddeboer\DataImport\Workflow;
use Symfony\Component\HttpFoundation\StreamedResponse;

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
        $entities = $em->getRepository('AppBundle:Instruction')->findBy(array('librarian' => $currentStaffMember), array('instructionDate' => 'DESC'));

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
        
        //Yearly report generation form (action specified in twig file)
        $groupinstruction_service = $this->get('groupinstruction_controller');
        $yearlyReportForm = $groupinstruction_service->createYearlyReportGeneratorForm();
        
        //Use the Instruction Service to get user instruction statistic counts
        $instructionService = $this->get('instruction_service');
        $individual_statistics = $instructionService->generateStaffRecentInstructionStatistics($currentStaffMember);
        $group_statistics = $instructionService->generateStaffRecentInstructionStatistics();
        $most_recent_instruction = $instructionService->getMostRecentInsturction($currentStaffMember);
        
        return array(
            'pagination' => $pagination,
            'filter' => 'filter-all', //varable for ajax pagination purposes in the view
            'paginationPath' => 'instruction',
            'search_form' => $searchForm->createView(),
            'yearly_report_form' => $yearlyReportForm->createView(),
            'individual_statistics' => $individual_statistics,
            'group_statistics' => $group_statistics,
            'most_recent_instruction' => $most_recent_instruction,
        );
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
        // Pass in instruction service to form class as the generateYears() function is needed within the class.
        $form = $this->createForm(new InstructionSearchType($this->get('instruction_service')), null, array(
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
            
            $entity_id_arr = array();
            // Put each entity ID into an array for CSV generation purposes
            foreach($matchingEntities as $ent){
                $entity_id_arr[] = $ent->getId();
            }

            //Instruction preliminary search form 
            $searchForm = $this->createPreliminarySearchInstructionForm();
            
            //Prepare submitted filters for display on results page
            $filters = $instructionService->formatFilters($requestData['instrsearch']);
            
            return array(
                'pagination' => $pagination,
                'filters' => $filters,
                'entity_ids' => $entity_id_arr,
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
     * Downloads CSV of instruction entities based on specific criteria.
     *
     * @Route("/reports/csv", name="instruction_csv")
     * @Method("GET")
     * @Template()
     */
    public function downloadCsvAction(Request $request){
        $em = $this->getDoctrine()->getManager();
        
        $requestData = $request->query->all();
        $entity_ids = $requestData['entities'];
        $filters = $requestData['filters'];
        
        $individual_instruction_arr = array();
        $group_instruction_arr = array();
        
        foreach($entity_ids as $entity_id){
            $entity = $em->getRepository('AppBundle:Instruction')->find($entity_id);
            
            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Instruction entity.');
            }

            // Determine if this is  a group or individual instruction...Individual instructions have a "client" field whereas group instructions don't...so check for that field
            if(property_exists($entity, 'client')){
                //indivudal instruction
                $individual_instruction_arr[] = $entity;
            } else {
                //group instruction
                $group_instruction_arr[] = $entity;
            }
        }
        
        $filename = "instructions_".date("Y_m_d_His").".csv"; 

        $response = $this->render('AppBundle:Instruction:csvfile.html.twig', array(
                'group_instructions' => $group_instruction_arr, 
                'group_headers' => 'Instruction Date, Staff, Start, End, Instructor, Program, Course, Level, Level Description, Attendance,',
                'individual_instructions' => $individual_instruction_arr,
                'individual_headers' => 'Instruction Date, Staff, Start, End, Client, Program, Course, Level, Level Description, Client Interaction,',
                'filters' => $filters,
            )); 

        $response->setStatusCode(200);
        $response->headers->set('Content-Type', 'text/csv');
        $response->headers->set('Content-Description', 'Instruction Session Export');
        $response->headers->set('Content-Disposition', 'attachment; filename='.$filename);
        $response->headers->set('Content-Transfer-Encoding', 'binary');
        $response->headers->set('Pragma', 'no-cache');
        $response->headers->set('Expires', '0');

        return $response; 
    }
}
