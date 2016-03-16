<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use AppBundle\Entity\HoursEvent;
use AppBundle\Form\HoursEventType;
use JMS\SecurityExtraBundle\Annotation\Secure;

/**
 * HoursEvent controller.
 *
 * @Route("/hoursevent")
 */
class HoursEventController extends Controller
{

    /**
     * Lists all HoursEvent entities.
     *
     * @Route("/", name="hoursevent")
     * @Method("GET")
     * @Template()
     * 
     * @Secure(roles="ROLE_HOURS_VIEW")
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('AppBundle:HoursEvent')->findBy(array(), array('startDate'=>'DESC'));

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
     * Creates a new HoursEvent entity.
     *
     * @Route("/", name="hoursevent_create")
     * @Method("POST")
     * @Template("AppBundle:HoursEvent:new.html.twig")
     * 
     * @Secure(roles="ROLE_HOURS_EDIT")
     */
    public function createAction(Request $request)
    {
        $entity = new HoursEvent();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('hoursevent_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a HoursEvent entity.
     *
     * @param HoursEvent $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(HoursEvent $entity)
    {
        $form = $this->createForm(new HoursEventType(), $entity, array(
            'action' => $this->generateUrl('hoursevent_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new HoursEvent entity.
     *
     * @Route("/new", name="hoursevent_new")
     * @Method("GET")
     * @Template()
     * 
     * @Secure(roles="ROLE_HOURS_EDIT")
     */
    public function newAction()
    {
        $entity = new HoursEvent();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a HoursEvent entity.
     *
     * @Route("/{id}", name="hoursevent_show")
     * @Method("GET")
     * @Template()
     * 
     * @Secure(roles="ROLE_HOURS_VIEW")
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:HoursEvent')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find HoursEvent entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing HoursEvent entity.
     *
     * @Route("/{id}/edit", name="hoursevent_edit")
     * @Method("GET")
     * @Template()
     * 
     * @Secure(roles="ROLE_HOURS_EDIT")
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:HoursEvent')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find HoursEvent entity.');
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
    * Creates a form to edit a HoursEvent entity.
    *
    * @param HoursEvent $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(HoursEvent $entity)
    {
        $form = $this->createForm(new HoursEventType(), $entity, array(
            'action' => $this->generateUrl('hoursevent_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update', 'attr'=>array('class'=>'btn btn-sm btn-success')));

        return $form;
    }
    /**
     * Edits an existing HoursEvent entity.
     *
     * @Route("/{id}", name="hoursevent_update")
     * @Method("PUT")
     * @Template("AppBundle:HoursEvent:edit.html.twig")
     * 
     * @Secure(roles="ROLE_HOURS_EDIT")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $em2 = $this->getDoctrine()->getEntityManager();
        
        $entity = $em->getRepository('AppBundle:HoursEvent')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find HoursEvent entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();
            //delete any special events that are outside of the new date range
            $requestData = $request->request->all();
            $newStartDate = new \DateTime($requestData['appbundle_hoursevent']['startDate']);
            $newEndDate = new \DateTime($requestData['appbundle_hoursevent']['endDate']);
            
            $removeablDates = $em2->createQuery(
                        'SELECT hs FROM AppBundle:HoursSpecial hs WHERE (hs.eventDate < :newStartDate OR hs.eventDate > :newEndDate) OR (hs.eventDate > :newEndDate) OR (hs.eventDate < :newStartDate) AND hs.event = :event'
                    )
                    ->setParameter('newStartDate', $newStartDate)
                    ->setParameter('newEndDate', $newEndDate)
                    ->setParameter('event', $entity)
                    ->getResult();
            
            foreach($removeablDates as $dt){
                $em2->remove($dt);
            }
            $em2->flush();

            return $this->redirect($this->generateUrl('hoursevent_edit', array('id' => $id)));
        }
        
        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a HoursEvent entity.
     *
     * @Route("/{id}", name="hoursevent_delete")
     * @Method("DELETE")
     * 
     * @Secure(roles="ROLE_HOURS_DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AppBundle:HoursEvent')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find HoursEvent entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('hoursevent'));
    }

    /**
     * Creates a form to delete a HoursEvent entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('hoursevent_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array(
                'label' => 'Delete Event', 
                'attr' => array(
                    'class' => 'btn btn-sm btn-danger',
                    'onclick' => 'return confirm("Are you sure you want to delete this event? This will erase all hours for all areas associated with this event.")'
                    )
                )
            )
            ->getForm()
        ;
    }
}
