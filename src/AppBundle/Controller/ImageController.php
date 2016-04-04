<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use AppBundle\Entity\Image;
use AppBundle\Form\ImageType;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Controller\Interfaces\DocumentControllerInterface;
use JMS\SecurityExtraBundle\Annotation\Secure;

/**
 * Document controller.
 *
 * @Route("/medialibrary/image")
 */
class ImageController extends Controller implements DocumentControllerInterface
{

    /**
     * Lists all Document entities.
     *
     * @Route("/", name="medialibrary_image")
     * @Method("GET")
     * @Template()
     * 
     * @Secure(roles="ROLE_MEDIALIBRARY_VIEW")
     */
    public function indexAction(Request $request)
    { 
        $em = $this->getDoctrine()->getManager();
        
        $entities = $em->getRepository('AppBundle:Image')->findBy(array(), array('created' => 'DESC'));
        
        $requestData = $request->query->all();
        isset($requestData['maxItems']) ? $maxItems = $requestData['maxItems'] : $maxItems = 10;
      
        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $entities, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            $maxItems/*limit per page*/
        );

        return array(
            'pagination' => $pagination
        );
    }
    
    /**
     * @Route("/", name="medialibrary_image_upload")
     * @Method("POST")
     * @Template("AppBundle:Image:new.html.twig")
     * 
     * @Secure(roles="ROLE_MEDIALIBRARY_EDIT")
    */
    public function createAction(Request $request)
    {
       $entity = new Image();
       $form = $this->createCreateForm($entity);

       $form->handleRequest($request);

       if ($form->isValid()) {
           $em = $this->getDoctrine()->getManager();
           
           $em->persist($entity);
           $em->flush();

           return $this->redirect($this->generateUrl('medialibrary_image_show', array('id' => $entity->getId())));
       }

       return array('form' => $form->createView());
    }
    
    /**
     * @Route("/ajaxupload", name="medialibrary_upload_ajax")
     * @Method("POST")
     * @Template("AppBundle:Image:new.html.twig")
     * 
     * @Secure(roles="ROLE_MEDIALIBRARY_EDIT, ROLE_NEWS_EDIT")
    */
    public function createAjaxAction(Request $request)
    {
        $requestData = $request->request->all();
        $requestFiles = $request->files->all();
      
        if("image/jpeg" == $requestFiles['appbundle_image']['file']->getMimeType()){
            $entity = new Image();
            $entity->setSubDir('news');
            $entity->setName($requestData['appbundle_image']['name']);
            $entity->setFile($requestFiles['appbundle_image']['file']);

            $em = $this->getDoctrine()->getManager();

            $em->persist($entity);
            $em->flush();

            return new Response('Image uploaded.', 201);
        } 
       
       return new Response('Image must be in .JPG format and under 30MB in size.', 400);
    }
    
    /**
     * Displays a form to create a new Image entity.
     *
     * @Route("/new", name="medialibrary_image_new")
     * @Method("GET")
     * @Template()
     * 
     * @Secure(roles="ROLE_MEDIALIBRARY_EDIT")
     */
    public function newAction()
    {
        $entity = new Image();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }
    
    /**
     * Creates a form to create a Image entity.
     *
     * @param Document $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Image $entity)
    {
        $form = $this->createForm(new ImageType(), $entity, array(
            'action' => $this->generateUrl('medialibrary_image_upload'),
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
     * Finds and displays a Image entity.
     *
     * @Route("/{id}", name="medialibrary_image_show")
     * @Method("GET")
     * @Template()
     * 
     * @Secure(roles="ROLE_MEDIALIBRARY_VIEW")
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Image')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Image entity.');
        }

        return array(
            'entity'      => $entity,
            'directory'   => '/' . $entity->getWebPath()
        );
    }
    
    /**
     * Displays a form to edit an existing Image entity.
     *
     * @Route("/{id}/edit", name="medialibrary_image_edit")
     * @Method("GET")
     * @Template()
     * 
     * @Secure(roles="ROLE_MEDIALIBRARY_EDIT")
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Image')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Image entity.');
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
    * Creates a form to edit a Image entity.
    *
    * @param Image $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Image $entity)
    {
        $form = $this->createForm(new ImageType(), $entity, array(
            'action' => $this->generateUrl('medialibrary_image_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));
        $form->add('subdir', 'hidden', array(
           'data' => $entity->getSubDir()
        ));
        $form->add('submit', 'submit', array('label' => 'Update', 'attr'=>array('class'=>'btn btn-sm btn-success')));

        return $form;
    }
    
    /**
     * Edits an existing Image entity.
     *
     * @Route("/{id}", name="medialibrary_image_update")
     * @Method("PUT")
     * @Template("AppBundle:Image:edit.html.twig")
     * 
     * @Secure(roles="ROLE_MEDIALIBRARY_EDIT")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Image')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Image entity.');
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
     * Deletes an Image entity.
     *
     * @Route("/{id}", name="medialibrary_image_delete")
     * @Method("DELETE")
     * 
     * @Secure(roles="ROLE_MEDIALIBRARY_DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AppBundle:Image')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Image entity.');
            }
            
            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('medialibrary_image'));
    }

    /**
     * Creates a form to delete an Image entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('medialibrary_image_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array(
                'label' => 'Delete', 
                'attr' => array(
                    'class' => 'btn btn-sm btn-danger',
                    'onclick' => 'return confirm("Are you sure you want to delete this image?")'
                    )
                )
            )
            ->getForm()
        ;
    }
    
    /**
     * Displays a printer-friendly Image entity.
     *
     * @Route("/{id}/print", name="medialibrary_image_print")
     * @Method("GET")
     * @Template()
     * 
     * @Secure(roles="ROLE_MEDIALIBRARY_VIEW")
     */
    public function printAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Image')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Image entity.');
        }

        return array(
            'entity'      => $entity,
            'directory'   => '/' . $entity->getWebPath()
        );
    }
    
}
