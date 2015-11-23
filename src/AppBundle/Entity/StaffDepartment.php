<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
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
    
    /**
     * @var \DateTime $created
     *
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(type="datetime")
     */
    private $created;

    /**
     * @var \DateTime $updated
     *
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(type="datetime")
     */
    private $updated;

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
        $this->functionalAreas->add($functionalAreas);

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

    /**
     * Add functionalArea
     *
     * @param \AppBundle\Entity\StaffFunctionalArea $functionalArea
     *
     * @return StaffDepartment
     */
    public function addFunctionalArea(\AppBundle\Entity\StaffFunctionalArea $functionalArea)
    {
        $this->functionalAreas[] = $functionalArea;

        return $this;
    }

    /**
     * Remove functionalArea
     *
     * @param \AppBundle\Entity\StaffFunctionalArea $functionalArea
     */
    public function removeFunctionalArea(\AppBundle\Entity\StaffFunctionalArea $functionalArea)
    {
        $this->functionalAreas->removeElement($functionalArea);
    }
    
    public function getCreated()
    {
        return $this->created;
    }

    public function getUpdated()
    {
        return $this->updated;
    }
}
