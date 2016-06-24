<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use AppBundle\Entity\MonthlyStatsArchivesBookTitle;
use AppBundle\Form\MonthlyStatsArchivesBookTitleType;

/**
 * MonthlyStatsArchivesBookTitle controller.
 *
 * @Route("/monthly/archives/components/booktitle")
 */
class MonthlyStatsArchivesBookTitleController extends Controller
{

    /**
     * Lists all MonthlyStatsArchivesBookTitle entities.
     *
     * @Route("/", name="monthly_archives_components_booktitle")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('AppBundle:MonthlyStatsArchivesBookTitle')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new MonthlyStatsArchivesBookTitle entity.
     *
     * @Route("/", name="monthly_archives_components_booktitle_create")
     * @Method("POST")
     * @Template("AppBundle:MonthlyStatsArchivesBookTitle:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new MonthlyStatsArchivesBookTitle();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('monthly_archives_components_booktitle_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a MonthlyStatsArchivesBookTitle entity.
     *
     * @param MonthlyStatsArchivesBookTitle $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(MonthlyStatsArchivesBookTitle $entity)
    {
        $form = $this->createForm(new MonthlyStatsArchivesBookTitleType(), $entity, array(
            'action' => $this->generateUrl('monthly_archives_components_booktitle_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new MonthlyStatsArchivesBookTitle entity.
     *
     * @Route("/new", name="monthly_archives_components_booktitle_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new MonthlyStatsArchivesBookTitle();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a MonthlyStatsArchivesBookTitle entity.
     *
     * @Route("/{id}", name="monthly_archives_components_booktitle_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:MonthlyStatsArchivesBookTitle')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find MonthlyStatsArchivesBookTitle entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing MonthlyStatsArchivesBookTitle entity.
     *
     * @Route("/{id}/edit", name="monthly_archives_components_booktitle_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:MonthlyStatsArchivesBookTitle')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find MonthlyStatsArchivesBookTitle entity.');
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
    * Creates a form to edit a MonthlyStatsArchivesBookTitle entity.
    *
    * @param MonthlyStatsArchivesBookTitle $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(MonthlyStatsArchivesBookTitle $entity)
    {
        $form = $this->createForm(new MonthlyStatsArchivesBookTitleType(), $entity, array(
            'action' => $this->generateUrl('monthly_archives_components_booktitle_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing MonthlyStatsArchivesBookTitle entity.
     *
     * @Route("/{id}", name="monthly_archives_components_booktitle_update")
     * @Method("PUT")
     * @Template("AppBundle:MonthlyStatsArchivesBookTitle:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:MonthlyStatsArchivesBookTitle')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find MonthlyStatsArchivesBookTitle entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('monthly_archives_components_booktitle_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a MonthlyStatsArchivesBookTitle entity.
     *
     * @Route("/{id}", name="monthly_archives_components_booktitle_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AppBundle:MonthlyStatsArchivesBookTitle')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find MonthlyStatsArchivesBookTitle entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('monthly_archives_components_booktitle'));
    }

    /**
     * Creates a form to delete a MonthlyStatsArchivesBookTitle entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('monthly_archives_components_booktitle_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
