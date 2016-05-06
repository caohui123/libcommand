<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\FOSRestController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use AppBundle\Entity\Instruction;

/**
 * Instruction REST controller.
 */
class InstructionRestController extends FOSRestController
{

    /**
     * Filter Instruction entites by criteria.
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
                ->setTemplate("AppBundle:Instruction:results.html.twig")
                ->setTemplateData($templateData)
                ->setFormat('html')
                ;
        
        return $this->handleView($view);
    }
}
