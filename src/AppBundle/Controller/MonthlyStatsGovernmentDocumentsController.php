<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use AppBundle\Entity\MonthlyStatsGovernmentDocuments;
use AppBundle\Form\MonthlyStatsGovernmentDocumentsType;
use JMS\SecurityExtraBundle\Annotation\Secure;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;

/**
 * MonthlyStatsGovernmentDocuments controller.
 *
 * @Route("/monthly/govdocs")
 */
class MonthlyStatsGovernmentDocumentsController extends Controller
{
    const START_YEAR = 2003;

    /**
     * Lists all MonthlyStatsGovernmentDocuments entities.
     *
     * @Route("/", name="monthly_govdocs")
     * @Method("GET")
     * @Template()
     * 
     * @Secure(roles="ROLE_MONTHLYGOVDOCS_VIEW")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        
        $statsService = $this->get('monthlystatistics_service');
        $yearlyTables = $statsService->monthlyTablesByYear('govdocs', self::START_YEAR);

        return array(
            'yearly_tables' => $yearlyTables,
        );
    }
    /**
     * Creates a new MonthlyStatsGovernmentDocuments entity.
     *
     * @Route("/", name="monthly_govdocs_create")
     * @Method("POST")
     * @Template("AppBundle:MonthlyStatsGovernmentDocuments:new.html.twig")
     * 
     * @Secure(roles="ROLE_MONTHLYGOVDOCS_EDIT")
     */
    public function createAction(Request $request)
    {
        $requestData = $request->request->all();
        $month = new \DateTime($requestData['appbundle_monthlystatsgovernmentdocuments']['month']);
        
        $entity = new MonthlyStatsGovernmentDocuments($month);
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('monthly_govdocs_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a MonthlyStatsGovernmentDocuments entity.
     *
     * @param MonthlyStatsGovernmentDocuments $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(MonthlyStatsGovernmentDocuments $entity)
    {
        $form = $this->createForm(new MonthlyStatsGovernmentDocumentsType($this->getDoctrine()->getManager()), $entity, array(
            'action' => $this->generateUrl('monthly_govdocs_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create', 'attr' => array('class' => 'btn btn-sm btn-success')));

        return $form;
    }

    /**
     * Displays a form to create a new MonthlyStatsGovernmentDocuments entity.
     *
     * @Route("/new/{month}", name="monthly_govdocs_new")
     * @Method("GET")
     * @Template()
     * 
     * @Secure(roles="ROLE_MONTHLYGOVDOCS_EDIT")
     * 
     * @param String $month (YYYY-mm-dd)
     */
    public function newAction($month)
    {
        $entity = new MonthlyStatsGovernmentDocuments(new \DateTime($month));
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a MonthlyStatsGovernmentDocuments entity.
     *
     * @Route("/{id}", name="monthly_govdocs_show")
     * @Method("GET")
     * @Template()
     * 
     * @Secure(roles="ROLE_MONTHLYGOVDOCS_VIEW")
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:MonthlyStatsGovernmentDocuments')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find MonthlyStatsGovernmentDocuments entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing MonthlyStatsGovernmentDocuments entity.
     *
     * @Route("/{id}/edit", name="monthly_govdocs_edit")
     * @Method("GET")
     * @Template()
     * 
     * @Secure(roles="ROLE_MONTHLYGOVDOCS_EDIT")
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:MonthlyStatsGovernmentDocuments')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find MonthlyStatsGovernmentDocuments entity.');
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
    * Creates a form to edit a MonthlyStatsGovernmentDocuments entity.
    *
    * @param MonthlyStatsGovernmentDocuments $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(MonthlyStatsGovernmentDocuments $entity)
    {
        $form = $this->createForm(new MonthlyStatsGovernmentDocumentsType($this->getDoctrine()->getManager()), $entity, array(
            'action' => $this->generateUrl('monthly_govdocs_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update', 'attr' => array('class' => 'btn btn-sm btn-warning')));

        return $form;
    }
    /**
     * Edits an existing MonthlyStatsGovernmentDocuments entity.
     *
     * @Route("/{id}", name="monthly_govdocs_update")
     * @Method("PUT")
     * @Template("AppBundle:MonthlyStatsGovernmentDocuments:edit.html.twig")
     * 
     * @Secure(roles="ROLE_MONTHLYGOVDOCS_EDIT")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:MonthlyStatsGovernmentDocuments')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find MonthlyStatsGovernmentDocuments entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('monthly_govdocs_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a MonthlyStatsGovernmentDocuments entity.
     *
     * @Route("/{id}", name="monthly_govdocs_delete")
     * @Method("DELETE")
     * 
     * @Secure(roles="ROLE_MONTHLYGOVDOCS_DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AppBundle:MonthlyStatsGovernmentDocuments')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find MonthlyStatsGovernmentDocuments entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('monthly_govdocs'));
    }

    /**
     * Creates a form to delete a MonthlyStatsGovernmentDocuments entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('monthly_govdocs_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete', 'attr' => array('class' => 'btn btn-sm btn-danger')))
            ->getForm()
        ;
    }
    
    /**
     * Displays a printer-friendly MonthlyStatsGovernmentDocuments entity.
     *
     * @Route("/{id}/print", name="monthly_govdocs_print")
     * @Method("GET")
     * @Template()
     * 
     * @Secure(roles="ROLE_MONTHLYGOVDOCS_VIEW")
     */
    public function printAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:MonthlyStatsGovernmentDocuments')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find MonthlyStatsGovernmentDocuments entity.');
        }

        return array(
            'entity'      => $entity,
        );
    }
    
    /**
     * Call the Monthly Stats Service to generate a report for the year.
     * 
     * @Route("/report", name="monthly_govdocs_report")
     * @Method("POST")
     * @Template("AppBundle:MonthlyStatsGovernmentDocuments:viewyearlyreport.html.twig")
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
        $entities = $statsService->generateGovdocsYearlyReport($reportYear, $reportType);
        
        return array(
            'entities' => $entities,
            'type' => $reportType,
            'year' => $reportYear,
            'options' => $reportOptions,
        );
    }
    
    /**
     * Call the Monthly Stats Service to generate a report for the year.
     * 
     * @Route("/report/print/yearly", name="monthly_govdocs_report_print")
     * @Method("GET")
     * @Template("AppBundle:MonthlyStatsGovernmentDocuments:printyearlyreport.html.twig")
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
        $entities = $statsService->generateGovdocsYearlyReport($reportYear, $reportType);
        
        return array(
            'entities' => $entities,
            'type' => $reportType,
            'year' => $reportYear,
            'options' => $reportOptions,
        );
    }
    
    /**
     * Call the Monthly Stats Service to generate a report for the year.
     * 
     * @Route("/report/csv/yearly", name="monthly_govdocs_report_csv")
     * @Method("GET")
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
        $entities = $statsService->generateGovdocsYearlyReport($reportYear, $reportType);
        
        $excelFile = $statsService->assembleGovDocsCSV($reportType, $reportYear, $reportOptions, $entities);
        
        return $excelFile;
    }
    
    /**
     * Retrieve a year dropdown list from the Instruction Service
     * 
     * @Route("/years/dropdown", name="monthly_govdocs_dropdown")
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
            return $this->render('AppBundle:MonthlyStatsGovernmentDocuments:snippets/yeardropdown.html.twig', array(
                'years' => $years,
            ));
        }
        
        return new Response('Improperly configured GET request for year dropdown menu.', 400);
    }
}
