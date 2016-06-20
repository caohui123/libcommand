<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use JMS\SecurityExtraBundle\Annotation\Secure;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Entity\MonthlyStatsArchives;
use AppBundle\Form\MonthlyStatsArchivesType;

/**
 * MonthlyStatsArchives controller.
 *
 * @Route("/monthly/archives")
 */
class MonthlyStatsArchivesController extends Controller
{
    const START_YEAR = 2003;
    
    /**
     * Lists all MonthlyStatsArchives entities.
     *
     * @Route("/", name="monthly_archives")
     * @Method("GET")
     * @Template()
     * //@Secure(roles="ROLE_MONTHLYARCHIVES_VIEW")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('AppBundle:MonthlyStatsArchives')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new MonthlyStatsArchives entity.
     *
     * @Route("/", name="monthly_archives_create")
     * @Method("POST")
     * @Template("AppBundle:MonthlyStatsArchives:new.html.twig")
     * //@Secure(roles="ROLE_MONTHLYARCHIVES_EDIT")
     */
    public function createAction(Request $request)
    {
        $requestData = $request->request->all();
        $month = new \DateTime($requestData['appbundle_monthlystatsarchives']['month']);
        
        $entity = new MonthlyStatsArchives($month);
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('monthly_archives_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a MonthlyStatsArchives entity.
     *
     * @param MonthlyStatsArchives $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(MonthlyStatsArchives $entity)
    {
        $form = $this->createForm(new MonthlyStatsArchivesType($this->getDoctrine()->getManager()), $entity, array(
            'action' => $this->generateUrl('monthly_archives_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create', 'attr' => array('class' => 'btn btn-sm btn-success')));

        return $form;
    }

    /**
     * Displays a form to create a new MonthlyStatsArchives entity.
     *
     * @Route("/new/{month}", name="monthly_archives_new")
     * @Method("GET")
     * @Template()
     * //@Secure(roles="ROLE_MONTHLYARCHIVES_EDIT")
     */
    public function newAction($month)
    {
        $entity = new MonthlyStatsArchives(new \DateTime($month));
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a MonthlyStatsArchives entity.
     *
     * @Route("/{id}", name="monthly_archives_show")
     * @Method("GET")
     * @Template()
     * //@Secure(roles="ROLE_MONTHLYARCHIVES_VIEW")
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:MonthlyStatsArchives')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find MonthlyStatsArchives entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing MonthlyStatsArchives entity.
     *
     * @Route("/{id}/edit", name="monthly_archives_edit")
     * @Method("GET")
     * @Template()
     * //@Secure(roles="ROLE_MONTHLYARCHIVES_EDIT")
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:MonthlyStatsArchives')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find MonthlyStatsArchives entity.');
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
    * Creates a form to edit a MonthlyStatsArchives entity.
    *
    * @param MonthlyStatsArchives $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(MonthlyStatsArchives $entity)
    {
        $form = $this->createForm(new MonthlyStatsArchivesType($this->getDoctrine()->getManager()), $entity, array(
            'action' => $this->generateUrl('monthly_archives_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update', 'attr' => array('class' => 'btn btn-sm btn-warning')));

        return $form;
    }
    /**
     * Edits an existing MonthlyStatsArchives entity.
     *
     * @Route("/{id}", name="monthly_archives_update")
     * @Method("PUT")
     * @Template("AppBundle:MonthlyStatsArchives:edit.html.twig")
     * //@Secure(roles="ROLE_MONTHLYARCHIVES_EDIT")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:MonthlyStatsArchives')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find MonthlyStatsArchives entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('monthly_archives_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a MonthlyStatsArchives entity.
     *
     * @Route("/{id}", name="monthly_archives_delete")
     * @Method("DELETE")
     * //@Secure(roles="ROLE_MONTHLYARCHIVES_DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AppBundle:MonthlyStatsArchives')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find MonthlyStatsArchives entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('monthly_archives'));
    }

    /**
     * Creates a form to delete a MonthlyStatsArchives entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('monthly_archives_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete', 'attr' => array('class' => 'btn btn-sm btn-danger')))
            ->getForm()
        ;
    }
    
    /**
     * Displays a printer-friendly MonthlyStatsArchives entity.
     *
     * @Route("/{id}/print", name="monthly_govdocs_print")
     * @Method("GET")
     * @Template()
     * 
     * //@Secure(roles="ROLE_MONTHLYARCHIVES_VIEW")
     */
    public function printAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:MonthlyStatsArchives')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find MonthlyStatsArchives entity.');
        }

        return array(
            'entity'      => $entity,
        );
    }
}
