<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use AppBundle\Entity\GroupInstruction;
use AppBundle\Form\GroupInstructionType;
use AppBundle\Exception\NoAssociatedStaffException;

/**
 * GroupInstruction controller.
 *
 * @Route("/groupinstruction")
 */
class GroupInstructionController extends Controller
{

    /**
     * Lists all GroupInstruction entities.
     *
     * @Route("/", name="groupinstruction")
     * @Method("GET")
     * @Template()
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        
        $currentUser = $this->get('security.token_storage')->getToken()->getUser();

        $entities = $em->getRepository('AppBundle:GroupInstruction')->findBy(array('createdBy' => $currentUser), array('instructionDate' => 'DESC'));

        $requestData = $request->query->all();
        isset($requestData['maxItems']) ? $maxItems = $requestData['maxItems'] : $maxItems = 10;
      
        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $entities, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            $maxItems/*limit per page*/
        );

        return array(
            'pagination' => $pagination
        );
    }
    /**
     * Creates a new GroupInstruction entity.
     *
     * @Route("/", name="groupinstruction_create")
     * @Method("POST")
     * @Template("AppBundle:GroupInstruction:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new GroupInstruction();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('groupinstruction_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a GroupInstruction entity.
     *
     * @param GroupInstruction $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(GroupInstruction $entity)
    {
        $currentUser = $this->get('security.token_storage')->getToken()->getUser();
        
        if(null === $currentUser->getStaffMember()){
            throw new NoAssociatedStaffException();
        }
        
        $form = $this->createForm(new GroupInstructionType($this->getDoctrine()->getManager(), $currentUser->getStaffMember()), $entity, array(
            'action' => $this->generateUrl('groupinstruction_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new GroupInstruction entity.
     *
     * @Route("/new", name="groupinstruction_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new GroupInstruction();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a GroupInstruction entity.
     *
     * @Route("/{id}", name="groupinstruction_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:GroupInstruction')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find GroupInstruction entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing GroupInstruction entity.
     *
     * @Route("/{id}/edit", name="groupinstruction_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:GroupInstruction')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find GroupInstruction entity.');
        }
        
        $this->denyAccessUnlessGranted('edit', $entity, 'Unauthorized Access!');

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
    * Creates a form to edit a GroupInstruction entity.
    *
    * @param GroupInstruction $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(GroupInstruction $entity)
    {
        $currentUser = $this->get('security.token_storage')->getToken()->getUser();
        
        if(null === $currentUser->getStaffMember()){
            throw new NoAssociatedStaffException();
        }
        
        $form = $this->createForm(new GroupInstructionType($this->getDoctrine()->getManager(), $currentUser->getStaffMember()), $entity, array(
            'action' => $this->generateUrl('groupinstruction_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update', 'attr' => array('class' => 'btn btn-sm btn-success')));

        return $form;
    }
    /**
     * Edits an existing GroupInstruction entity.
     *
     * @Route("/{id}", name="groupinstruction_update")
     * @Method("PUT")
     * @Template("AppBundle:GroupInstruction:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:GroupInstruction')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find GroupInstruction entity.');
        }
        
        $this->denyAccessUnlessGranted('edit', $entity, 'Unauthorized Access!');

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('groupinstruction_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a GroupInstruction entity.
     *
     * @Route("/{id}", name="groupinstruction_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AppBundle:GroupInstruction')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find GroupInstruction entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('groupinstruction'));
    }

    /**
     * Creates a form to delete a GroupInstruction entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('groupinstruction_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array(
                'label' => 'Delete',
                'attr' => array(
                    'class' => 'btn btn-sm btn-danger',
                    'onclick' => 'return confirm("Are you sure you want to delete this session?")'
                    )
                ))
            ->getForm()
        ;
    }
    
    /**
     * Displays a printer-friendly GroupInstruction entity.
     *
     * @Route("/{id}/print", name="groupinstruction_print")
     * @Method("GET")
     * @Template()
     */
    public function printAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:GroupInstruction')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find GroupInstruction entity.');
        }
        
        $this->denyAccessUnlessGranted('edit', $entity, 'Unauthorized Access!');

        return array(
            'entity'      => $entity,
        );
    }
    
    /**
     * Create a form that specifies criteria for fiscal or academic year group instruction report generation.
     * 
     * @return \Symfony\Component\Form\Form The form
     */
    public function createYearlyReportGeneratorForm(){
        $instruction_service = $this->get('instruction_service');
        
        //NOTE: specifiy action (route) and method (GET) in twig template wherever this form is called
        $form = $this->createFormBuilder()
                ->add('yearType', 'choice', array(
                    'label' => 'Type',
                    'choices' => array(
                        'academic' => 'Academic (Sept-Aug)',
                        'fiscal' => 'Fiscal (Jul-Jun)',
                    ),
                    'multiple' => false,
                    'expanded' => true,
                    'data' => 'academic', //pre-select academic
                 ))
                ->add('year', 'choice', array(
                    'label' => 'Year',
                    'choices' => $instruction_service->generateYears(),
                ))
                ->add('submit', 'submit', array(
                    'label' => 'View Report',
                    'attr' => array(
                        'class' => 'btn btn-sm btn-warning',
                    ),
                ))
                ->getForm();
        
        return $form;
    }
    
    /**
     * Generates group instruction reports based on year.
     * This report includes totals by month and instruction level as well as 
     * instruction counts by staff member over that time period.
     *
     * @Route("/reports/yearly", name="generate_yearly_group_instruction")
     * @Method("POST")
     * @Template("AppBundle:GroupInstruction:yearly.html.twig")
     */
    public function generateYearlyReportAction(Request $request){
        $requestData = $request->request->all();
        $yearType = $requestData['form']['yearType'];
        $year = (int) $requestData['form']['year'];

        return array(
            'entities' => $this->__getYearlySessionAndAttendanceCounts($yearType, $year),
            'yearly_form' => $this->createYearlyReportGeneratorForm()->createView(),
            'year_type' => $yearType,
            'year' => $year,
        );
    }
    
    /**
     * Generates GROUP instruction reports based on year.
     * This report includes totals by month and instruction level as well as 
     * instruction counts by staff member over that time period.
     *
     * @Route("/reports/yearly/csv", name="groupinstruction_yearly_csv")
     * @Method("GET")
     * @Template()
     */
    public function downloadYearlyReportCsvAction(Request $request){
        $requestData = $request->query->all();
        $yearType = $requestData['yearType'];
        $year = (int) $requestData['year'];
        
        $totals = $this->__getYearlySessionAndAttendanceCounts($yearType, $year);
        
        $filename = "instruction_totals_".date("Y_m_d_His").".csv"; 

        $response = $this->render('AppBundle:GroupInstruction:yearly-csv.html.twig', array(
                'totals' => $totals, 
                'year_type' => $yearType,
                'year' => $year,
            )); 

        $response->setStatusCode(200);
        $response->headers->set('Content-Type', 'text/csv');
        $response->headers->set('Content-Description', 'Group Instruction Yearly Totals Export');
        $response->headers->set('Content-Disposition', 'attachment; filename='.$filename);
        $response->headers->set('Content-Transfer-Encoding', 'binary');
        $response->headers->set('Pragma', 'no-cache');
        $response->headers->set('Expires', '0');

        return $response; 
    }
    
    /**
     * Displays a printer-friendly yearly report of GroupInstruction sessions.
     *
     * @Route("/reports/yearly/print", name="groupinstruction_yearly_print")
     * @Method("GET")
     * @Template("AppBundle:GroupInstruction:yearly-print.html.twig")
     */
    public function printYearlyAction(Request $request)
    {
        $requestData = $request->query->all();
        $yearType = $requestData['yearType'];
        $year = (int) $requestData['year'];
        
        $totals = $this->__getYearlySessionAndAttendanceCounts($yearType, $year);
        
        return array(
            'entities' => $totals, 
            'year_type' => $yearType,
            'year' => $year,
        );
    }
    
    /**
     * Returns sessions and attendance totals by month and instruction level over an academic or fiscal year.
     *
     * @param String $yearType  'academic' or 'fiscal' year
     * @param int $year  The first year for which to fetch data
     * 
     * @return array  An array holding session and attendance totals by level for the year
     */
    private function __getYearlySessionAndAttendanceCounts($yearType, $year){
        $totals_arr = array();
        
        $instruction_service = $this->get('instruction_service');
        
        switch($yearType){
            case 'academic':
                $startDate = new \DateTime($year . "-09-01");
                $endDate = new \DateTime(($year + 1) . "-08-31");
                break;
            case 'fiscal':
                $startDate = new \DateTime($year . "-07-01");
                $endDate = new \DateTime(($year + 1) . "-06-30");
                break;
        }
        
        //Get instruction count and attendance by level for the first month plus the next 11 months
        for($i = 0; $i < 12; $i++){
            $month_iterator = new \DateInterval('P'.$i.'M'); //means add $i months to the date
            
            $date = clone $startDate;
            $date->add($month_iterator);
            
            $loop_month = clone $date;

            //Current list of levels (e.g. '100-200') located in AppBundle\Form\GroupTypeInstructionType.php in the 'level' field
            $totals_arr[$loop_month->format('F')]['100-200']['sessions'] = $instruction_service->getGroupInstructionsByMonth($date, '100-200');
            $totals_arr[$loop_month->format('F')]['100-200']['attendance'] = $instruction_service->getGroupInstructionAttendanceByMonth($date, '100-200');
            $totals_arr[$loop_month->format('F')]['300-400']['sessions'] = $instruction_service->getGroupInstructionsByMonth($date, '300-400');
            $totals_arr[$loop_month->format('F')]['300-400']['attendance'] = $instruction_service->getGroupInstructionAttendanceByMonth($date, '300-400');
            $totals_arr[$loop_month->format('F')]['Graduate']['sessions'] = $instruction_service->getGroupInstructionsByMonth($date, 'grad');
            $totals_arr[$loop_month->format('F')]['Graduate']['attendance'] = $instruction_service->getGroupInstructionAttendanceByMonth($date, 'grad');
            $totals_arr[$loop_month->format('F')]['High School']['sessions'] = $instruction_service->getGroupInstructionsByMonth($date, 'high school');
            $totals_arr[$loop_month->format('F')]['High School']['attendance'] = $instruction_service->getGroupInstructionAttendanceByMonth($date, 'high school');
            $totals_arr[$loop_month->format('F')]['Other']['sessions'] = $instruction_service->getGroupInstructionsByMonth($date, 'other');
            $totals_arr[$loop_month->format('F')]['Other']['attendance'] = $instruction_service->getGroupInstructionAttendanceByMonth($date, 'other');
        }
        
        return $totals_arr;
    }
}
