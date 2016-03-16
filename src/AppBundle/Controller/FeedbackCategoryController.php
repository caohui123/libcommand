<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use AppBundle\Entity\FeedbackCategory;
use AppBundle\Form\FeedbackCategoryType;
use JMS\SecurityExtraBundle\Annotation\Secure;

/**
 * FeedbackCategory controller.
 *
 * @Route("/feedbackcategory")
 */
class FeedbackCategoryController extends Controller
{

    /**
     * Lists all FeedbackCategory entities.
     *
     * @Route("/", name="feedbackcategory")
     * @Method("GET")
     * @Template()
     * 
     * @Secure(roles="ROLE_FEEDBACK_VIEW")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('AppBundle:FeedbackCategory')->findBy(array(), array('name'=>'ASC'));

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new FeedbackCategory entity.
     *
     * @Route("/", name="feedbackcategory_create")
     * @Method("POST")
     * @Template("AppBundle:FeedbackCategory:new.html.twig")
     * 
     * @Secure(roles="ROLE_FEEDBACK_EDIT")
     */
    public function createAction(Request $request)
    {
        $entity = new FeedbackCategory();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('feedbackcategory_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a FeedbackCategory entity.
     *
     * @param FeedbackCategory $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(FeedbackCategory $entity)
    {
        $form = $this->createForm(new FeedbackCategoryType(), $entity, array(
            'action' => $this->generateUrl('feedbackcategory_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new FeedbackCategory entity.
     *
     * @Route("/new", name="feedbackcategory_new")
     * @Method("GET")
     * @Template()
     * 
     * @Secure(roles="ROLE_FEEDBACK_EDIT")
     */
    public function newAction()
    {
        $entity = new FeedbackCategory();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a FeedbackCategory entity.
     *
     * @Route("/{id}", name="feedbackcategory_show")
     * @Method("GET")
     * @Template()
     * 
     * @Secure(roles="ROLE_FEEDBACK_VIEW")
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:FeedbackCategory')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find FeedbackCategory entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing FeedbackCategory entity.
     *
     * @Route("/{id}/edit", name="feedbackcategory_edit")
     * @Method("GET")
     * @Template()
     * 
     * @Secure(roles="ROLE_FEEDBACK_EDIT")
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:FeedbackCategory')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find FeedbackCategory entity.');
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
    * Creates a form to edit a FeedbackCategory entity.
    *
    * @param FeedbackCategory $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(FeedbackCategory $entity)
    {
        $form = $this->createForm(new FeedbackCategoryType(), $entity, array(
            'action' => $this->generateUrl('feedbackcategory_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update', 'attr'=>array('class'=>'btn btn-sm btn-success')));

        return $form;
    }
    /**
     * Edits an existing FeedbackCategory entity.
     *
     * @Route("/{id}", name="feedbackcategory_update")
     * @Method("PUT")
     * @Template("AppBundle:FeedbackCategory:edit.html.twig")
     * 
     * @Secure(roles="ROLE_FEEDBACK_EDIT")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:FeedbackCategory')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find FeedbackCategory entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('feedbackcategory_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a FeedbackCategory entity.
     *
     * @Route("/{id}", name="feedbackcategory_delete")
     * @Method("DELETE")
     * 
     * @Secure(roles="ROLE_FEEDBACK_DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AppBundle:FeedbackCategory')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find FeedbackCategory entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('feedbackcategory'));
    }

    /**
     * Creates a form to delete a FeedbackCategory entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('feedbackcategory_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array(
                'label' => 'Delete', 
                'attr' => array(
                    'class' => 'btn btn-sm btn-danger',
                    'onclick' => 'return confirm("Are you sure you want to delete this category? Any feedback which used this category will no longer reflect it.")'
                    )
                )
            )
            ->getForm()
        ;
    }
}
