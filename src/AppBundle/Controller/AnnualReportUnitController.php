<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use AppBundle\Entity\AnnualReportUnit;
use AppBundle\Form\AnnualReportUnitType;
use JMS\SecurityExtraBundle\Annotation\Secure;
use Symfony\Component\HttpFoundation\Response;

/**
 * AnnualReportUnit controller.
 *
 * @Route("/annualreportunit")
 */
class AnnualReportUnitController extends Controller
{

    /**
     * Lists all AnnualReportUnit entities.
     *
     * @Route("/", name="annualreportunit")
     * @Method("GET")
     * @Template()
     * 
     * @Secure(roles="ROLE_ANNUALREPORT_VIEW")
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('AppBundle:AnnualReportUnit')->findBy(array('isActive' => 1), array('name' => 'ASC'));
        $inactiveUnits = $em->getRepository('AppBundle:AnnualReportUnit')->findBy(array('isActive' => 0), array('name' => 'ASC'));
        
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
            'inactive_units' => $inactiveUnits,
        );
    }
    /**
     * Creates a new AnnualReportUnit entity.
     *
     * @Route("/", name="annualreportunit_create")
     * @Method("POST")
     * @Template("AppBundle:AnnualReportUnit:new.html.twig")
     * 
     * @Secure(roles="ROLE_ANNUALREPORT_EDIT")
     */
    public function createAction(Request $request)
    {
        $entity = new AnnualReportUnit();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            
            $entity->setIsActive(1);
            
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('annualreportunit_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a AnnualReportUnit entity.
     *
     * @param AnnualReportUnit $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(AnnualReportUnit $entity)
    {
        $form = $this->createForm(new AnnualReportUnitType(), $entity, array(
            'action' => $this->generateUrl('annualreportunit_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create', 'attr' => array('class' => 'btn btn-sm btn-success')));

        return $form;
    }

    /**
     * Displays a form to create a new AnnualReportUnit entity.
     *
     * @Route("/new", name="annualreportunit_new")
     * @Method("GET")
     * @Template()
     * 
     * @Secure(roles="ROLE_ANNUALREPORT_EDIT")
     */
    public function newAction()
    {
        $entity = new AnnualReportUnit();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a AnnualReportUnit entity.
     *
     * @Route("/{id}", name="annualreportunit_show")
     * @Method("GET")
     * @Template()
     * 
     * @Secure(roles="ROLE_ANNUALREPORT_VIEW")
     */
    public function showAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        
        $entity = $em->getRepository('AppBundle:AnnualReportUnit')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find AnnualReportUnit entity.');
        }
        
        $deleteForm = $this->createDeleteForm($id);
        
        $annualReports = $em->getRepository('AppBundle:AnnualReport')->findBy(array('unit' => $entity), array('year' => 'DESC'));
        
        $requestData = $request->query->all();
        isset($requestData['maxItems']) ? $maxItems = $requestData['maxItems'] : $maxItems = 10;
      
        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $annualReports, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            $maxItems/*limit per page*/
        );

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
            'pagination' => $pagination,
        );
    }

    /**
     * Displays a form to edit an existing AnnualReportUnit entity.
     *
     * @Route("/{id}/edit", name="annualreportunit_edit")
     * @Method("GET")
     * @Template()
     * 
     * @Secure(roles="ROLE_ANNUALREPORT_EDIT")
     */
    public function editAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:AnnualReportUnit')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find AnnualReportUnit entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);
        
        //Annual reports for this unit (if any)
        $annualreports = $em->getRepository('AppBundle:AnnualReport')->findBy(array('unit' => $entity), array('year' => 'DESC'));
        
