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

        //Instruction preliminary search form 
        $searchForm = $this->createPreliminarySearchInstructionForm();
        
        return array(
            'pagination' => $pagination,
            'filter' => 'filter-all', //varable for ajax pagination purposes in the view
            'paginationPath' => 'instruction',
            'search_form' => $searchForm->createView(),
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
            
            $matchingEntities = $this->getInstructionsByCriteria($searchForm->getData());
            
            $paginator  = $this->get('knp_paginator');
            $pagination = $paginator->paginate(
                $matchingEntities, /* query NOT result */
                $request->query->getInt('page', 1)/*page number*/,
                $maxItems/*limit per page*/
            );

            //Instruction preliminary search form 
            $searchForm = $this->createPreliminarySearchInstructionForm();
            
            return array(
                'pagination' => $pagination,
                'requestData' => $searchForm->getData(),
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
     * Return a list of Instruction entites based on the criteria from the search form
     * 
     * @var array $criteria  Form data with criteria.
     * @return array
     */
    protected function getInstructionsByCriteria($criteria){
        $options = array();
        
        $em = $this->getDoctrine()->getEntityManager();

        $query = "SELECT i FROM ";
        
        // ALL/GROUP/INDIVIDUAL INSTRUCTION FILTER
        if(isset($criteria['instructionType'])){
            switch($criteria['instructionType']){
                case 'group':
                    $query .= "AppBundle:GroupInstruction i ";
                    break;
                case 'individual':
                    $query .= "AppBundle:IndividualInstruction i ";
                    break;
                default:
                    $query .= "AppBundle:Instruction i ";
                    break;
            }
        } else {
            $query .= "AppBundle:Instruction i ";
        }
        
        $query .= "WHERE i.id IS NOT NULL ";
        
        //LIBRARIAN
        if(isset($criteria['librarian'])){
            if($criteria['librarian'] instanceof \AppBundle\Entity\Staff && $criteria['librarian'] != null){
                $options['librarian'] = $criteria['librarian'];
                $query .= "AND i.librarian = :librarian ";
            }
        }
        
        //PROGRAM
        if(isset($criteria['program'])){
            if($criteria['program'] instanceof \AppBundle\Entity\LiaisonSubject && $criteria['program'] != null){
                $options['program'] = $criteria['program'];
                $query .= "AND i.program = :program ";
            }
        }
        
        //FISCAL YEAR
        if(isset($criteria['fiscalYear'])){
            if($criteria['fiscalYear'] != null){
                $options['firstYear'] = new \DateTime($criteria['fiscalYear'] . '-07-01');
                $options['secondYear'] = new \DateTime($criteria['fiscalYear'] + 1 . '-06-30');
                $query .= "AND i.instructionDate >= :firstYear AND i.instructionDate <= :secondYear ";
            }
        }
        
        //ACADEMIC YEAR
        if(isset($criteria['academicYear'])){
            if($criteria['academicYear'] != null){
                $options['firstYear'] = new \DateTime($criteria['academicYear'] . '-09-01');
                $options['secondYear'] = new \DateTime($criteria['academicYear'] + 1 . '-08-31');
                $query .= "AND i.instructionDate >= :firstYear AND i.instructionDate <= :secondYear ";
            }
        }
        
        //ACADEMIC YEAR
        if(isset($criteria['calendarYear'])){
            if($criteria['calendarYear'] != null){
                $options['startOfYear'] = new \DateTime($criteria['calendarYear'] . '-01-01');
                $options['endOfYear'] = new \DateTime($criteria['calendarYear'] . '-12-31');
                $query .= "AND i.instructionDate >= :startOfYear AND i.instructionDate <= :endOfYear ";
            }
        }
        
        //ACADEMIC YEAR
        if(isset($criteria['semester'])){
            if($criteria['semester'] != null){
                switch($criteria['semester']){
                    case 'winter':
                        $options['startOfSemester'] = new \DateTime($criteria['year'] . '-01-01');
                        $options['endOfSemester'] = new \DateTime($criteria['year'] . '-04-30');
                        $query .= "AND i.instructionDate >= :startOfSemester AND i.instructionDate <= :endOfSemester ";
                        break;
                    case 'spring':
                        $options['startOfSemester'] = new \DateTime($criteria['year'] . '-05-01');
                        $options['endOfSemester'] = new \DateTime($criteria['year'] . '-06-30');
                        $query .= "AND i.instructionDate >= :startOfSemester AND i.instructionDate <= :endOfSemester ";
                        break;
                    case 'summer':
                        $options['startOfSemester'] = new \DateTime($criteria['year'] . '-07-01');
                        $options['endOfSemester'] = new \DateTime($criteria['year'] . '-08-31');
                        $query .= "AND i.instructionDate >= :startOfSemester AND i.instructionDate <= :endOfSemester ";
                        break;
                    case 'fall':
                        $options['startOfSemester'] = new \DateTime($criteria['year'] . '-09-01');
                        $options['endOfSemester'] = new \DateTime($criteria['year'] . '-12-31');
                        $query .= "AND i.instructionDate >= :startOfSemester AND i.instructionDate <= :endOfSemester ";
                        break;
                }
            }
        }
        
        //CUSTOM START AND END DATE
        if( isset($criteria['startDate']) && isset($criteria['endDate']) ){
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
