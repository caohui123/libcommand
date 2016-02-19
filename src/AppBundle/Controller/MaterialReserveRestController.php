<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use AppBundle\Entity\MaterialReserve;
use AppBundle\Form\MaterialReserveType;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\JsonResponse;

class MaterialReserveRestController extends FOSRestController
{
    /**
     * Get all MaterialReserveMedia entities
     * @return Response
     */
    public function getMaterialreserveMediaAction(){
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('AppBundle:MaterialReserveMedia')->findBy(array(), array('name'=>'ASC'));
        $serializer = $this->container->get('serializer');
        $serialized = $serializer->serialize($entities, 'json');
        $response = new Response($serialized, 200, array('Content-Type' => 'application/json'));
        
        return $response;
    }
}
