<?php

namespace AppBundle\Entity;

/**
 * FunctionalAreaRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class StaffFunctionalAreaRepository extends \Doctrine\ORM\EntityRepository
{
  /**
   * List all functional areas for a department
   * @param Object $department
   */
  public function findByDepartment($department){
    $em = $this->getEntityManager();
    
    $areas = $em->createQuery(
        'SELECT a FROM StaffFunctionalArea a WHERE a.department = :department ORDER BY a.department ASC'
    )->setParameter('department', $department)->getResult();
    
    return $areas;
  }
}
