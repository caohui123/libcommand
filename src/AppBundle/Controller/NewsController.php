<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use AppBundle\Entity\News;
use AppBundle\Form\NewsType;
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
        $entity = new News();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $entity->setAuthor($this->get('security.context')->getToken()->getUser()); //set the author as the user who made the entity
            
            $files = $request->files->all();
            $photo = $files['appbundle_news']['photo'];
            
            // Generate a unique name for the file before saving it
            $fileName = md5(uniqid()).'.'.$photo->guessExtension();
            
            // Move the photo to the directory where they are stored
            $photosDir = $this->container->getParameter('kernel.root_dir').'/../web/uploads/news';
            $photo->move($photosDir, $fileName);
            
            // Update the 'photo' property to store the file name instead of its contents
            $entity->setPhoto($fileName);
            
            $em = $this->getDoctrine()->getManager();
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

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
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
        
        $imageService = $this->get('image_service');
        $images = $imageService->findDirectoryImages($this->get('kernel')->getRootDir() . '/../web/uploads/news');

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'images' => $images
        );
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
        var_dump($requestData);
        /*$em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:News')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find News entity.');
        }
        
        //news photo directory
        $photosDir = $this->container->getParameter('kernel.root_dir').'/../web/uploads/news/';
        $existingPhotoName = $entity->getPhoto();

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            
            //erase an emergency level (string) if the News is no longer marked as an emergency
            if(0 == $entity->getEmergency() && null !== $entity->getEmergencyLevel()){
                $entity->setEmergencyLevel(null);
            }
            
            $files = $request->files->all();
            //check to see if there was an existing photo
            if($existingPhotoName != ''){
              $photoPath = $photosDir . $existingPhotoName;
            } 
            //if main submit button was clicked
            if($editForm->get('submit')->isClicked()){

              //check to see if there is a new photo
              if($files['appbundle_news']['photo'] != null){
                //new photo? add it to the profile directory.
                $photo = $files['appbundle_news']['photo'];
                $fileName = md5(uniqid()).'.'.$photo->getClientOriginalExtension();
                $photo->move($photosDir, $fileName);
                $entity->setPhoto($fileName);
              }
             
              //if there is an existing photo but not a new one, retain the old file's name in the database
              if($files['appbundle_news']['photo'] == null && $existingPhotoName != ''){
                $entity->setPhoto($existingPhotoName); //retain old photo name
              }
            } 
            
            //if delete photo submit button is clicked
            if($editForm->has('deletePhotoSubmit') && $editForm->get('deletePhotoSubmit')->isClicked()){
              if(isset($photoPath) && file_exists($photoPath)){
                //remove the image from the directory
                $fs = new FileSystem();
                $fs->remove($photoPath);
              }
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
         
         */
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
