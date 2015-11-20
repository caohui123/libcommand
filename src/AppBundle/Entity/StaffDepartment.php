<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * StaffDepartment
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="AppBundle\Entity\StaffDepartmentRepository")
 * @UniqueEntity(fields={"department"}, message="That department already exists.")
 */
class StaffDepartment
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
     * @ORM\Column(name="department", type="text")
     */
    private $department;

    /**
     * @ORM\OneToMany(targetEntity="StaffFunctionalArea", mappedBy="dept", cascade={"persist"}, orphanRemoval=true)
     */
    private $functionalAreas;

    public function __construct() {
      $this->functionalAreas = new ArrayCollection();
    }
    
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
     * Set department
     *
     * @param string $department
     *
     * @return StaffDepartment
     */
    public function setDepartment($department)
    {
        $this->department = $department;

        return $this;
    }

    /**
     * Get department
     *
     * @return string
     */
    public function getDepartment()
    {
        return $this->department;
    }

    /**
     * Set functionalAreas
     *
     * @param array $functionalAreas
     *
     * @return StaffDepartment
     */
    public function setFunctionalAreas($functionalAreas)
    {
        $this->functionalAreas = $functionalAreas;

        return $this;
    }

    /**
     * Get functionalAreas
     *
     * @return array
     */
    public function getFunctionalAreas()
    {
        return $this->functionalAreas;
    }
}

