<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use AppBundle\Entity\Staff;
use AppBundle\Form\StaffType;
use JMS\SecurityExtraBundle\Annotation\Secure;
use AppBundle\Entity\Image;
use AppBundle\Form\ImageType;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

/**
 * Staff controller.
 *
 * @Route("/staff")
 */
class StaffController extends Controller
{

    /**
     * Lists all Staff entities.
     *
     * @Route("/", name="staff")
     * @Method("GET")
     * @Template()
     * 
     * @Secure(roles="ROLE_STAFF_VIEW")
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('AppBundle:Staff')->findBy(array(), array('lastName'=>'ASC'));
        
        //Staff search form.
        $staff_search = $this->createSearchForm();

        $requestData = $request->query->all();
        isset($requestData['maxItems']) ? $maxItems = $requestData['maxItems'] : $maxItems = 10;
      
        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $entities, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            $maxItems/*limit per page*/
        );

        return array(
            'pagination' => $pagination,
            'staff_search_form' => $staff_search->createView(),
        );
    }
    /**
     * Creates a new Staff entity.
     *
     * @Route("/", name="staff_create")
     * @Method("POST")
     * @Template("AppBundle:Staff:new.html.twig")
     * 
     * @Secure(roles="ROLE_STAFF_EDIT")
     */
    public function createAction(Request $request)
    {
        $requestData = $request->request->all();

        $entity = new Staff();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            
            if(isset($requestData['profile_image'])){
                //Just to be sure, check that the image (Image entity) exists
                $image = $em->getRepository('AppBundle:Image')->find($requestData['profile_image']);
          
                if(!$image){
                
                }
                $entity->setImage($image);
            }
            
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('staff_show', array('id' => $entity->getId())));
        }
        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a Staff entity.
     *
     * @param Staff $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Staff $entity)
    {
        $form = $this->createForm(new StaffType(), $entity, array(
            'action' => $this->generateUrl('staff_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Staff entity.
     *
     * @Route("/new", name="staff_new")
     * @Method("GET")
     * @Template()
     * 
     * @Secure(roles="ROLE_STAFF_EDIT")
     */
    public function newAction()
    {
        $entity = new Staff();
        $form   = $this->createCreateForm($entity);

        $image = new Image();
        $imageForm = $this->createImageForm($image);
        
        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
            'image_form' => $imageForm->createView(),
        );
    }

    /**
     * Finds and displays a Staff entity.
     *
     * @Route("/{id}", name="staff_show")
     * @Method("GET")
     * @Template()
     * 
     * @Secure(roles="ROLE_STAFF_VIEW")
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Staff')->find($id);
        
        $ldapUser = $em->getRepository('AppBundle:User')->findOneBy(array('staffMember'=>$id));
        if($ldapUser == null){
          $ldapUser = "No associated LDAP User";
        } 

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Staff entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'ldap_user'   => $ldapUser,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Staff entity.
     *
     * @Route("/{id}/edit", name="staff_edit")
     * @Method("GET")
     * @Template()
     * 
     * @Secure(roles="ROLE_STAFF_EDIT")
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Staff')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Staff entity.');
        }
         
        $ldap_user = $em->getRepository('AppBundle:User')->findOneBy( array('staffMember'=>$entity) );
        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);
        
        $image = new Image();
        $imageForm = $this->createImageForm($image);
        
        return array(
            'entity'      => $entity,
            'ldap_user'   => $ldap_user,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'image_form'  => $imageForm->createView(),
        );
    }

    /**
    * Creates a form to edit a Staff entity.
    *
    * @param Staff $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Staff $entity)
    {
        $form = $this->createForm(new StaffType(), $entity, array(
            'action' => $this->generateUrl('staff_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));
        $form->add('submit', 'submit', array('label' => 'Update', 'attr' => array('class' => 'btn btn-sm btn-success')));

        return $form;
    }
    /**
     * Edits an existing Staff entity.
     *
     * @Route("/{id}", name="staff_update")
     * @Method("PUT")
     * @Template("AppBundle:Staff:edit.html.twig")
     * 
     * @Secure(roles="ROLE_STAFF_EDIT")
     */
    public function updateAction(Request $request, $id)
    {
        $requestData = $request->request->all();
        
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Staff')->find($id);
        
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Staff entity.');
        }
        
        $image = new Image();
        $imageForm = $this->createImageForm($image);
            
        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);
        
        if ($editForm->isValid()) {
            $requestData = $request->request->all();
            
            if(isset($requestData['profile_image'])){
                //Just to be sure, check that the image (Image entity) exists
                $image = $em->getRepository('AppBundle:Image')->find($requestData['profile_image']);

                if(!$image){

                }
                $entity->setImage($image);
            }

            //if delete photo submit button is clicked
            if($editForm->has('removeProfilePhotoSubmit') && $editForm->get('removeProfilePhotoSubmit')->isClicked()){
                $entity->setImage(null);
            }

             
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('staff_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'image_form'  => $imageForm->createView(),
        );
    }
    
    /**
    * Creates a form to create an Image entity.
    *
    * @param Image $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createImageForm(Image $entity)
    {
        $form = $this->createForm(new ImageType(), $entity, array(
            'action' => $this->generateUrl('medialibrary_image_upload'),
            'method' => 'POST',
            'attr' => array(
                'id' => 'image_upload_form'
            )
        ));
        $form->add('subdir', 'hidden', array(
            'data' => 'profile'
        ));
        $form->add('newimage_ajax', 'submit', array('label' => 'Upload', 'attr' => array('class'=>'btn btn-sm btn-info')));

        return $form;
    }
    
    /**
     * Displays a list of thumbnails of all images currently in the /uploads/profile directory.
     *
     * @Route("/image/thumbnails", name="staff_image_thumbnails")
     * @Method("GET")
     * @Template("AppBundle:Staff:thumbnails.html.twig")
     */
    public function imageThumbnailsAction(){
        $em = $this->getDoctrine()->getManager();
        
        $entities = $em->getRepository('AppBundle:Image')->findBy(array('subdir' => 'profile'), array('created' => 'DESC'));
        
        if(!$entities){
            throw $this->createNotFoundException('No Image entities found.');
        }

        return $this->render('AppBundle:Staff:thumbnails.html.twig', array(
            'entities' => $entities
        ));
    }
    
    /**
     * Deletes a Staff entity.
     *
     * @Route("/{id}", name="staff_delete")
     * @Method("DELETE")
     * 
     * @Secure(roles="ROLE_STAFF_DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AppBundle:Staff')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Staff entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('staff'));
    }

    /**
     * Creates a form to delete a Staff entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('staff_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array(
                'label' => 'Delete', 
                'attr' => array(
                    'class' => 'btn btn-sm btn-danger',
                    'onclick' => 'return confirm("WARNING! You should not delete a staff member unless it is absolutely necessary. Doing so affects any record associated with this staff member. Are you sure you still want to delete this staff member?")'
                    )
                )
            )
            ->getForm()
        ;
    }
    
    /**
     * Displays a printer-friendly Staff entity.
     *
     * @Route("/{id}/print", name="staff_print")
     * @Method("GET")
     * @Template()
     * 
     * @Secure(roles="ROLE_STAFF_VIEW")
     */
    public function printAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Staff')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Staff entity.');
        }
         
        $ldap_user = $em->getRepository('AppBundle:User')->findOneBy( array('staffMember'=>$entity) );
        
        return array(
            'entity'      => $entity,
            'ldap_user'   => $ldap_user,
        );
    }
    
    /**
     * AJAX search Staff last name by a string.
     *
     * @Route("/search/autocomplete", name="staff_search")
     * @Method("GET")
     * 
     * @Secure(roles="ROLE_STAFF_VIEW")
     */
    public function searchAction()
    {   
        $staff_service = $this->get('staff_service');
        $matches = $staff_service->getAllStaffForAutocomplete();
        
        $response = new JsonResponse($matches, 200);
        
        return $response;
    }
    
    /**
     * Creates a form to search Staff entities by last name.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    public function createSearchForm()
    {
        return $this->createFormBuilder(null, array('attr'=> array('id' => 'staff_search')))
            ->setMethod('GET')
            ->add('name', 'text', array(
                'label' => 'Search Staff by Name',
                'attr'  => array(
                        'class' => 'search_staff_input_box'
                    )
                )
            )
            ->getForm()
        ;
    }
}
