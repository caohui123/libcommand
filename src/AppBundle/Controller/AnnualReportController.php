<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use AppBundle\Entity\AnnualReport;
use AppBundle\Form\AnnualReportType;
use AppBundle\Entity\AnnualReportUnit;
use AppBundle\Entity\AnnualReportStaffing;

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
     * @Route("/", name="annualreport")
     * @Method("GET")
     * @Template()
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
     */
    public function createAction(Request $request)
    {
        $requestData = $request->request->all();
        
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

            return $this->redirect($this->generateUrl('annualreport_show', array('id' => $entity->getId())));
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

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new AnnualReport entity.
     *
     * @Route("/new/{unit}/{year}", name="annualreport_new")
     * @Method("GET")
     * @Template()
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
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing AnnualReport entity.
     *
     * @Route("/{id}", name="annualreport_update")
     * @Method("PUT")
     * @Template("AppBundle:AnnualReport:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:AnnualReport')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find AnnualReport entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
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
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AppBundle:AnnualReport')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find AnnualReport entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('annualreport'));
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
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('annualreport_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
