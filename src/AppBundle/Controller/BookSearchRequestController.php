<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use AppBundle\Entity\BookSearchRequest;
use AppBundle\Form\BookSearchRequestType;

/**
 * BookSearchRequest controller.
 *
 * @Route("/booksearchrequest")
 */
class BookSearchRequestController extends Controller
{

    /**
     * Lists all BookSearchRequest entities.
     *
     * @Route("/", name="booksearchrequest")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('AppBundle:BookSearchRequest')->findBy(array(), array('created' => 'ASC'));

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new BookSearchRequest entity.
     *
     * //@Route("/", name="booksearchrequest_create")
     * //@Method("POST")
     * //@Template("AppBundle:BookSearchRequest:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new BookSearchRequest();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('booksearchrequest_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a BookSearchRequest entity.
     *
     * @param BookSearchRequest $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(BookSearchRequest $entity)
    {
        $form = $this->createForm(new BookSearchRequestType(), $entity, array(
            'action' => $this->generateUrl('booksearchrequest_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new BookSearchRequest entity.
     *
     * //@Route("/new", name="booksearchrequest_new")
     * //@Method("GET")
     * //@Template()
     */
    public function newAction()
    {
        $entity = new BookSearchRequest();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a BookSearchRequest entity.
     *
     * @Route("/{id}", name="booksearchrequest_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:BookSearchRequest')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find BookSearchRequest entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing BookSearchRequest entity.
     *
     * @Route("/{id}/edit", name="booksearchrequest_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:BookSearchRequest')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find BookSearchRequest entity.');
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
    * Creates a form to edit a BookSearchRequest entity.
    *
    * @param BookSearchRequest $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(BookSearchRequest $entity)
    {
        $form = $this->createForm(new BookSearchRequestType(), $entity, array(
            'action' => $this->generateUrl('booksearchrequest_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update WITHOUT Emailing Patron', 'attr'=>array('class' => 'btn btn-sm btn-success')));

        return $form;
    }
    /**
     * Edits an existing BookSearchRequest entity.
     *
     * @Route("/{id}", name="booksearchrequest_update")
     * @Method("PUT")
     * @Template("AppBundle:BookSearchRequest:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:BookSearchRequest')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find BookSearchRequest entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            //if "submitPatronConfirm" button is clicked, email the patron the status of the request
            if($editForm->get('submitPatronConfirm')->isClicked()){
              $message = \Swift_Message::newInstance()
                  ->setSubject('EMU Library Book Request Status Update')
                  ->setFrom('bookrequest@emulibrary.com')
                  ->setTo($entity->getPatronEmail())
                  ->setBody(
                      $this->renderView(
                          'AppBundle:BookSearchRequest/Emails:patronresponse.html.twig',
                          array('entity' => $entity)
                      ),
                      'text/html'
                  )
                ;
                $this->get('mailer')->send($message);
                
                $entity->setIsPatronEmailed(true);
                $entity->setPatronEmailed(new \DateTime());
                $em->persist($entity);
            }
            
            $em->flush();

            return $this->redirect($this->generateUrl('booksearchrequest_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a BookSearchRequest entity.
     *
     * @Route("/{id}", name="booksearchrequest_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AppBundle:BookSearchRequest')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find BookSearchRequest entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('booksearchrequest'));
    }

    /**
     * Creates a form to delete a BookSearchRequest entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('booksearchrequest_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete', 'attr'=>array('class' => 'btn btn-sm btn-danger')))
            ->getForm()
        ;
    }
}
