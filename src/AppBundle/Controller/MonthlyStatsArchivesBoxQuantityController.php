<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use AppBundle\Entity\MonthlyStatsArchivesBoxQuantity;
use AppBundle\Form\MonthlyStatsArchivesBoxQuantityType;

/**
 * MonthlyStatsArchivesBoxQuantity controller.
 *
 * @Route("/monthly/archives/components/boxquantity")
 */
class MonthlyStatsArchivesBoxQuantityController extends Controller
{

    /**
     * Lists all MonthlyStatsArchivesBoxQuantity entities.
     *
     * @Route("/", name="monthly_archives_components_boxquantity")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('AppBundle:MonthlyStatsArchivesBoxQuantity')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new MonthlyStatsArchivesBoxQuantity entity.
     *
     * @Route("/", name="monthly_archives_components_boxquantity_create")
     * @Method("POST")
     * @Template("AppBundle:MonthlyStatsArchivesBoxQuantity:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new MonthlyStatsArchivesBoxQuantity();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('monthly_archives_components_boxquantity_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a MonthlyStatsArchivesBoxQuantity entity.
     *
     * @param MonthlyStatsArchivesBoxQuantity $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(MonthlyStatsArchivesBoxQuantity $entity)
    {
        $form = $this->createForm(new MonthlyStatsArchivesBoxQuantityType(), $entity, array(
            'action' => $this->generateUrl('monthly_archives_components_boxquantity_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new MonthlyStatsArchivesBoxQuantity entity.
     *
     * @Route("/new", name="monthly_archives_components_boxquantity_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new MonthlyStatsArchivesBoxQuantity();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a MonthlyStatsArchivesBoxQuantity entity.
     *
     * @Route("/{id}", name="monthly_archives_components_boxquantity_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:MonthlyStatsArchivesBoxQuantity')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find MonthlyStatsArchivesBoxQuantity entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing MonthlyStatsArchivesBoxQuantity entity.
     *
     * @Route("/{id}/edit", name="monthly_archives_components_boxquantity_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:MonthlyStatsArchivesBoxQuantity')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find MonthlyStatsArchivesBoxQuantity entity.');
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
    * Creates a form to edit a MonthlyStatsArchivesBoxQuantity entity.
    *
    * @param MonthlyStatsArchivesBoxQuantity $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(MonthlyStatsArchivesBoxQuantity $entity)
    {
        $form = $this->createForm(new MonthlyStatsArchivesBoxQuantityType(), $entity, array(
            'action' => $this->generateUrl('monthly_archives_components_boxquantity_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing MonthlyStatsArchivesBoxQuantity entity.
     *
     * @Route("/{id}", name="monthly_archives_components_boxquantity_update")
     * @Method("PUT")
     * @Template("AppBundle:MonthlyStatsArchivesBoxQuantity:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:MonthlyStatsArchivesBoxQuantity')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find MonthlyStatsArchivesBoxQuantity entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('monthly_archives_components_boxquantity_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a MonthlyStatsArchivesBoxQuantity entity.
     *
     * @Route("/{id}", name="monthly_archives_components_boxquantity_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AppBundle:MonthlyStatsArchivesBoxQuantity')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find MonthlyStatsArchivesBoxQuantity entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('monthly_archives_components_boxquantity'));
    }

    /**
     * Creates a form to delete a MonthlyStatsArchivesBoxQuantity entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('monthly_archives_components_boxquantity_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
