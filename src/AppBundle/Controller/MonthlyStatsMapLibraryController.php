<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use AppBundle\Entity\MonthlyStatsMapLibrary;
use AppBundle\Form\MonthlyStatsMapLibraryType;
use JMS\SecurityExtraBundle\Annotation\Secure;
use Symfony\Component\HttpFoundation\Response;

/**
 * MonthlyStatsMapLibrary controller.
 *
 * @Route("/monthly/maplibrary")
 */
class MonthlyStatsMapLibraryController extends Controller
{

    const START_YEAR = 2007;
    
    /**
     * Lists all MonthlyStatsMapLibrary entities.
     *
     * @Route("/", name="monthly_maplibrary")
     * @Method("GET")
     * @Template()
     * 
     * @Secure(roles="ROLE_MONTHLYMAPLIBRARY_VIEW")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        
        $statsService = $this->get('monthlystatistics_service');
        $yearlyTables = $statsService->monthlyTablesByYear('maplibrary', self::START_YEAR);

        return array(
            'yearly_tables' => $yearlyTables,
        );
    }
    /**
     * Creates a new MonthlyStatsMapLibrary entity.
     *
     * @Route("/", name="monthly_maplibrary_create")
     * @Method("POST")
     * @Template("AppBundle:MonthlyStatsMapLibrary:new.html.twig")
     * 
     * @Secure(roles="ROLE_MONTHLYMAPLIBRARY_EDIT")
     */
    public function createAction(Request $request)
    {
        $requestData = $request->request->all();
        $month = new \DateTime($requestData['appbundle_monthlystatsmaplibrary']['month']);
        
        $entity = new MonthlyStatsMapLibrary($month);
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('monthly_maplibrary_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a MonthlyStatsMapLibrary entity.
     *
     * @param MonthlyStatsMapLibrary $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(MonthlyStatsMapLibrary $entity)
    {
        $form = $this->createForm(new MonthlyStatsMapLibraryType($this->getDoctrine()->getManager()), $entity, array(
            'action' => $this->generateUrl('monthly_maplibrary_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create', 'attr' => array('class' => 'btn btn-sm btn-success')));

        return $form;
    }

    /**
     * Displays a form to create a new MonthlyStatsMapLibrary entity.
     *
     * @Route("/new/{month}", name="monthly_maplibrary_new")
     * @Method("GET")
     * @Template()
     * 
     * @Secure(roles="ROLE_MONTHLYMAPLIBRARY_EDIT")
     * 
     * @param String $month (YYYY-mm-dd)
     */
    public function newAction($month)
    {
        $entity = new MonthlyStatsMapLibrary(new \DateTime($month));
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a MonthlyStatsMapLibrary entity.
     *
     * @Route("/{id}", name="monthly_maplibrary_show")
     * @Method("GET")
     * @Template()
     * 
     * @Secure(roles="ROLE_MONTHLYMAPLIBRARY_VIEW")
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:MonthlyStatsMapLibrary')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find MonthlyStatsMapLibrary entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing MonthlyStatsMapLibrary entity.
     *
     * @Route("/{id}/edit", name="monthly_maplibrary_edit")
     * @Method("GET")
     * @Template()
     * 
     * @Secure(roles="ROLE_MONTHLYMAPLIBRARY_EDIT")
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:MonthlyStatsMapLibrary')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find MonthlyStatsMapLibrary entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
    * Creates a form to edit a MonthlyStatsMapLibrary entity.
    *
    * @param MonthlyStatsMapLibrary $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(MonthlyStatsMapLibrary $entity)
    {
        $form = $this->createForm(new MonthlyStatsMapLibraryType($this->getDoctrine()->getManager()), $entity, array(
            'action' => $this->generateUrl('monthly_maplibrary_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update', 'attr' => array('class' => 'btn btn-sm btn-warning')));

        return $form;
    }
    /**
     * Edits an existing MonthlyStatsMapLibrary entity.
     *
     * @Route("/{id}", name="monthly_maplibrary_update")
     * @Method("PUT")
     * @Template("AppBundle:MonthlyStatsMapLibrary:edit.html.twig")
     * 
     * @Secure(roles="ROLE_MONTHLYMAPLIBRARY_EDIT")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:MonthlyStatsMapLibrary')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find MonthlyStatsMapLibrary entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('monthly_maplibrary_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a MonthlyStatsMapLibrary entity.
     *
     * @Route("/{id}", name="monthly_maplibrary_delete")
     * @Method("DELETE")
     * 
     * @Secure(roles="ROLE_MONTHLYMAPLIBRARY_DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AppBundle:MonthlyStatsMapLibrary')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find MonthlyStatsMapLibrary entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('monthly_maplibrary'));
    }

    /**
     * Creates a form to delete a MonthlyStatsMapLibrary entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('monthly_maplibrary_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete', 'attr' => array('class' => 'btn btn-sm btn-danger')))
            ->getForm()
        ;
    }
    
    /**
     * Displays a printer-friendly MonthlyStatsMapLibrary entity.
     *
     * @Route("/{id}/print", name="monthly_maplibrary_print")
     * @Method("GET")
     * @Template()
     * 
     * @Secure(roles="ROLE_MONTHLYMAPLIBRARY_VIEW")
     */
    public function printAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:MonthlyStatsMapLibrary')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find MonthlyStatsMapLibrary entity.');
        }

        return array(
            'entity'      => $entity,
        );
    }
    
    /**
     * Call the Monthly Stats Service to view a report for the year.
     * 
     * @Route("/report", name="monthly_maplibrary_report")
     * @Method("POST")
     * @Template("AppBundle:MonthlyStatsMapLibrary:viewyearlyreport.html.twig")
     * 
     * @Secure(roles="ROLE_MONTHLYMAPLIBRARY_VIEW")
     */
    public function viewYearlyReportAction(Request $request){
        $requestData = $request->request->all();
        
        $reportType = $requestData['report_type'];
        $reportYear = $requestData['report_year'];
        
        if(isset($requestData['options'])){
            $reportOptions = $requestData['options'];
        } else {
            $reportOptions = array();
        }
        
        $statsService = $this->get('monthlystatistics_service');
        $entities = $statsService->generateYearlyReport('maplibrary', $reportYear, $reportType);
        
        return array(
            'entities' => $entities,
            'type' => $reportType,
            'year' => $reportYear,
            'options' => $reportOptions,
        );
    }
    
    /**
     * Call the Monthly Stats Service to print a report for the year.
     * 
     * @Route("/report/print/yearly", name="monthly_maplibrary_report_print")
     * @Method("GET")
     * @Template("AppBundle:MonthlyStatsMapLibrary:printyearlyreport.html.twig")
     * 
     * @Secure(roles="ROLE_MONTHLYMAPLIBRARY_VIEW")
     */
    public function printYearlyReportAction(Request $request){
        $requestData = $request->query->all();
        
        $reportType = $requestData['report_type'];
        $reportYear = $requestData['report_year'];
        
        if(isset($requestData['options'])){
            $reportOptions = $requestData['options'];
        } else {
            $reportOptions = array();
        }
        
        $statsService = $this->get('monthlystatistics_service');
        $entities = $statsService->generateYearlyReport('maplibrary', $reportYear, $reportType);
        
        return array(
            'entities' => $entities,
            'type' => $reportType,
            'year' => $reportYear,
            'options' => $reportOptions,
        );
    }
    
    /**
     * Call the Monthly Stats Service to generate a CSV for the year.
     * 
     * @Route("/report/csv/yearly", name="monthly_maplibrary_report_csv")
     * @Method("GET")
     * 
     * @Secure(roles="ROLE_MONTHLYMAPLIBRARY_VIEW")
     */
    public function csvYearlyReportAction(Request $request){
        $requestData = $request->query->all();
        
        $reportType = $requestData['report_type'];
        $reportYear = $requestData['report_year'];
        
        
        if(isset($requestData['options'])){
            $reportOptions = $requestData['options'];
        } else {
            $reportOptions = array();
        }
        
        $statsService = $this->get('monthlystatistics_service');
        $entities = $statsService->generateYearlyReport('maplibrary', $reportYear, $reportType);
        
        $excelFile = $statsService->assembleMapLibraryCSV($reportType, $reportYear, $reportOptions, $entities);
        
        return $excelFile;
    }
    
    /**
     * Retrieve a year dropdown list from the Instruction Service
     * 
     * @Route("/years/dropdown", name="monthly_maplibrary_dropdown")
     * @Method("GET")
     * @Template()
     */
    public function getYearsDropdownAction(Request $request){
        $requestData = $request->query->all();
        $reportType = $requestData['type'];
        $reportYear = self::START_YEAR;

        $instructionService = $this->get('instruction_service');
        
        switch($reportType){
            case 'calendar':
                $years = $instructionService->generateYears(false, $reportYear);
                break;
            case 'fiscal':
                $years = $instructionService->generateYears(true, $reportYear);
                break;
        }
        
        if(isset($years) && $years != null){
            return $this->render('snippets/monthlystats-yeardropdown.html.twig', array(
                'years' => $years,
            ));
        }
        
        return new Response('Improperly configured GET request for year dropdown menu.', 400);
    }
}
