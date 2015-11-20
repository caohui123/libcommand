<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use AppBundle\Entity\StaffDepartment;

/**
 * FunctionalArea
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="AppBundle\Entity\StaffFunctionalAreaRepository")
 */
class StaffFunctionalArea
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="functional_area", type="text")
     */
    private $functionalArea;
    
    /**
     * @ORM\ManyToOne(targetEntity="StaffDepartment", inversedBy="functionalAreas", cascade={"all"}, fetch="LAZY")
     */
    private $dept;
    
    /**
     * @ORM\OneToMany(targetEntity="User", mappedBy="staffFunctionalArea", cascade={"persist"}, orphanRemoval=true)
     */
    private $users;

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set functionalArea
     *
     * @param string $functionalArea
     *
     * @return FunctionalArea
     */
    public function setFunctionalArea($functionalArea)
    {
        $this->functionalArea = $functionalArea;

        return $this;
    }

    /**
     * Get functionalArea
     *
     * @return string
     */
    public function getFunctionalArea()
    {
        return $this->functionalArea;
    }
    
    public function setDepartment(StaffDepartment $department){
      $this->dept = $department;
      return $this;
    }
    
    public function getDepartment(){
      return $this->dept;
    }
}

