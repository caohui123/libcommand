<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use AppBundle\Entity\MonthlyStatsArchivesBox;
use AppBundle\Form\MonthlyStatsArchivesBoxType;

/**
 * MonthlyStatsArchivesBox controller.
 *
 * @Route("/monthly/archives/components/box")
 */
class MonthlyStatsArchivesBoxController extends Controller
{

    /**
     * Lists all MonthlyStatsArchivesBox entities.
     *
     * @Route("/", name="monthly_archives_components_box")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('AppBundle:MonthlyStatsArchivesBox')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new MonthlyStatsArchivesBox entity.
     *
     * @Route("/", name="monthly_archives_components_box_create")
     * @Method("POST")
     * @Template("AppBundle:MonthlyStatsArchivesBox:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new MonthlyStatsArchivesBox();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('monthly_archives_components_box_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a MonthlyStatsArchivesBox entity.
     *
     * @param MonthlyStatsArchivesBox $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(MonthlyStatsArchivesBox $entity)
    {
        $form = $this->createForm(new MonthlyStatsArchivesBoxType(), $entity, array(
            'action' => $this->generateUrl('monthly_archives_components_box_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new MonthlyStatsArchivesBox entity.
     *
     * @Route("/new", name="monthly_archives_components_box_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new MonthlyStatsArchivesBox();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a MonthlyStatsArchivesBox entity.
     *
     * @Route("/{id}", name="monthly_archives_components_box_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:MonthlyStatsArchivesBox')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find MonthlyStatsArchivesBox entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing MonthlyStatsArchivesBox entity.
     *
     * @Route("/{id}/edit", name="monthly_archives_components_box_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:MonthlyStatsArchivesBox')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find MonthlyStatsArchivesBox entity.');
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
    * Creates a form to edit a MonthlyStatsArchivesBox entity.
    *
    * @param MonthlyStatsArchivesBox $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(MonthlyStatsArchivesBox $entity)
    {
        $form = $this->createForm(new MonthlyStatsArchivesBoxType(), $entity, array(
            'action' => $this->generateUrl('monthly_archives_components_box_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing MonthlyStatsArchivesBox entity.
     *
     * @Route("/{id}", name="monthly_archives_components_box_update")
     * @Method("PUT")
     * @Template("AppBundle:MonthlyStatsArchivesBox:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:MonthlyStatsArchivesBox')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find MonthlyStatsArchivesBox entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('monthly_archives_components_box_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a MonthlyStatsArchivesBox entity.
     *
     * @Route("/{id}", name="monthly_archives_components_box_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AppBundle:MonthlyStatsArchivesBox')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find MonthlyStatsArchivesBox entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('monthly_archives_components_box'));
    }

    /**
     * Creates a form to delete a MonthlyStatsArchivesBox entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('monthly_archives_components_box_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
