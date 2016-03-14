<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use AppBundle\Entity\FindText;
use AppBundle\Form\FindTextType;

/**
 * FindText controller.
 *
 * @Route("/findtext")
 */
class FindTextController extends Controller
{

    /**
     * Lists all FindText entities.
     *
     * @Route("/", name="findtext")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('AppBundle:FindText')->findBy(array(), array('created'=>'DESC'));

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new FindText entity.
     * --ROUTE COMMENTED OUT. THIS SHOULD ONLY BE AVAILABLE THROUGH THE REST API. USE FOR TESTING ONLY!--
     * //@Route("/", name="findtext_create")
     * //@Method("POST")
     * //@Template("AppBundle:FindText:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new FindText();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('findtext_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a FindText entity.
     *
     * @param FindText $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(FindText $entity)
    {
        $form = $this->createForm(new FindTextType(), $entity, array(
            'action' => $this->generateUrl('findtext_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new FindText entity.
     * --ROUTE COMMENTED OUT. THIS SHOULD ONLY BE AVAILABLE THROUGH THE REST API. USE FOR TESTING ONLY!--
     * //@Route("/new", name="findtext_new")
     * //@Method("GET")
     * //@Template()
     */
    public function newAction()
    {
        $entity = new FindText();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a FindText entity.
     *
     * @Route("/{id}", name="findtext_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:FindText')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find FindText entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing FindText entity.
     *
     * @Route("/{id}/edit", name="findtext_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:FindText')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find FindText entity.');
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
    * Creates a form to edit a FindText entity.
    *
    * @param FindText $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(FindText $entity)
    {
        $form = $this->createForm(new FindTextType(), $entity, array(
            'action' => $this->generateUrl('findtext_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update', 'attr'=>array('class'=>'btn btn-sm btn-success')));

        return $form;
    }
    /**
     * Edits an existing FindText entity.
     *
     * @Route("/{id}", name="findtext_update")
     * @Method("PUT")
     * @Template("AppBundle:FindText:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:FindText')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find FindText entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('findtext_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a FindText entity.
     *
     * @Route("/{id}", name="findtext_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AppBundle:FindText')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find FindText entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('findtext'));
    }

    /**
     * Creates a form to delete a FindText entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('findtext_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete', 'attr'=>array('class'=>'btn btn-sm btn-danger')))
            ->getForm()
        ;
    }
}