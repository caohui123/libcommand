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
use AppBundle\Entity\AvRequestEvent;
use JMS\SecurityExtraBundle\Annotation\Secure;

/**
 * AvRequest Controller.
 * 
 * @Route("/avrequest")
 */
class AvRequestController extends Controller
{
    /**
     * @Route("/", name="avrequests")
     * @Method("GET")
     * @Template()
     * 
     * @Secure(roles="ROLE_AV_VIEW")
     */
    public function indexAction(){
      $em = $this->getDoctrine()->getManager();

      $entities = $em->getRepository('AppBundle:AvRequest')->findBy(array(), array('created'=>'DESC'));

      return array(
          'entities' => $entities,
      );
    }
    
    /**
     * Creates a new Department entity.
     * --ROUTE COMMENTED OUT. THIS SHOULD ONLY BE AVAILABLE THROUGH THE REST API. USE FOR TESTING ONLY!--
     * //@Route("/", name="avrequest_create")
     * //@Method("POST")
     * //@Template("AppBundle:AvRequest:new.html.twig")
     * 
     * //@Secure(roles="ROLE_AV_EDIT")
     */
    public function createAction(Request $request)
    {
        $entity = new AvRequest();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            
            //set request ID on any equipment quantity fields
            $equipment = $entity->getEquipment()->toArray();
            foreach($equipment as $eq){
              $eq->setAvRequest($entity);
              $em->persist($eq);
            }
            $em->flush();

            return $this->redirect($this->generateUrl('avrequest_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }
    
    /**
     * Creates a form to create a AvRequest entity.
     *
     * @param AvRequest $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(AvRequest $entity)
    {
        $form = $this->createForm(new AvRequestType(), $entity, array(
            'action' => $this->generateUrl('avrequest_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new AvRequest entity.
     * --ROUTE COMMENTED OUT. THIS SHOULD ONLY BE AVAILABLE THROUGH THE REST API. USE FOR TESTING ONLY!--
     * //@Route("/new", name="avrequest_new")
     * //@Method("GET")
     * //@Template()
     * 
     * //@Secure(roles="ROLE_AV_EDIT")
     */
    public function newAction()
    {
        $entity = new AvRequest();
        
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }
    
    /**
     * Finds and displays an AvRequest entity.
     *
     * @Route("/{id}", name="avrequest_show")
     * @Method("GET")
     * @Template()
     * 
     * @Secure(roles="ROLE_AV_VIEW")
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

        $form->add('submit', 'submit', array('label' => 'Update', 'attr' => array('class' => 'btn btn-sm btn-success')));
        $form->add('emailPatron', 'submit', array('label' => 'Update and Email Status to Patron', 'attr' => array('class' => 'btn btn-sm btn-default')));

        return $form;
    }
    
    /**
     * Displays a form to edit an existing AvRequest entity.
     *
     * @Route("/{id}/edit", name="avrequest_edit")
     * @Method("GET")
     * @Template()
     * 
     * @Secure(roles="ROLE_AV_EDIT")
     */
    public function editAction($id)
    {
      $em = $this->getDoctrine()->getManager();
      
      $entity = $em->getRepository('AppBundle:AvRequest')->find($id);
      
      $service = $this->get('user_service');
      //$user = $em->getRepository('AppBundle:User')->find(1);
      //$service->editPermission($user, 'AppBundle:AvRequest', MaskBuilder::MASK_EDIT);
      
      /*
      // check for edit access
      $authorizationChecker = $this->get('security.authorization_checker');
      if (false === $authorizationChecker->isGranted('EDIT', $entity)) {
          throw new AccessDeniedException();
      }*/
      
      if (!$entity) {
          throw $this->createNotFoundException('Unable to find AvRequest entity.');
      }
      
      $editForm = $this->createEditForm($entity);
      $deleteForm = $this->createDeleteForm($id);
      
      // keep in mind that this will call all registered security voters
      //$this->denyAccessUnlessGranted('ROLE_AV_EDIT', $entity, 'Unauthorized access!');
      
      return array(
          'entity'      => $entity,
          'edit_form'   => $editForm->createView(),
          'delete_form' => $deleteForm->createView(),
      );
      
    }
    
    /**
     * Edits an existing AvRequest entity.
     *
     * @Route("/{id}", name="avrequest_update")
     * @Method("PUT")
     * @Template("AppBundle:AvRequest:edit.html.twig")
     * 
     * @Secure(roles="ROLE_AV_EDIT")
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
          
            //if necessary, email the patron with the updated status
            if( $editForm->get('emailPatron')->isClicked()){
              $entity->setReplyDate(new \DateTime());
              $message = \Swift_Message::newInstance();
              $header_image = $message->embed(\Swift_Image::fromPath($this->container->get('kernel')->locateResource('@AppBundle/Resources/public/images/email_banner_640x75.jpg')));
              //send the email              
              $message
                ->setSubject('Status Update to Your Audio/Visual Request at EMU Library')
                ->setFrom(array('avrequest@emulibrary.com' => 'EMU Library'))
                ->setTo($entity->getFacultyEmail())
                ->setBody(
                    $this->renderView(
                        'AppBundle:AvRequest/Emails:avrequeststatusupdate.html.twig',
                        array(
                          'entity' => $entity,
                          'header_image' => $header_image
                        )
                    ),
                    'text/html'
                )
            ;
              $this->get('mailer')->send($message);
            }
            
            $em->persist($entity);
            $em->flush();
            
            return $this->redirect($this->generateUrl('avrequest_edit', array('id' => $id)));
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
     * @Route("/{id}", name="avrequest_delete")
     * @Method("DELETE")
     * 
     * @Secure(roles="ROLE_AV_DELETE")
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

        return $this->redirect($this->generateUrl('avrequests'));
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