        $requestData = $request->query->all();
        isset($requestData['maxItems']) ? $maxItems = $requestData['maxItems'] : $maxItems = 10;
      
        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $annualreports, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            $maxItems/*limit per page*/
        );

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'pagination' => $pagination,
        );
    }

    /**
    * Creates a form to edit a AnnualReportUnit entity.
    *
    * @param AnnualReportUnit $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(AnnualReportUnit $entity)
    {
        $form = $this->createForm(new AnnualReportUnitType(), $entity, array(
            'action' => $this->generateUrl('annualreportunit_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));
        $form->add('isActive', 'checkbox', array(
            'label' => 'Active',
            'required' => false, 
            'attr' => array('class' => 'user-status-ckbx-noajax')
        ));
        $form->add('submit', 'submit', array('label' => 'Update', 'attr' => array('class' => 'btn btn-sm btn-warning')));

        return $form;
    }
    /**
     * Edits an existing AnnualReportUnit entity.
     *
     * @Route("/{id}", name="annualreportunit_update")
     * @Method("PUT")
     * @Template("AppBundle:AnnualReportUnit:edit.html.twig")
     * 
     * @Secure(roles="ROLE_ANNUALREPORT_EDIT")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:AnnualReportUnit')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find AnnualReportUnit entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('annualreportunit_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a AnnualReportUnit entity.
     *
     * @Route("/{id}", name="annualreportunit_delete")
     * @Method("DELETE")
     * 
     * @Secure(roles="ROLE_ANNUALREPORT_DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AppBundle:AnnualReportUnit')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find AnnualReportUnit entity.');
            }
            
            //Do NOT delete this if there are still Annual Reports which belong to it (ensures a unit isn't deleted by accident, which would also wipe out these reports)
            $annualReports = $em->getRepository('AppBundle:AnnualReport')->findBy(array('unit' => $entity));
            if($annualReports){
                $this->addFlash(
                    'existingreports',
                    'You must delete all annual reports for this unit before deleting the unit!'
                );
                
                return $this->redirect($this->generateUrl('annualreportunit_edit', array('id' => $entity->getId())));
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('annualreportunit'));
    }

    /**
     * Creates a form to delete a AnnualReportUnit entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('annualreportunit_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array(
                'label' => 'Delete Unit', 
                'attr' => array(
                    'class' => 'btn btn-sm btn-danger',
                    'onclick' => 'return confirm("WARNING! Deleting this Unit will also delete any associated annual reports. To avoid this, please change the unit\'s activation status to inactive.")'
                    )))
            ->getForm()
        ;
    }
    
    /**
     * Displays a printer-friendly AnnualReportUnit entity.
     *
     * @Route("/{id}/print", name="annualreportunit_print")
     * @Method("GET")
     * @Template()
     * 
     * @Secure(roles="ROLE_ANNUALREPORT_VIEW")
     */
    public function printAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:AnnualReportUnit')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find AnnualReportUnit entity.');
        }

        //Get years for which this unit has annual reports.
        $years = $this->__unitReportYears($entity);
        
        return array(
            'entity'      => $entity,
            'years'       => $years,
        );
    }
    
    /**
     * Return the number of annual reports associated with this AnnualReportUnit.
     *
     * @Route("/reports/count/{id}", name="annualreportunit_countreports")
     * @Method("GET")
     * 
     * @Secure(roles="ROLE_ANNUALREPORT_VIEW")
     */
    public function countAnnualReportsAction($id){
        $em = $this->getDoctrine()->getManager();
        
        $unit = $em->getRepository('AppBundle:AnnualReportUnit')->find($id);
        if(!$unit){
            throw $this->createNotFoundException('Unable to find AnnualReportUnit entity.');
        }
        
        $reports = $em->getRepository('AppBundle:AnnualReport')->findBy(array('unit' => $unit));
        return new Response(count($reports), 200);
    }
    
    /**
     * Return the years for which the given unit has an annual report.
     *
     * @param AppBundle\Entity\AnnualReportUnit $unit
     * 
     * @return array $years
     */
    private function __unitReportYears(AnnualReportUnit $unit){
        $em = $this->getDoctrine()->getManager();
        
        $years = array();
        
        //Get years for which this unit has an annual report
        $annualReports = $em->getRepository('AppBundle:AnnualReport')->findBy(array('unit' => $unit), array('year' => 'DESC'));
        if(!$annualReports){
            return $years; 
        }
        
        foreach($annualReports as $report){
            $year = $report->getYear();
            $years[] = $year . '-' . ($year + 1);
        }
        
        return $years;
    }
}
