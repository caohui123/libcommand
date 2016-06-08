<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use AppBundle\Entity\AnnualReport;
use AppBundle\Form\AnnualReportType;
use AppBundle\Entity\AnnualReportUnit;
use JMS\SecurityExtraBundle\Annotation\Secure;

/**
 * AnnualReport controller.
 *
 * @Route("/annualreport")
 */
class AnnualReportController extends Controller
{

    /**
     * Lists all AnnualReport entities.
     *
     * //@Route("/", name="annualreport")
     * //@Method("GET")
     * //@Template()
     * 
     * KEEP THIS ROUTE CLOSED UNLESS TESTING
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('AppBundle:AnnualReport')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new AnnualReport entity.
     *
     * @Route("/", name="annualreport_create")
     * @Method("POST")
     * @Template("AppBundle:AnnualReport:new.html.twig")
     * 
     * @Secure(roles="ROLE_ANNUALREPORT_EDIT")
     */
    public function createAction(Request $request)
    {
        $requestData = $request->request->all();
        //var_dump($requestData);
        
        $em = $this->getDoctrine()->getManager();
        
        $unitid = $requestData['appbundle_annualreport']['unit'];
        $year = $requestData['appbundle_annualreport']['year'];
        
        $unit = $em->getRepository('AppBundle:AnnualReportUnit')->find($unitid);
        if(!$unit){
            throw $this->createNotFoundException('Unable to find AnnualReportUnit entity.');
        }
        
        $entity = new AnnualReport($unit, $year);
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('annualreport_edit', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a AnnualReport entity.
     *
     * @param AnnualReport $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(AnnualReport $entity)
    {
        $form = $this->createForm(new AnnualReportType($this->getDoctrine()->getManager()), $entity, array(
            'action' => $this->generateUrl('annualreport_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array(
            'label' => 'Create Draft',
            'attr' => array(
                'class' => 'btn btn-sm btn-success'
            ),
        ));

        return $form;
    }

    /**
     * Displays a form to create a new AnnualReport entity.
     *
     * @Route("/new/{unit}/{year}", name="annualreport_new")
     * @Method("GET")
     * @Template()
     * 
     * @Secure(roles="ROLE_ANNUALREPORT_EDIT")
     */
    public function newAction(AnnualReportUnit $unit, $year)
    {
        $em = $this->getDoctrine()->getManager();
        
        // Kick the user back to the AnnualReportUnit's edit view if a report for this unit and year already exists.
        $existingReport = $em->getRepository('AppBundle:AnnualReport')->findOneBy(array('unit' => $unit, 'year' => $year));
        if($existingReport){
            $this->addFlash(
                'reportexists',
                'A report for this year has already been created for this unit.'
            );
            return $this->redirectToRoute('annualreportunit_edit', array('id' => $unit->getId()));
        }
        
        $entity = new AnnualReport($unit, $year);
        
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a AnnualReport entity.
     *
     * @Route("/{id}", name="annualreport_show")
     * @Method("GET")
     * @Template()
     * 
     * @Secure(roles="ROLE_ANNUALREPORT_VIEW")
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:AnnualReport')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find AnnualReport entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing AnnualReport entity.
     *
     * @Route("/{id}/edit", name="annualreport_edit")
     * @Method("GET")
     * @Template()
     * 
     * @Secure(roles="ROLE_ANNUALREPORT_EDIT")
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:AnnualReport')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find AnnualReport entity.');
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
    * Creates a form to edit a AnnualReport entity.
    *
    * @param AnnualReport $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(AnnualReport $entity)
    {
        $form = $this->createForm(new AnnualReportType($this->getDoctrine()->getManager()), $entity, array(
            'action' => $this->generateUrl('annualreport_update', array('id' => $entity->getId())),
            'method' => 'PUT', //DO NOT USE PATCH because partial form data submission will NOT allow for deletion of staffing & detail collections
        ));

        $form->add('submit', 'submit', array('label' => 'Update', 'attr' => array('class' => 'btn btn-sm btn-warning')));

        return $form;
    }
    /**
     * Edits an existing AnnualReport entity.
     * 
     * NOTE: The PATCH method allows submitting partial data. 
     * In other words, if the submitted form data is missing certain fields (e.g. Document collection entities), 
     * those will be ignored and the default values (if any) will be used. 
     * With all other HTTP methods, if the submitted form data is missing some fields, those fields are set to null.
     *
     * @Route("/{id}", name="annualreport_update")
     * @Method({"PUT", "PATCH"})
     * @Template("AppBundle:AnnualReport:edit.html.twig")
     * 
     * @Secure(roles="ROLE_ANNUALREPORT_EDIT")
     */
    public function updateAction(Request $request, $id)
    {   
        $requestData = $request->request->all();
        
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:AnnualReport')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find AnnualReport entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            //Remove any documents marked for deletion (allow_delete set to FALSE in form so have to do manually)
            if(isset($requestData['delete_document'])){
                foreach($requestData['delete_document'] as $documentId){
                    $document = $em->getRepository('AppBundle:AnnualReportDocument')->find($documentId);
                    if(!$document){
                        throw $this->createNotFoundException('Unable to find AnnualReportDocument entity.');
                    }
                    $entity->removeDocument($document);
                }
            }
            $em->flush();

            return $this->redirect($this->generateUrl('annualreport_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );

    }
    /**
     * Deletes a AnnualReport entity.
     *
     * @Route("/{id}", name="annualreport_delete")
     * @Method("DELETE")
     * 
     * @Secure(roles="ROLE_ANNUALREPORT_DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $requestData = $request->request->all();
        $unit = $requestData['form']['unit'];
        
        
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AppBundle:AnnualReport')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find AnnualReport entity.');
            }
            
            $em->remove($entity);
            $em->flush(); //flush again to remove the annual report
        }

        return $this->redirect($this->generateUrl('annualreportunit_edit', array('id' => $unit)));
    }

    /**
     * Creates a form to delete a AnnualReport entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        //Look up the AnnualReportUnit to which this entity belongs and send it with the form.
        $em = $this->getDoctrine()->getManager();
        
        $entity = $em->getRepository('AppBundle:AnnualReport')->find($id);
        $unit = $entity->getUnit()->getId();
        
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('annualreport_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('unit', 'hidden', array(
                'data' => $unit,
            ))
            ->add('submit', 'submit', array(
                'label' => 'Delete',
                'attr' => array(
                    'class' => 'btn btn-sm btn-danger',
                    'onclick' => 'return confirm("Are you sure you want to delete this report? All associated documents will be deleted along with it.")',
                    )
            ))
            ->getForm()
        ;
    }
    
    /**
     * Displays a printer-friendly AnnualReport entity.
     *
     * @Route("/{id}/print", name="annualreport_print")
     * @Method("GET")
     * @Template()
     * 
     * @Secure(roles="ROLE_ANNUALREPORT_VIEW")
     */
    public function printAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:AnnualReport')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find AnnualReport entity.');
        }

        return array(
            'entity'      => $entity,
        );
    }
}
