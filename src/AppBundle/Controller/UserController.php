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
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('AppBundle:User')->findAll();

        return array(
            'entities' => $entities,
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
        
        $service = $this->get('user_service');
        
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

        $form->add('submit', 'submit', array('label' => 'Update', 'attr' => array('class'=>'btn btn-sm btn-default')));

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
            ->add('submit', 'submit', array('label' => 'Delete', 'attr' => array('class' => 'btn btn-sm btn-danger')))
            ->getForm()
        ;
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
        //AVREQUEST
        $service->updatePermissions($entity, $formData['av_request'], $formData['av_request_previous']);
        //HOURS
        $service->updatePermissions($entity, $formData['hours'], $formData['hours_previous']);
        //STAFF
        $service->updatePermissions($entity, $formData['staff'], $formData['staff_previous']);
        
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
        //AVREQUEST
        $avrequest_permission = $service->generateViewEditDelete($user, 'ROLE_AV');
        //HOURS
        $hours_permission = $service->generateViewEditDelete($user, 'ROLE_HOURS');
        //HOURS
        $staff_permission = $service->generateViewEditDelete($user, 'ROLE_STAFF');
        
        $data = array();
        $form = $this->get('form.factory')->createNamedBuilder('user_permission_form', 'form', $data, array(
          'action' => $this->generateUrl('user_permissions_update', array('id'=>$user->getId())),
          'method' => 'PUT',
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
              'data' => $staff_permission
            ))
            ->add('staff_previous', 'hidden', array(
              //need to know the previous permission level so we can remove it and replace it with the new one.
              'data' => $staff_permission
            ))
            //user's ID (send along to createEditForm action)
            ->add('userId', 'hidden', array(
              'data' => $user->getId()
            ))
            ->getForm();
        
        return $form;
    }
   
}
