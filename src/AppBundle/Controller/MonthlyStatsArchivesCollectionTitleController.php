<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use AppBundle\Entity\MonthlyStatsArchivesCollectionTitle;
use AppBundle\Form\MonthlyStatsArchivesCollectionTitleType;

/**
 * MonthlyStatsArchivesCollectionTitle controller.
 *
 * @Route("/monthly/archives/components/collectiontitle")
 */
class MonthlyStatsArchivesCollectionTitleController extends Controller
{

    /**
     * Lists all MonthlyStatsArchivesCollectionTitle entities.
     *
     * @Route("/", name="monthly_archives_components_collectiontitle")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('AppBundle:MonthlyStatsArchivesCollectionTitle')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new MonthlyStatsArchivesCollectionTitle entity.
     *
     * @Route("/", name="monthly_archives_components_collectiontitle_create")
     * @Method("POST")
     * @Template("AppBundle:MonthlyStatsArchivesCollectionTitle:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new MonthlyStatsArchivesCollectionTitle();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('monthly_archives_components_collectiontitle_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a MonthlyStatsArchivesCollectionTitle entity.
     *
     * @param MonthlyStatsArchivesCollectionTitle $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(MonthlyStatsArchivesCollectionTitle $entity)
    {
        $form = $this->createForm(new MonthlyStatsArchivesCollectionTitleType(), $entity, array(
            'action' => $this->generateUrl('monthly_archives_components_collectiontitle_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new MonthlyStatsArchivesCollectionTitle entity.
     *
     * @Route("/new", name="monthly_archives_components_collectiontitle_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new MonthlyStatsArchivesCollectionTitle();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a MonthlyStatsArchivesCollectionTitle entity.
     *
     * @Route("/{id}", name="monthly_archives_components_collectiontitle_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:MonthlyStatsArchivesCollectionTitle')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find MonthlyStatsArchivesCollectionTitle entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing MonthlyStatsArchivesCollectionTitle entity.
     *
     * @Route("/{id}/edit", name="monthly_archives_components_collectiontitle_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:MonthlyStatsArchivesCollectionTitle')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find MonthlyStatsArchivesCollectionTitle entity.');
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
    * Creates a form to edit a MonthlyStatsArchivesCollectionTitle entity.
    *
    * @param MonthlyStatsArchivesCollectionTitle $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(MonthlyStatsArchivesCollectionTitle $entity)
    {
        $form = $this->createForm(new MonthlyStatsArchivesCollectionTitleType(), $entity, array(
            'action' => $this->generateUrl('monthly_archives_components_collectiontitle_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing MonthlyStatsArchivesCollectionTitle entity.
     *
     * @Route("/{id}", name="monthly_archives_components_collectiontitle_update")
     * @Method("PUT")
     * @Template("AppBundle:MonthlyStatsArchivesCollectionTitle:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:MonthlyStatsArchivesCollectionTitle')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find MonthlyStatsArchivesCollectionTitle entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('monthly_archives_components_collectiontitle_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a MonthlyStatsArchivesCollectionTitle entity.
     *
     * @Route("/{id}", name="monthly_archives_components_collectiontitle_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AppBundle:MonthlyStatsArchivesCollectionTitle')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find MonthlyStatsArchivesCollectionTitle entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('monthly_archives_components_collectiontitle'));
    }

    /**
     * Creates a form to delete a MonthlyStatsArchivesCollectionTitle entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('monthly_archives_components_collectiontitle_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
