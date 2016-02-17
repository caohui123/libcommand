<?php
namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Hateoas\HateoasBuilder;
use Hateoas\Representation\PaginatedRepresentation;
use Hateoas\Representation\CollectionRepresentation;
use Doctrine\ORM\Tools\Pagination\Paginator;

class NewsRestController extends FOSRestController{

    /**
     * Get all news stories not marked "hidden".
     * 
     * @param int $page
     * @param int $num_stories
     * @return Response
     */
    public function getNewsPageAction($page_num = 1, $results_per_page = 5){
        $em = $this->getDoctrine()->getManager();
        
        $offset = ($page_num - 1) * $results_per_page; //which record to start on
        
        $entities = $em->createQuery(
          'SELECT n FROM AppBundle:News n WHERE n.hidden = :hidden ORDER BY n.created DESC'
        )
            ->setParameter('hidden', 0)
            ->setMaxResults($results_per_page)
            ->setFirstResult($offset)
            ->getResult();
        
        $serializer = $this->container->get('serializer');
        $serialized = $serializer->serialize($entities, 'json');
        $response = new Response($serialized, 200, array('Content-Type' => 'application/json'));
        
        return $response;
    }
    
    /**
     * Get total records and number of pages based on the specified results per page.
     * 
     * @param int $results_per_page
     * @return JsonResponse
     */
    public function getNewspaginationinfoAction($results_per_page){
        $em = $this->getDoctrine()->getManager();
        
        $qb = $em->createQueryBuilder('n');
        $qb->select('count(n.id)');
        $qb->from('AppBundle:News', 'n');
        
        $num_records = $qb->getQuery()->getSingleScalarResult();
        
        $response = new JsonResponse();
        $response->setData(array(
              'num_pages' => ceil($num_records/$results_per_page),
              'num_records' => intval($num_records)
            ));
        $response->setStatusCode(200);
        
        return $response;
    }
    
    /**
     * Get an individual news story.
     * 
     * @param int $id
     * @return Response
     */
    public function getNewsAction($id){
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:News')->find($id);
        
        if(!$entity){
          throw $this->createNotFoundException('That news article was not found.');
        }
        
        $serializer = $this->container->get('serializer');
        $serialized = $serializer->serialize($entity, 'json');
        $response = new Response($serialized, 200, array('Content-Type' => 'application/json'));
        
        return $response;
    }
}
