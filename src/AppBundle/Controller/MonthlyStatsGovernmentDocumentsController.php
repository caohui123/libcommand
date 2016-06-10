<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use AppBundle\Entity\MonthlyStatsGovernmentDocuments;
use AppBundle\Form\MonthlyStatsGovernmentDocumentsType;

/**
 * MonthlyStatsGovernmentDocuments controller.
 *
 * @Route("/monthly/govdocs")
 */
class MonthlyStatsGovernmentDocumentsController extends Controller
{

    /**
     * Lists all MonthlyStatsGovernmentDocuments entities.
     *
     * @Route("/", name="monthly_govdocs")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('AppBundle:MonthlyStatsGovernmentDocuments')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new MonthlyStatsGovernmentDocuments entity.
     *
     * @Route("/", name="monthly_govdocs_create")
     * @Method("POST")
     * @Template("AppBundle:MonthlyStatsGovernmentDocuments:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new MonthlyStatsGovernmentDocuments();
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
        $form = $this->createForm(new MonthlyStatsGovernmentDocumentsType(), $entity, array(
            'action' => $this->generateUrl('monthly_govdocs_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new MonthlyStatsGovernmentDocuments entity.
     *
     * @Route("/new", name="monthly_govdocs_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new MonthlyStatsGovernmentDocuments();
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
        $form = $this->createForm(new MonthlyStatsGovernmentDocumentsType(), $entity, array(
            'action' => $this->generateUrl('monthly_govdocs_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing MonthlyStatsGovernmentDocuments entity.
     *
     * @Route("/{id}", name="monthly_govdocs_update")
     * @Method("PUT")
     * @Template("AppBundle:MonthlyStatsGovernmentDocuments:edit.html.twig")
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
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
