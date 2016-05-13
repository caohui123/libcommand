<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\FOSRestController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use AppBundle\Entity\Instruction;
use Ddeboer\DataImport\Writer\CsvWriter;
use Ddeboer\DataImport\Reader\DbalReader;

/**
 * Instruction REST controller.
 */
class InstructionRestController extends FOSRestController
{

    /**
     * Filter Instruction entites by criteria (REST method... non-REST located in AppBundle:Instruction:createSearchInstructionFormAction).
     */
    public function getFilterinstructionsAction(Request $request)
    {
        $requestData = $request->query->all();
        
        $filter = $requestData['filter'];
        isset($requestData['maxItems']) ? $maxItems = $requestData['maxItems'] : $maxItems = 10;
        
        $em = $this->getDoctrine()->getManager();
        
        $currentUser = $this->get('security.token_storage')->getToken()->getUser();
        
        if(null === $currentUser->getStaffMember()){
            throw new NoAssociatedStaffException();
        }
        
        switch($filter){
            case 'filter-group':
                $entities = $em->getRepository('AppBundle:GroupInstruction')->findBy(array('createdBy' => $currentUser), array('instructionDate' => 'DESC'));
                break;
            case 'filter-individual':
                $entities = $em->getRepository('AppBundle:IndividualInstruction')->findBy(array('createdBy' => $currentUser), array('instructionDate' => 'DESC'));
                break;
            default:
                $entities = $em->getRepository('AppBundle:Instruction')->findBy(array('createdBy' => $currentUser), array('instructionDate' => 'DESC'));
                break;
        }
           
        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $entities, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            $maxItems/*limit per page*/
        );
        
        $templateData = array('pagination' => $pagination, 'filter' => $filter, 'paginationPath' => 'instruction');
        
        $view = $this->view($entities, 200)
                ->setTemplate("AppBundle:Instruction:results-ajax.html.twig")
                ->setTemplateData($templateData)
                ->setFormat('html')
                ;
        
        return $this->handleView($view);
    }
    
    /**
     * Take preliminary instruction filter criteria (all/individual/group, date range)
     * and get the appropriate InstructionSearchType form. Pass that form to a template for layout.
     */
    public function getInstructionsearchformAction(Request $request){
        $requestData = $request->query->all();
        
        $instructionService = $this->get('instruction_controller');
        
        $searchForm = $instructionService->createSearchInstructionForm($requestData['form']['instructionType'], $requestData['form']['dateRange']);
        
        $templateData = array('search_form' => $searchForm->createView());
        
        $view = $this->view(array(), 200)
                ->setTemplate("AppBundle:Instruction:snippets/searchform.html.twig")
                ->setTemplateData($templateData)
                ->setFormat('html')
                ;
        
        return $this->handleView($view);
    }
    
    public function getInstructionpreliminaryformAction(){
        
        $instructionService = $this->get('instruction_controller');
        
        $searchForm = $instructionService->createPreliminarySearchInstructionForm();
        
        $templateData = array('search_form' => $searchForm->createView());
        
        $view = $this->view(array(), 200)
                ->setTemplate("AppBundle:Instruction:snippets/searchform.html.twig")
                ->setTemplateData($templateData)
                ->setFormat('html')
                ;
        
        return $this->handleView($view);
    }
}
