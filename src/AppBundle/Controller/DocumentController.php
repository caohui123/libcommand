<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use AppBundle\Entity\Document;
use AppBundle\Form\DocumentType;
use Symfony\Component\HttpFoundation\Response;

/**
 * Document controller.
 *
 * @Route("/medialibrary")
 */
class DocumentController extends Controller
{

    /**
     * Lists all Document entities.
     *
     * @Route("/", name="medialibrary")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('AppBundle:Document')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    
    /**
     * @Route("/", name="medialibrary_upload")
     * @Method("POST")
     * @Template("AppBundle:Document:new.html.twig")
    */
    public function createAction(Request $request)
    {
       $entity = new Document();
       $form = $this->createCreateForm($entity);

       $form->handleRequest($request);

       if ($form->isValid()) {
           $em = $this->getDoctrine()->getManager();
           
           $em->persist($entity);
           $em->flush();

           return $this->redirect($this->generateUrl('medialibrary_show', array('id' => $entity->getId())));
       }

       return array('form' => $form->createView());
    }
    
    /**
     * @Route("/ajaxupload", name="medialibrary_upload_ajax")
     * @Method("POST")
     * @Template("AppBundle:Document:new.html.twig")
    */
    public function createAjaxAction(Request $request)
    {
        $requestData = $request->request->all();
        $requestFiles = $request->files->all();
      
        if("image/jpeg" == $requestFiles['appbundle_document']['file']->getMimeType()){
            $entity = new Document();
            $entity->setSubDir('news');
            $entity->setName($requestData['appbundle_document']['name']);
            $entity->setFile($requestFiles['appbundle_document']['file']);

            $em = $this->getDoctrine()->getManager();

            $em->persist($entity);
            $em->flush();

            return new Response('Image uploaded.', 201);
        } 
       
       return new Response('Image must be in .JPG format and under 30MB in size.', 400);
    }
    
    /**
     * Displays a form to create a new Document entity.
     *
     * @Route("/new", name="medialibrary_new")
     * @Method("GET")
     * @Template()
     * 
     */
    public function newAction()
    {
        $entity = new Document();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }
    
    /**
     * Creates a form to create a Document entity.
     *
     * @param Document $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Document $entity)
    {
        $form = $this->createForm(new DocumentType(), $entity, array(
            'action' => $this->generateUrl('medialibrary_upload'),
            'method' => 'POST',
        ));
        $form->add('subdir', 'choice', array(
           'choices' => array(
               'News Cover' => 'news',
               'Profile Photo' => 'profile'
           ),
           'choices_as_values' => true,
            'label' => 'Category'
        ));
        $form->add('submit', 'submit', array('label' => 'Upload'));

        return $form;
    }

    /**
     * Finds and displays a Document entity.
     *
     * @Route("/{id}", name="medialibrary_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Document')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Document entity.');
        }

        return array(
            'entity'      => $entity,
            'directory'   => '/' . $entity->getWebPath()
        );
    }
    
    /**
     * Displays a form to edit an existing Document entity.
     *
     * @Route("/{id}/edit", name="medialibrary_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Document')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Document entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'directory'   => '/' . $entity->getWebPath()
        );
    }

    /**
    * Creates a form to edit a Document entity.
    *
    * @param Document $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Document $entity)
    {
        $form = $this->createForm(new DocumentType(), $entity, array(
            'action' => $this->generateUrl('medialibrary_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));
        $form->add('subdir', 'hidden', array(
           'data' => $entity->getSubDir()
        ));
        $form->add('submit', 'submit', array('label' => 'Update', 'attr'=>array('class'=>'btn btn-sm btn-success')));

        return $form;
    }
    
    /**
     * Edits an existing Document entity.
     *
     * @Route("/{id}", name="medialibrary_update")
     * @Method("PUT")
     * @Template("AppBundle:Document:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Document')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Document entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('medialibrary_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    
    /**
     * Deletes a Document entity.
     *
     * @Route("/{id}", name="medialibrary_delete")
     * @Method("DELETE")
     * 
     * //@Secure(roles="ROLE_MEDIALIBRARY_DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AppBundle:Document')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find News entity.');
            }
            
            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('news'));
    }

    /**
     * Creates a form to delete a News entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('medialibrary_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array(
                'label' => 'Delete', 
                'attr' => array(
                    'class' => 'btn btn-sm btn-danger',
                    'onclick' => 'return confirm("Are you sure you want to delete this document?")'
                    )
                )
            )
            ->getForm()
        ;
    }
    
    /**
     * Displays a printer-friendly Document entity.
     *
     * @Route("/{id}/print", name="medialibrary_print")
     * @Method("GET")
     * @Template()
     */
    public function printAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Document')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Document entity.');
        }

        return array(
            'entity'      => $entity,
            'directory'   => '/' . $entity->getWebPath()
        );
    }
    
}
