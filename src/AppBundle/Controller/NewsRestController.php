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
        
        $entities = $em->getRepository('AppBundle:News')->findBy( array('hidden' => 0) );
        
        if(!$entities){
            $num_records = 0;
        } else {
            $num_records = $this->__tabulateRecords($entities);
        }

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
        
        $qb = $em->createQueryBuilder('n');
        $qb->select('n');
        $qb->from('AppBundle:News', 'n');
        $qb->where('n.id = :id');
        $qb->andWhere('n.hidden = :hidden');
        $qb->setParameter('id', $id);
        $qb->setParameter('hidden', 0);
        
        $entity = $qb->getQuery()->getOneOrNullResult();
        
        if(!$entity){
          throw $this->createNotFoundException('That news article was not found.');
        }
        
        $serializer = $this->container->get('serializer');
        $serialized = $serializer->serialize($entity, 'json');
        $response = new Response($serialized, 200, array('Content-Type' => 'application/json'));
        
        return $response;
    }
    
    /**
     * Get all news stories marked as emergencies.
     * 
     * @return Response
     */
    public function getNewsemergenciesAction(){
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:News')->findBy( array('emergency' => 1, 'hidden' => 0), array('created' => 'DESC') );

        if (!$entity) {
            new Response('No alerts or emergencies at this time.', 403, array('Content-Type' => 'application/json'));
        }
        
        $serializer = $this->container->get('serializer');
        $serialized = $serializer->serialize($entity, 'json');
        $response = new Response($serialized, 200, array('Content-Type' => 'application/json'));
        
        return $response;
    }
    
    /**
     * Count the number of records depending on if the news is on a delayed timer and if it should be currently displayed. 
     * 
     * @param array $entities  An array of News entities
     * @return int $num_records  The number of currently-displayed records,
     */
    private function __tabulateRecords($entities){
        $num_records = 0;
        foreach($entities as $entity){
            //if the post is delayed
            if(1 == $entity->getDelayedPost()){
                $start = $entity->getDisplayStart();
                $end = $entity->getDisplayEnd();
                $now = new \DateTime();
                
                //if start time is not null
                if(null !== $start){
                    //if story's start time is in the past and end time not set
                    if($start <= $now && null === $end){
                        $num_records++;
                    }
                    //if story's start time is in the past and end time is set and in the future
                    if($start <= $now && $end >= $now){
                        $num_records++;
                    }
                } else {
                    $num_records++;
                }
            } else {
                $num_records++;
            }            
        }
        
        return $num_records;
    }
}
