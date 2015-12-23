<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use AppBundle\Entity\HoursArea;
use AppBundle\Entity\HoursSpecial;
use AppBundle\Form\HoursSpecialType;
use AppBundle\Form\Type\HiddenHoursAreaType;
use Doctrine\ORM\EntityRepository;

/**
 * HoursRegular controller.
 *
 * @Route("/hoursspecial")
 */
class HoursSpecialController extends Controller
{
    //used within form functions. DO NOT REMOVE!
    private $date;
    private $entity; 
    
    /**
     * Creates a form to create a HoursSpecial entity.
     *
     * @param HoursSpecial $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    public function createCreateForm(HoursSpecial $entity, HoursArea $area, $date)
    {   
        $this->date = $date;
        $form = $this->createForm(new HoursSpecialType($this->getDoctrine()->getManager()), $entity, array(
            'action' => $this->generateUrl('hoursspecial_postcreate'),
            'method' => 'POST',
        ));
        $form->add('eventDate', new \AppBundle\Form\Type\HiddenDateTimeType(), array('data'=>$date));
        $form->add('area', new HiddenHoursAreaType($this->getDoctrine()->getManager()), array(
            'data'=>$area,
            'invalid_message'=>'Area field not converted proerly'
        ));
        $form->add('event', 'entity', array(
            'class'=>'AppBundle:HoursEvent',
            'query_builder'=>function(EntityRepository $er){
                $qb = $er->createQueryBuilder('he');
                $qb
                  ->where('he.startDate <= :startDate')
                  ->andWhere('he.endDate >= :endDate')
                  ->orderBy('he.endDate', 'DESC')
                  ->setParameter('startDate', $this->date)
                  ->setParameter('endDate', $this->date)
                  ->getQuery();
                return $qb;
            },
            'property' => 'getName',
            'label' => 'Event Category',
            'placeholder' => '--Choose an Event--',
            'required' => true
        ));
        
        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }
    
    /**
     * Creates a new HoursSpecial entity.
     *
     * @Route("/", name="hoursspecial_postcreate")
     * @Method("POST")
     */
    public function postCreateAction(Request $request){
        $requestData = $request->request->all();
        $date = $requestData['appbundle_hoursspecial']['eventDate'];
        
        //find area entity based on passed id
        $em = $this->getDoctrine()->getManager();
        $area = $em->getRepository('AppBundle:HoursArea')->find($requestData['appbundle_hoursspecial']['area']);
        
        if(!$area){
            throw $this->createNotFoundException('Unable to find HoursArea entity returned in form.');
        }
        
        $entity = new HoursSpecial();
        $form = $this->createCreateForm($entity, $area, new \DateTime($date) );
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            $serializer = $this->get('serializer');
            $serialized = $serializer->serialize($entity, 'json');  
            
            return new JsonResponse($serialized, 201);
        }

        return new JsonResponse(array(
            $this->getFormErrors($form)
        ), 400);
    }
    
    /**
     * Edits an existing HoursSpecial entity.
     *
     * @Route("/{id}", name="hoursspecial_postupdate")
     * @Method("POST")
     */
    public function postUpdateAction(Request $request, $id){
        $em = $this->getDoctrine()->getManager();
        var_dump($id);
        $entity = $em->getRepository('AppBundle:HoursSpecial')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find HoursSpecial entity.');
        }
        
        //create blank named form for the SpecialHour instead of calling the createEditForm
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);
        
        if ($editForm->isValid()) {
            $em->flush();

            $serializer = $this->get('serializer');
            $serialized = $serializer->serialize($entity, 'json');  
            
            return new JsonResponse($serialized, 201);
        }

        return new JsonResponse(array(
            $this->getFormErrors($editForm)
        ), 400);
    }
    
    /**
    * Creates a form to edit a HoursSpecial entity.
    *
    * @param HoursSpecial $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    public function createEditForm(HoursSpecial $entity)
    {      
        $this->entity = $entity;
        
        $form = $this->createForm(new HoursSpecialType($this->getDoctrine()->getManager()), $entity, array(
            'action' => $this->generateUrl('hoursspecial_postupdate', array('id' => $entity->getId())),
            'method' => 'POST',
            'attr' => array('class' => 'specialHours_form')
        ));
        
        //...no need to add eventDate or area fields since these will never change!...
        
        $form->add('event', 'entity', array(
            'class'=>'AppBundle:HoursEvent',
            'query_builder'=>function(EntityRepository $er){
                $qb = $er->createQueryBuilder('he');
                $qb
                  ->where('he.startDate <= :startDate')
                  ->andWhere('he.endDate >= :endDate')
                  ->orderBy('he.endDate', 'DESC')
                  ->setParameter('startDate', $this->entity->getEventDate())
                  ->setParameter('endDate', $this->entity->getEventDate())
                  ->getQuery();
                return $qb;
            },
            'property' => 'getName',
            'label' => 'Event Category',
            'placeholder' => '--Choose an Event--',
            'required' => true
        ));
        
        $form->add('submit', 'submit', array('label' => 'Save Day'));

        return $form;
    }
    
    /**
     * Deletes a Staff entity.
     *
     * @Route("/{id}", name="hoursspecial_delete")
     * @Method("DELETE")
     * 
     * //@Secure(roles="ROLE_HOURS_DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AppBundle:HoursSpecial')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find special hours entity.');
            }
            
            $em->remove($entity);
            $em->flush();

            return new JsonResponse('Entity deleted', 204);
        }

        return new JsonResponse(array(
            $this->getFormErrors($form)
        ), 400);
    }
    
    /**
    * Creates a form to delete a HoursSpecial entity.
    *
    * @param mixed $id The entity id
    *
    * @return \Symfony\Component\Form\Form The form
    */
    public function createDeleteForm($id)
    {      
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('hoursspecial_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete', 'attr' => array('class' => 'btn btn-sm btn-danger')))
            ->getForm()
        ;
    }
    
    /**
     * Get any global or individual field errors in a form
     * 
     * @param \Symfony\Component\Form\Form $form
     * @return array $errors  Global or field errors with the form
     */
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
}

