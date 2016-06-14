<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use AppBundle\Entity\User;
use AppBundle\Form\UserType;

/**
 * User controller.
 *
 * @Route("/user")
 */
class UserController extends Controller
{

    /**
     * Lists all User entities.
     *
     * @Route("/", name="user")
     * @Method("GET")
     * @Template()
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('AppBundle:User')->findAll();

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
     * Creates a new User entity.
     *
     * @Route("/", name="user_create")
     * @Method("POST")
     * @Template("AppBundle:User:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new User();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('user_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a User entity.
     *
     * @Route("/{id}", name="user_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:User')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find User entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing User entity.
     *
     * @Route("/{id}/edit", name="user_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:User')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find User entity.');
        }
        
        if(!is_null($entity->getStaffMember())){
          $staffMember = $entity->getStaffMember()->getId();
        } else {
          $staffMember = null;
        }
        
        $editForm = $this->createEditForm($entity, $staffMember);
        $deleteForm = $this->createDeleteForm($id);
        $permissionForm = $this->createPermissionForm($entity);
        $permissionForm->add('submit', 'submit', array('label' => 'Update Permissions', 'attr' => array('class'=>'btn btn-sm btn-default')));
        
        //$fos = $this->get('fos_user.util.user_manipulator');
        //$fos->addRole($entity, 'ROLE_SUPER_ADMIN');

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'permission_form' => $permissionForm->createView(),
        );
    }

    /**
    * Creates a form to edit a User entity.
    *
    * @param User $entity The entity
    * @param Staff $staffMember The staff member associated with the LDAP user object
    * 
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(User $entity, $staffMemberId = null)
    {
        $form = $this->createForm(new UserType($this->getDoctrine(), $staffMemberId), $entity, array(
            'action' => $this->generateUrl('user_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update Association', 'attr' => array('class'=>'btn btn-sm btn-warning')));

        return $form;
    }
    /**
     * Edits an existing User entity.
     *
     * @Route("/{id}", name="user_update")
     * @Method("PUT")
     * @Template("AppBundle:User:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $formData = $request->get('appbundle_user'); //the name of the form
        $staffMemberId = $formData['staffMember'];
        
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:User')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find User entity.');
        }
        
        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity, $staffMemberId);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('user_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a User entity.
     * 
     * @Route("/{id}", name="user_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AppBundle:User')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find User entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('user'));
    }

    /**
     * Creates a form to delete a User entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('user_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array(
                'label' => 'Delete', 
                'attr' => array(
                    'class' => 'btn btn-sm btn-danger',
                    'onclick' => 'return confirm("DO NOT DELETE LDAP USERS UNLESS YOU ARE POSITIVE THAT IS WHAT YOU WANT TO DO! Are you sure you want to delete this user?")'
                    )
                )
            )
            ->getForm()
        ;
    }
    
    /**
     * Displays a printer-friendly User entity.
     *
     * @Route("/{id}/print", name="user_print")
     * @Method("GET")
     * @Template()
     */
    public function printAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:User')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find User entity.');
        }

        return array(
            'entity'      => $entity,
        );
    }
    
    /**
     * Displays a form to edit an existing User entity.
     *
     * @Route("/{id}/editPermission", name="user_permissions_update")
     * @Method("PUT")
     * @Template("AppBundle:User:edit.html.twig")
     */
    public function updatePermissionsAction(Request $request){        
        $formData = $request->get('user_permission_form'); //the name of the form
        $userId = $formData['userId']; //LDAP user's ID
        
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:User')->find($userId);

        if(!is_null($entity->getStaffMember())){
          $staffMember = $entity->getStaffMember()->getId();
        } else {
          $staffMember = null;
        }
        
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find User entity.');
        }

        //update the user's permissions through the User Service
        $service = $this->get('user_service');
        //LIAISONSUBJECT
        $service->updatePermissions($entity, $formData['liaisonsubject'], $formData['liaisonsubject_previous']);
        //AVREQUEST
        $service->updatePermissions($entity, $formData['av_request'], $formData['av_request_previous']);
        //HOURS
        $service->updatePermissions($entity, $formData['hours'], $formData['hours_previous']);
        //STAFF
        $service->updatePermissions($entity, $formData['staff'], $formData['staff_previous']);
        //LIBRARY DEPARTMENTS
        $service->updatePermissions($entity, $formData['departments'], $formData['departments_previous']);
        //FEEDBACK
        $service->updatePermissions($entity, $formData['feedback'], $formData['feedback_previous']);
        //BOOK SEARCH REQUEST
        $service->updatePermissions($entity, $formData['book_search_request'], $formData['book_search_request_previous']);
        //EXTENDED PRIVILEGE REQUEST
        $service->updatePermissions($entity, $formData['extended_privileges'], $formData['extended_privileges_previous']);
        //MATERIAL PURCHASE REQUEST
        $service->updatePermissions($entity, $formData['material_purchase_request'], $formData['material_purchase_request_previous']);
        //MATERIAL RESERVE
        $service->updatePermissions($entity, $formData['material_reserve'], $formData['material_reserve_previous']);
        //NEWS
        $service->updatePermissions($entity, $formData['news'], $formData['news_previous']);
        //FINDTEXT+
        $service->updatePermissions($entity, $formData['findtext'], $formData['findtext_previous']);
        //(FACULTY) ROOM REQUEST
        $service->updatePermissions($entity, $formData['roomrequest'], $formData['roomrequest_previous']);
        //MEDIA LIBRARY
        $service->updatePermissions($entity, $formData['medialibrary'], $formData['medialibrary_previous']);
        //ANNUAL REPORTS
        $service->updatePermissions($entity, $formData['annualreport'], $formData['annualreport_previous']);
        //MONTHLY STATISTICS: GOVERNMENT DOCUMENTS
        $service->updatePermissions($entity, $formData['monthly_govdocs'], $formData['monthly_govdocs_previous']);
        
        //redirect to the Edit screen for the given user
        return $this->redirect($this->generateUrl('user_edit', array('id' => $userId)));
    }
    
    /**
     *  Each time you create a new entity that will be used as a form, you must:
     *  1. go to security.yml and create View, Edit, Delete roles
     *     1.a. Example: #AVRequests
     *                    ROLE_[entity]_VIEW:   ROLE_USER
     *                    ROLE_[entity]_EDIT:   ROLE_[entity]_VIEW
     *                    ROLE_[entity]_DELETE: ROLE_[entity]_EDIT
     *  2. Run the generateViewEditDelete() with the user and the prefix of the role (e.g. ROLE_AV)
     *  3. Create a new choice form field for the entity's permissions (follow pattern below for previously-created entities)
     *  4. Create new hidden form field that stores the entity's previous permission (result of step 2 will serve for data of both step 3 and 4)
     */
    public function createPermissionForm(User $user){
        $service = $this->get('user_service'); //AppBundle\Services\UserService
        
        //generate the VIEW, EDIT, DELETE permissions via User Service
        //LIAISONSUBJECT
        $liaisonsubject_permission = $service->generateViewEditDelete($user, 'ROLE_LIAISONSUBJECT');
        //AVREQUEST
        $avrequest_permission = $service->generateViewEditDelete($user, 'ROLE_AV');
        //HOURS
        $hours_permission = $service->generateViewEditDelete($user, 'ROLE_HOURS');
        //STAFF
        $staff_permission = $service->generateViewEditDelete($user, 'ROLE_STAFF');
        //LIBRARY DEPARTMENTS
        $department_permission = $service->generateViewEditDelete($user, 'ROLE_DEPARTMENTS');
        //FEEDBACK
        $feedback_permission = $service->generateViewEditDelete($user, 'ROLE_FEEDBACK');
        //BOOK SEARCH REQUEST
        $booksearch_permission = $service->generateViewEditDelete($user, 'ROLE_BOOKSEARCH');
        //EXTENDED PRIVILEGE REQUEST
        $extendedprivileges_permission = $service->generateViewEditDelete($user, 'ROLE_EXTENDEDPRIVILEGES');
        //MATERIAL PURCHASE REQUEST
        $materialpurchase_permission = $service->generateViewEditDelete($user, 'ROLE_MATERIALPURCHASE');
        //MATERIAL RESERVE
        $materialreserve_permission = $service->generateViewEditDelete($user, 'ROLE_MATERIALRESERVE');
        //NEWS
        $news_permission = $service->generateViewEditDelete($user, 'ROLE_NEWS');
        //FINDTEXT+
        $findtext_permission = $service->generateViewEditDelete($user, 'ROLE_FINDTEXT');
        //(FACULTY) ROOM REQUEST
        $roomrequest_permission = $service->generateViewEditDelete($user, 'ROLE_ROOMREQUEST');
        //MEDIA LIBRARY
        $medialibrary_permission = $service->generateViewEditDelete($user, 'ROLE_MEDIALIBRARY');
        //ANNUAL REPORTS
        $annualreport_permission = $service->generateViewEditDelete($user, 'ROLE_ANNUALREPORT');
        //MONTHLY STATISTICS: GOVERNMENT DOCUMENTS
        $monthly_govdocs_permission = $service->generateViewEditDelete($user, 'ROLE_MONTHLYGOVDOCS');
        
        $data = array();
        $form = $this->get('form.factory')->createNamedBuilder('user_permission_form', 'form', $data, array(
          'action' => $this->generateUrl('user_permissions_update', array('id'=>$user->getId())),
          'method' => 'PUT',
        ))
            //LIAISONSUBJECT
            ->add('liaisonsubject', 'choice', array(
              'choices' => array(
                'none'=>'None',
                'ROLE_LIAISONSUBJECT_VIEW'=> 'View',
                'ROLE_LIAISONSUBJECT_EDIT'=> 'Edit',
                'ROLE_LIAISONSUBJECT_DELETE'=> 'Delete'
              ),
              'multiple' => false,
              'expanded' => true,
              'required' => true,
              'label' => 'Liaison/Subject Management',
              'data' => $liaisonsubject_permission
            ))
            ->add('liaisonsubject_previous', 'hidden', array(
              //need to know the previous permission level so we can remove it and replace it with the new one.
              'data' => $liaisonsubject_permission
            ))
            //AVREQUEST
            ->add('av_request', 'choice', array(
              'choices' => array(
                'none'=>'None',
                'ROLE_AV_VIEW'=> 'View',
                'ROLE_AV_EDIT'=> 'Edit',
                'ROLE_AV_DELETE'=> 'Delete'
              ),
              'multiple' => false,
              'expanded' => true,
              'required' => true,
              'label' => 'Audio/Visual Requests',
              'data' => $avrequest_permission
            ))
            ->add('av_request_previous', 'hidden', array(
              //need to know the previous permission level so we can remove it and replace it with the new one.
              'data' => $avrequest_permission
            ))
            //HOURS
            ->add('hours', 'choice', array(
              'choices' => array(
                'none'=>'None',
                'ROLE_HOURS_VIEW'=> 'View',
                'ROLE_HOURS_EDIT'=> 'Edit',
                'ROLE_HOURS_DELETE'=> 'Delete'
              ),
              'multiple' => false,
              'expanded' => true,
              'required' => true,
              'label' => 'Hours Management',
              'data' => $hours_permission
            ))
            ->add('hours_previous', 'hidden', array(
              //need to know the previous permission level so we can remove it and replace it with the new one.
              'data' => $hours_permission
            ))
            //STAFF
            ->add('staff', 'choice', array(
              'choices' => array(
                'none'=>'None',
                'ROLE_STAFF_VIEW'=> 'View',
                'ROLE_STAFF_EDIT'=> 'Edit',
                'ROLE_STAFF_DELETE'=> 'Delete'
              ),
              'multiple' => false,
              'expanded' => true,
              'required' => true,
              'label' => 'Staff Management',
              'data' => $staff_permission
            ))
            ->add('staff_previous', 'hidden', array(
              //need to know the previous permission level so we can remove it and replace it with the new one.
              'data' => $staff_permission
            ))
            //LIBRARY DEPARTMENTS
            ->add('departments', 'choice', array(
              'choices' => array(
                'none'=>'None',
                'ROLE_DEPARTMENTS_VIEW'=> 'View',
                'ROLE_DEPARTMENTS_EDIT'=> 'Edit',
                'ROLE_DEPARTMENTS_DELETE'=> 'Delete'
              ),
              'multiple' => false,
              'expanded' => true,
              'required' => true,
              'label' => 'Departments Management',
              'data' => $department_permission
            ))
            ->add('departments_previous', 'hidden', array(
              //need to know the previous permission level so we can remove it and replace it with the new one.
              'data' => $department_permission
            ))
            //FEEDBACK
            ->add('feedback', 'choice', array(
              'choices' => array(
                'none'=>'None',
                'ROLE_FEEDBACK_VIEW'=> 'View',
                'ROLE_FEEDBACK_EDIT'=> 'Edit',
                'ROLE_FEEDBACK_DELETE'=> 'Delete'
              ),
              'multiple' => false,
              'expanded' => true,
              'required' => true,
              'label' => 'Feedback Management',
              'data' => $feedback_permission
            ))
            ->add('feedback_previous', 'hidden', array(
              //need to know the previous permission level so we can remove it and replace it with the new one.
              'data' => $feedback_permission
            ))
            //BOOK SEARCH REQUEST
            ->add('book_search_request', 'choice', array(
              'choices' => array(
                'none'=>'None',
                'ROLE_BOOKSEARCH_VIEW'=> 'View',
                'ROLE_BOOKSEARCH_EDIT'=> 'Edit',
                'ROLE_BOOKSEARCH_DELETE'=> 'Delete'
              ),
              'multiple' => false,
              'expanded' => true,
              'required' => true,
              'label' => 'Book Search Requests',
              'data' => $booksearch_permission
            ))
            ->add('book_search_request_previous', 'hidden', array(
              //need to know the previous permission level so we can remove it and replace it with the new one.
              'data' => $booksearch_permission
            ))
            //EXTENDED PRIVILEGES
            ->add('extended_privileges', 'choice', array(
              'choices' => array(
                'none'=>'None',
                'ROLE_EXTENDEDPRIVILEGES_VIEW'=> 'View',
                'ROLE_EXTENDEDPRIVILEGES_EDIT'=> 'Edit',
                'ROLE_EXTENDEDPRIVILEGES_DELETE'=> 'Delete'
              ),
              'multiple' => false,
              'expanded' => true,
              'required' => true,
              'label' => 'Extended Privilege Requests',
              'data' => $extendedprivileges_permission
            ))
            ->add('extended_privileges_previous', 'hidden', array(
              //need to know the previous permission level so we can remove it and replace it with the new one.
              'data' => $extendedprivileges_permission
            ))
            //MATERIAL PURCHASE REQUEST
            ->add('material_purchase_request', 'choice', array(
              'choices' => array(
                'none'=>'None',
                'ROLE_MATERIALPURCHASE_VIEW'=> 'View',
                'ROLE_MATERIALPURCHASE_EDIT'=> 'Edit',
                'ROLE_MATERIALPURCHASE_DELETE'=> 'Delete'
              ),
              'multiple' => false,
              'expanded' => true,
              'required' => true,
              'label' => 'Material Purchase Requests',
              'data' => $materialpurchase_permission
            ))
            ->add('material_purchase_request_previous', 'hidden', array(
              //need to know the previous permission level so we can remove it and replace it with the new one.
              'data' => $materialpurchase_permission
            ))
            //MATERIAL RESERVE
            ->add('material_reserve', 'choice', array(
              'choices' => array(
                'none'=>'None',
                'ROLE_MATERIALRESERVE_VIEW'=> 'View',
                'ROLE_MATERIALRESERVE_EDIT'=> 'Edit',
                'ROLE_MATERIALRESERVE_DELETE'=> 'Delete'
              ),
              'multiple' => false,
              'expanded' => true,
              'required' => true,
              'label' => 'Faculty Material Reserve Requests',
              'data' => $materialreserve_permission
            ))
            ->add('material_reserve_previous', 'hidden', array(
              //need to know the previous permission level so we can remove it and replace it with the new one.
              'data' => $materialreserve_permission
            ))
            //NEWS
            ->add('news', 'choice', array(
              'choices' => array(
                'none'=>'None',
                'ROLE_NEWS_VIEW'=> 'View',
                'ROLE_NEWS_EDIT'=> 'Edit',
                'ROLE_NEWS_DELETE'=> 'Delete'
              ),
              'multiple' => false,
              'expanded' => true,
              'required' => true,
              'label' => 'News Management',
              'data' => $news_permission
            ))
            ->add('news_previous', 'hidden', array(
              //need to know the previous permission level so we can remove it and replace it with the new one.
              'data' => $news_permission
            ))
            //FINDTEXT+
            ->add('findtext', 'choice', array(
              'choices' => array(
                'none'=>'None',
                'ROLE_FINDTEXT_VIEW'=> 'View',
                'ROLE_FINDTEXT_EDIT'=> 'Edit',
                'ROLE_FINDTEXT_DELETE'=> 'Delete'
              ),
              'multiple' => false,
              'expanded' => true,
              'required' => true,
              'label' => 'FindText+ Problems',
              'data' => $findtext_permission
            ))
            ->add('findtext_previous', 'hidden', array(
              //need to know the previous permission level so we can remove it and replace it with the new one.
              'data' => $findtext_permission
            ))
            //(FACULTY) ROOM REQUEST
            ->add('roomrequest', 'choice', array(
              'choices' => array(
                'none'=>'None',
                'ROLE_ROOMREQUEST_VIEW'=> 'View',
                'ROLE_ROOMREQUEST_EDIT'=> 'Edit',
                'ROLE_ROOMREQUEST_DELETE'=> 'Delete'
              ),
              'multiple' => false,
              'expanded' => true,
              'required' => true,
              'label' => 'Faculty Room Requests',
              'data' => $roomrequest_permission
            ))
            ->add('roomrequest_previous', 'hidden', array(
              //need to know the previous permission level so we can remove it and replace it with the new one.
              'data' => $roomrequest_permission
            ))
            //MEDIA LIBRARY
            ->add('medialibrary', 'choice', array(
              'choices' => array(
                'none'=>'None',
                'ROLE_MEDIALIBRARY_VIEW'=> 'View',
                'ROLE_MEDIALIBRARY_EDIT'=> 'Edit',
                'ROLE_MEDIALIBRARY_DELETE'=> 'Delete'
              ),
              'multiple' => false,
              'expanded' => true,
              'required' => true,
              'label' => 'Media Library',
              'data' => $medialibrary_permission
            ))
            ->add('medialibrary_previous', 'hidden', array(
              //need to know the previous permission level so we can remove it and replace it with the new one.
              'data' => $medialibrary_permission
            ))
            //ANNUAL REPORTS
            ->add('annualreport', 'choice', array(
              'choices' => array(
                'none'=>'None',
                'ROLE_ANNUALREPORT_VIEW'=> 'View',
                'ROLE_ANNUALREPORT_EDIT'=> 'Edit',
                'ROLE_ANNUALREPORT_DELETE'=> 'Delete'
              ),
              'multiple' => false,
              'expanded' => true,
              'required' => true,
              'label' => 'Annual Report Builder',
              'data' => $annualreport_permission
            ))
            ->add('annualreport_previous', 'hidden', array(
              //need to know the previous permission level so we can remove it and replace it with the new one.
              'data' => $annualreport_permission
            ))
            //MONTHLY STATISTICS: GOVERNMENT DOCUMENTS
            ->add('monthly_govdocs', 'choice', array(
              'choices' => array(
                'none'=>'None',
                'ROLE_MONTHLYGOVDOCS_VIEW'=> 'View',
                'ROLE_MONTHLYGOVDOCS_EDIT'=> 'Edit',
                'ROLE_MONTHLYGOVDOCS_DELETE'=> 'Delete'
              ),
              'multiple' => false,
              'expanded' => true,
              'required' => true,
              'label' => 'Monthly Stats: Government Documents',
              'data' => $monthly_govdocs_permission
            ))
            ->add('monthly_govdocs_previous', 'hidden', array(
              //need to know the previous permission level so we can remove it and replace it with the new one.
              'data' => $monthly_govdocs_permission
            ))
            //user's ID (send along to createEditForm action)
            ->add('userId', 'hidden', array(
              'data' => $user->getId()
            ))
            ->getForm();
        
        return $form;
    }
   
}
