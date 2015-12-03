<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use AppBundle\Entity\AvRequest;
use AppBundle\Form\AvRequestType;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Acl\Domain\ObjectIdentity;
use Symfony\Component\Security\Acl\Domain\UserSecurityIdentity;
use Symfony\Component\Security\Acl\Permission\MaskBuilder;

class AvRequestController extends Controller
{
    /**
     * @Rest\View()
     */
    public function getAvrequestsAction(Request $request){
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('AppBundle:AvRequest')->findAll();
        
        $serializer = $this->container->get('serializer');
        $serialized = $serializer->serialize($entities, 'json');
        $response = new Response($serialized, 200, array('Content-Type' => 'application/json'));
        
        return $response;
    }
    public function getAvrequestAction($id){
        
    }
    public function postAvrequestAction(Request $request){
        $entity = new AvRequest();

        $form = $this->get('form.factory')->createNamed('', new AvRequestType(), $entity);
        $form->handleRequest($request);
        
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            $serializer = $this->get('serializer');
            $serialized = $serializer->serialize($entity, 'json');
            
            
            // creating the ACL
            $aclProvider = $this->get('security.acl.provider');
            $objectIdentity = ObjectIdentity::fromDomainObject($entity);
            $acl = $aclProvider->createAcl($objectIdentity);

            // retrieving the security identity of the currently logged-in user
            $tokenStorage = $this->get('security.token_storage');
            $users = $em->getRepository('AppBundle:User')->findAll();
            
            //$tokenStorage->getToken()->getUser();
            foreach($users as $user){
              $securityIdentity = UserSecurityIdentity::fromAccount($user);
              
              // grant owner access based on owner's overall permissions for this type of entity
              $acl->insertObjectAce($securityIdentity, 0);
              $aclProvider->updateAcl($acl);
            }

            return new Response($serialized, 201);
        }

        return new JsonResponse(array(
            'errors' => $this->getFormErrors($form)
        ));
    }
    protected function getFormErrors(\Symfony\Component\Form\Form $form)
    {
        $errors = array();

        foreach ($form->getErrors() as $error) {
            $errors['global'][] = $error->getMessage();
        }

        foreach ($form as $field) {
            if (!$field->isValid()) {
                foreach ($field->getErrors() as $error) {
                    $errors['fields'][$field->getName()] = $error->getMessage();
                }
            }
        }

        return $errors;
    }
    
    /**
     * NON REST FUNCTIONS
     */
    
    /**
     * @Route("/avrequest", name="avrequests")
     * @Template()
     */
    public function indexAction(){
      $em = $this->getDoctrine()->getManager();

      $entities = $em->getRepository('AppBundle:AvRequest')->findAll();

      return array(
          'entities' => $entities,
      );
    }
    
    /**
     * Finds and displays an AvRequest entity.
     *
     * @Route("/avrequest/{id}", name="avrequest_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:AvRequest')->find($id);
        
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find AvRequest entity show.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }
    
    /**
    * Creates a form to edit a AvRequest entity.
    *
    * @param AvRequest $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(AvRequest $entity)
    {
        $form = $this->createForm(new AvRequestType(), $entity, array(
            'action' => $this->generateUrl('avrequest_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    
    /**
     * Displays a form to edit an existing AvRequest entity.
     *
     * @Route("/avrequest/{id}/edit", name="avrequest_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
      $em = $this->getDoctrine()->getManager();
      
      $entity = $em->getRepository('AppBundle:AvRequest')->find($id);
      
      $service = $this->get('user_service');
      $user = $em->getRepository('AppBundle:User')->find(1);
      $service->editPermission($user, 'AppBundle:AvRequest', MaskBuilder::MASK_EDIT);
      
      // check for edit access
      $authorizationChecker = $this->get('security.authorization_checker');
      if (false === $authorizationChecker->isGranted('EDIT', $entity)) {
          throw new AccessDeniedException();
      }
      
      if (!$entity) {
          throw $this->createNotFoundException('Unable to find AvRequest entity.');
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
     * Edits an existing AvRequest entity.
     *
     * @Route("/avrequest/{id}", name="avrequest_update")
     * @Method("PUT")
     * @Template("AppBundle:AvRequest:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:AvRequest')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find AvRequest entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('admin_staffareas_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    
    /**
     * Deletes a AvRequest entity.
     *
     * @Route("/avrequest/{id}", name="avrequest_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AppBundle:AvRequest')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find AvRequest entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('admin_staffareas'));
    }
    
    /**
     * Creates a form to delete a AvRequest entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('avrequest_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete', 'attr' => array('class' => 'btn btn-sm btn-danger')))
            ->getForm()
        ;
    }
}
