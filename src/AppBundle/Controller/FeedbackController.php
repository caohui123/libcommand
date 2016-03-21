<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use AppBundle\Entity\Feedback;
use AppBundle\Form\FeedbackType;
use JMS\SecurityExtraBundle\Annotation\Secure;

/**
 * Feedback controller.
 *
 * @Route("/feedback")
 */
class FeedbackController extends Controller
{

    /**
     * Lists all Feedback entities.
     *
     * @Route("/", name="feedback")
     * @Method("GET")
     * @Template()
     * 
     * @Secure(roles="ROLE_FEEDBACK_VIEW")
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('AppBundle:Feedback')->findBy(array(), array('created'=>'DESC'));

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
     * Creates a new Feedback entity.
     * --ROUTE COMMENTED OUT. THIS SHOULD ONLY BE AVAILABLE THROUGH THE REST API. USE FOR TESTING ONLY!--
     * //@Route("/", name="feedback_create")
     * //@Method("POST")
     * //@Template("AppBundle:Feedback:new.html.twig")
     * 
     * //@Secure(roles="ROLE_FEEDBACK_EDIT")
     */
    public function createAction(Request $request)
    {
        $entity = new Feedback();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('feedback_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a Feedback entity.
     *
     * @param Feedback $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Feedback $entity)
    {
        $form = $this->createForm(new FeedbackType(), $entity, array(
            'action' => $this->generateUrl('feedback_create'),
            'method' => 'POST',
        ));
        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Feedback entity.
     * --ROUTE COMMENTED OUT. THIS SHOULD ONLY BE AVAILABLE THROUGH THE REST API. USE FOR TESTING ONLY!--
     * //@Route("/new", name="feedback_new")
     * //@Method("GET")
     * //@Template()
     * 
     * //@Secure(roles="ROLE_FEEDBACK_EDIT")
     */
    public function newAction()
    {
        $entity = new Feedback();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Feedback entity.
     *
     * @Route("/{id}", name="feedback_show")
     * @Method("GET")
     * @Template()
     * 
     * @Secure(roles="ROLE_FEEDBACK_VIEW")
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Feedback')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Feedback entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Feedback entity.
     *
     * @Route("/{id}/edit", name="feedback_edit")
     * @Method("GET")
     * @Template()
     * 
     * @Secure(roles="ROLE_FEEDBACK_EDIT")
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Feedback')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Feedback entity.');
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
    * Creates a form to edit a Feedback entity.
    *
    * @param Feedback $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Feedback $entity)
    {
        $form = $this->createForm(new FeedbackType($this->getDoctrine()->getManager()), $entity, array(
            'action' => $this->generateUrl('feedback_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update', 'attr'=>array('class'=>'btn btn-sm btn-success')));

        return $form;
    }
    /**
     * Edits an existing Feedback entity.
     *
     * @Route("/{id}", name="feedback_update")
     * @Method("PUT")
     * @Template("AppBundle:Feedback:edit.html.twig")
     * 
     * @Secure(roles="ROLE_FEEDBACK_EDIT")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Feedback')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Feedback entity.');
        }
        
        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $requestData = $request->request->all();
            
            //if necessary, forward the reply with an optional comment and mark the time thereof
            if(null != $requestData['appbundle_feedback']['forwardedTo']){
              $entity->setLastForwardDate(new \DateTime());
              //forward the email
              $forwardeeEmail = $requestData['appbundle_feedback']['forwardedTo'];
              $user = $this->container->get('security.context')->getToken()->getUser();
              
              //get user first and last name from Staff (if no staff member associated with logged-in LDAP user, just use 'anonymous')
              if(null !== $user->getStaffMember()){
                $user_firstlast = $user->getStaffMember()->getFirstName() . ' ' . $user->getStaffMember()->getLastName();
              } else {
                $user_firstlast = 'anonymous';  
              }
              
              $message = \Swift_Message::newInstance();
              $header_image = $message->embed(\Swift_Image::fromPath($this->container->get('kernel')->locateResource('@AppBundle/Resources/public/images/email_banner_640x75.jpg')));
              $message
                  ->setSubject('Fwd: EMU Library Feedback ' . $entity->getCreated()->format('d/m/Y'))
                  ->setFrom($user->getEmail())
                  ->setTo($forwardeeEmail)
                  ->setBody(
                        $this->renderView(
                            'AppBundle:Feedback/Emails:forwardfeedback.html.twig',
                            array(
                              'created' => $entity->getCreated(),
                              'body' => $entity->getBody(),
                              'message' => $requestData['appbundle_feedback']['forwardedMessage'],
                              'header_image' => $header_image,
                              'user_firstlast' => $user_firstlast
                            )
                        ),
                        'text/html'
                    );
              $this->get('mailer')->send($message);
            }
            
            //if necessary, record the reply to the patron and the time thereof
            if(isset($requestData['appbundle_feedback']['reply']) && trim($requestData['appbundle_feedback']['reply']) != ''){
              $entity->setResponse($requestData['appbundle_feedback']['reply']);
              $entity->setReplyDate(new \DateTime());
              $em->persist($entity);
              
              //email the patron
              $patronEmail = $entity->getPatronEmail();
              
              $message = \Swift_Message::newInstance();
              $header_image = $message->embed(\Swift_Image::fromPath($this->container->get('kernel')->locateResource('@AppBundle/Resources/public/images/email_banner_640x75.jpg')));
              $message
                  ->setSubject('Response to Your Feedback at EMU Library')
                  ->setFrom('feedback@emulibrary.com')
                  ->setTo($patronEmail)
                  ->setBody(
                      $this->renderView(
                            'AppBundle:Feedback/Emails:patronresponse.html.twig',
                            array(
                              'created' => $entity->getCreated(),
                              'body' => $entity->getBody(),
                              'message' => $entity->getResponse(),
                              'header_image' => $header_image
                            )
                        ),
                        'text/html'
                      );
              $this->get('mailer')->send($message);
            }
            $em->flush();

            return $this->redirect($this->generateUrl('feedback_edit', array('id' => $id)));
        }
        
        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a Feedback entity.
     *
     * @Route("/{id}", name="feedback_delete")
     * @Method("DELETE")
     * 
     * @Secure(roles="ROLE_FEEDBACK_DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AppBundle:Feedback')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Feedback entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('feedback'));
    }

    /**
     * Creates a form to delete a Feedback entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('feedback_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array(
                'label' => 'Delete', 
                'attr' => array(
                    'class' => 'btn btn-sm btn-danger',
                    'onclick' => 'return confirm("Are you sure you want to delete this feedback?")'
                    )
                )
            )
            ->getForm()
        ;
    }
    
    /**
     * Displays a printer-friendly Feedback entity.
     *
     * @Route("/{id}/print", name="feedback_print")
     * @Method("GET")
     * @Template()
     * 
     * @Secure(roles="ROLE_FEEDBACK_EDIT")
     */
    public function printAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Feedback')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Feedback entity.');
        }

        return array(
            'entity'      => $entity,
        );
    }
}
