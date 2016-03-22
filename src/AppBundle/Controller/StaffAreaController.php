<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use AppBundle\Entity\StaffArea;
use AppBundle\Form\StaffAreaType;
use AppBundle\Resources\Services\ListService;
use Symfony\Component\HttpFoundation\Response;

/**
 * StaffArea controller. 
 * 
 * Security is controlled for all /admin/* paths by the access_control setting in security.yml.
 *
 * @Route("/admin/staffareas")
 */
class StaffAreaController extends Controller
{

    /**
     * Lists all StaffArea entities.
     *
     * @Route("/", name="admin_staffareas")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        
        $entities = $em->getRepository('AppBundle:StaffArea')->findBy(array(), array('title'=>'ASC'));
        
        $list_service = $this->get('list_service');
        $styled_list = $list_service->staffAreasList($entities);

        return array(
            'styled_list' => $styled_list
        );
    }
    /**
     * Creates a new StaffArea entity.
     *
     * @Route("/", name="admin_staffareas_create")
     * @Method("POST")
     * @Template("AppBundle:StaffArea:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new StaffArea();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('admin_staffareas_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a StaffArea entity.
     *
     * @param StaffArea $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(StaffArea $entity)
    {
        $form = $this->createForm(new StaffAreaType(), $entity, array(
            'action' => $this->generateUrl('admin_staffareas_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new StaffArea entity.
     *
     * @Route("/new", name="admin_staffareas_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new StaffArea();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a StaffArea entity.
     *
     * @Route("/{id}", name="admin_staffareas_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:StaffArea')->find($id);
        
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find StaffArea entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing StaffArea entity.
     *
     * @Route("/{id}/edit", name="admin_staffareas_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:StaffArea')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find StaffArea entity.');
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
    * Creates a form to edit a StaffArea entity.
    *
    * @param StaffArea $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(StaffArea $entity)
    {
        $form = $this->createForm(new StaffAreaType(), $entity, array(
            'action' => $this->generateUrl('admin_staffareas_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update', 'attr'=>array('class'=>'btn btn-sm btn-success')));

        return $form;
    }
    /**
     * Edits an existing StaffArea entity.
     *
     * @Route("/{id}", name="admin_staffareas_update")
     * @Method("PUT")
     * @Template("AppBundle:StaffArea:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:StaffArea')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find StaffArea entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $requestData = $request->request->all();
          
            //staff areas can't have more than one sub-level.
            //if placing an area with children under another category, those children must now become siblings of that area
            if($requestData['appbundle_staffarea']['parent'] != null){
              //find parent area
              $parent = $em->getRepository('AppBundle:StaffArea')->find($requestData['appbundle_staffarea']['parent']);

              $children = $em->getRepository('AppBundle:StaffArea')->findBy(array('parent' => $entity));
              if($children){
                foreach($children as $child){
                  $child->setParent($parent);
                  $child->setLvl(1);

                  $em->persist($child);
                }
              }
            }
            
            //if no parent, make sure this area's lvl is set to 0
            else {
              $entity->setLvl(0);
              $em->persist($entity);
            }
          
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
     * Deletes a StaffArea entity.
     *
     * @Route("/{id}", name="admin_staffareas_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AppBundle:StaffArea')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find StaffArea entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('admin_staffareas'));
    }

    /**
     * Creates a form to delete a StaffArea entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_staffareas_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array(
                'label' => 'Delete Staff Area', 
                'attr' => array(
                    'class' => 'btn btn-sm btn-danger',
                    'onclick' => 'return confirm("WARNING! Deleting this staff area will also delete any children areas. To avoid this, please either make children areas top-level areas or move them under another parent area. Are you still sure you want to delete this area?")'
                    )
                )
            )
            ->getForm()
        ;
    }
    
    /**
     * Displays a printer-friendly StaffArea entity.
     *
     * @Route("/{id}/print", name="admin_staffareas_print")
     * @Method("GET")
     * @Template()
     */
    public function printAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:StaffArea')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find StaffArea entity.');
        }

        return array(
            'entity'      => $entity,
        );
    }
    
    /**
     * Returns the 'lvl' field of a staffArea
     *
     * @Route("/parent/{id}", name="staffarea_parentlvl")
     * @Method("GET")
     */
    public function getLevelAction($id){
      $em = $this->getDoctrine()->getManager();
      
      $staffArea = $em->getRepository('AppBundle:StaffArea')->find($id);
      
      if(!$staffArea){
        throw $this->createNotFoundException('No StaffArea entity found with that ID');
      }
      
      $areaId = $staffArea->getLvl();
      
      $response = new Response($areaId, 200, array('Content-Type' => 'text/plain'));
      return $response;
    }
}
