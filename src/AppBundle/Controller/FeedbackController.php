<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use AppBundle\Entity\Feedback;
use AppBundle\Form\FeedbackType;

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
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('AppBundle:Feedback')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new Feedback entity.
     *
     * //@Route("/", name="feedback_create")
     * //@Method("POST")
     * //@Template("AppBundle:Feedback:new.html.twig")
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
     *
     * //@Route("/new", name="feedback_new")
     * //@Method("GET")
     * //@Template()
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

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Feedback entity.
     *
     * @Route("/{id}", name="feedback_update")
     * @Method("PUT")
     * @Template("AppBundle:Feedback:edit.html.twig")
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
              
              $message = \Swift_Message::newInstance()
                  ->setSubject('Fwd: EMU Library Feedback ' . $entity->getCreated()->format('d/m/Y'))
                  ->setFrom($user->getEmail())
                  ->setTo($forwardeeEmail)
                  ->setBody(
                        $this->renderView(
                            'AppBundle:Feedback/Emails:forwardfeedback.html.twig',
                            array(
                              'created' => $entity->getCreated(),
                              'body' => $entity->getBody(),
                              'message' => $requestData['appbundle_feedback']['forwardedMessage']
                            )
                        ),
                        'text/html'
                    );
              $this->get('mailer')->send($message);
            }
            
            //if necessary, record the reply to the patron and the time thereof
            if(isset($requestData['appbundle_feedback']['reply']) && null != $requestData['appbundle_feedback']['reply']){
              $entity->setResponse($requestData['appbundle_feedback']['reply']);
              $entity->setReplyDate(new \DateTime());
              $em->persist($entity);
              
              //email the patron
              $patronEmail = $entity->getPatronEmail();
              $message = \Swift_Message::newInstance()
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
            ->add('submit', 'submit', array('label' => 'Delete', 'attr'=>array('class' => 'btn btn-sm btn-danger')))
            ->getForm()
        ;
    }
}
