<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use AppBundle\Entity\News;
use AppBundle\Form\NewsType;
use AppBundle\Entity\Document;
use AppBundle\Form\DocumentType;
use Hateoas\HateoasBuilder;
use Hateoas\Representation\PaginatedRepresentation;
use Hateoas\Representation\CollectionRepresentation;
use JMS\SecurityExtraBundle\Annotation\Secure;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Filesystem\Filesystem;

/**
 * News controller.
 *
 * @Route("/news")
 */
class NewsController extends Controller
{
    /**
     * Lists all News entities.
     *
     * @Route("/", name="news")
     * @Method("GET")
     * @Template()
     * 
     * @Secure(roles="ROLE_NEWS_VIEW")
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('AppBundle:News')->findBy(array(), array('created' => 'DESC'));
        
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
     * Creates a new News entity.
     *
     * @Route("/", name="news_create")
     * @Method("POST")
     * @Template("AppBundle:News:new.html.twig")
     * 
     * @Secure(roles="ROLE_NEWS_EDIT")
     */
    public function createAction(Request $request)
    {
        $requestData = $request->request->all();
        
        $entity = new News();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            
            $entity->setAuthor($this->get('security.context')->getToken()->getUser()); //set the author as the user who made the entity
            
            if(isset($requestData['cover_image'])){
                //Just to be sure, check that the image (Document entity) exists
                $image = $em->getRepository('AppBundle:Document')->find($requestData['cover_image']);
          
                if(!$image){
                
                }
                $entity->setImage($image);
            }
            
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('news_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a News entity.
     *
     * @param News $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(News $entity)
    {
        $form = $this->createForm(new NewsType(), $entity, array(
            'action' => $this->generateUrl('news_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new News entity.
     *
     * @Route("/new", name="news_new")
     * @Method("GET")
     * @Template()
     * 
     * @Secure(roles="ROLE_NEWS_EDIT")
     */
    public function newAction()
    {
        $entity = new News();
        $form   = $this->createCreateForm($entity);
        
        $image = new Document();
        $imageForm = $this->createImageForm($image);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
            'image_form' => $imageForm->createView(),
        );
    }
    
    /**
     * Displays a list of thumbnails of all images currently in the /uploads/news directory.
     *
     * @Route("/thumbnails", name="news_image_thumbnails")
     * @Method("GET")
     * @Template("AppBundle:News:thumbnails.html.twig")
     */
    public function imageThumbnailsAction(){
        $em = $this->getDoctrine()->getManager();
        
        $entities = $em->getRepository('AppBundle:Document')->findBy(array('subdir' => 'news'), array('created' => 'DESC'));
        
        if(!$entities){
            throw $this->createNotFoundException('No News entities found.');
        }

        return $this->render('AppBundle:News:thumbnails.html.twig', array(
            'entities' => $entities
        ));
    }

    /**
     * Finds and displays a News entity.
     *
     * @Route("/{id}", name="news_show")
     * @Method("GET")
     * @Template()
     * 
     * @Secure(roles="ROLE_NEWS_VIEW")
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:News')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find News entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing News entity.
     *
     * @Route("/{id}/edit", name="news_edit")
     * @Method("GET")
     * @Template()
     * 
     * @Secure(roles="ROLE_NEWS_EDIT")
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:News')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find News entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);
        
        $image = new Document();
        $imageForm = $this->createImageForm($image);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'image_form' => $imageForm->createView(),
        );
    }
    
    /**
    * Creates a form to create a Document entity.
    *
    * @param Document $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createImageForm(Document $entity)
    {
        $form = $this->createForm(new DocumentType(), $entity, array(
            'action' => $this->generateUrl('medialibrary_upload'),
            'method' => 'POST',
            'attr' => array(
                'id' => 'image_upload_form'
            )
        ));
        $form->add('subdir', 'hidden', array(
            'data' => 'news'
        ));
        $form->add('newimage_ajax', 'submit', array('label' => 'Upload', 'attr' => array('class'=>'btn btn-sm btn-info')));

        return $form;
    }

    /**
    * Creates a form to edit a News entity.
    *
    * @param News $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(News $entity)
    {
        $form = $this->createForm(new NewsType(), $entity, array(
            'action' => $this->generateUrl('news_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update', 'attr' => array('class'=>'btn btn-sm btn-success')));

        return $form;
    }
    /**
     * Edits an existing News entity.
     *
     * @Route("/{id}", name="news_update")
     * @Method("PUT")
     * @Template("AppBundle:News:edit.html.twig")
     * 
     * @Secure(roles="ROLE_NEWS_EDIT")
     */
    public function updateAction(Request $request, $id)
    {
        $requestData = $request->request->all();
        
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:News')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find News entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            
            //erase an emergency level (string) if the News is no longer marked as an emergency
            if(0 == $entity->getEmergency() && null !== $entity->getEmergencyLevel()){
                $entity->setEmergencyLevel(null);
            }
          
            if(isset($requestData['cover_image'])){
                //Just to be sure, check that the image (Document entity) exists
                $image = $em->getRepository('AppBundle:Document')->find($requestData['cover_image']);
          
                if(!$image){
                
                }
                $entity->setImage($image);
            }

            //if delete photo submit button is clicked
            if($editForm->has('removeCoverPhotoSubmit') && $editForm->get('removeCoverPhotoSubmit')->isClicked()){
                $entity->setImage(null);
            }
            
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('news_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a News entity.
     *
     * @Route("/{id}", name="news_delete")
     * @Method("DELETE")
     * 
     * @Secure(roles="ROLE_NEWS_DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AppBundle:News')->find($id);

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
            ->setAction($this->generateUrl('news_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array(
                'label' => 'Delete', 
                'attr' => array(
                    'class' => 'btn btn-sm btn-danger',
                    'onclick' => 'return confirm("Are you sure you want to delete this news story?")'
                    )
                )
            )
            ->getForm()
        ;
    }
    
    /**
     * Displays a printer-friendly News entity.
     *
     * @Route("/{id}/print", name="news_print")
     * @Method("GET")
     * @Template()
     * 
     * @Secure(roles="ROLE_NEWS_VIEW")
     */
    public function printAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:News')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find News entity.');
        }

        return array(
            'entity'      => $entity,
        );
    }
    
    
}
