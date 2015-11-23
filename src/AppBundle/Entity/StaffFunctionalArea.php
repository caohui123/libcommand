<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use AppBundle\Entity\StaffDepartment;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * FunctionalArea
 *
 * @ORM\Table()
 * @UniqueEntity(fields={"functionalArea"}, message="That functional area already exists.")
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
     * @ORM\ManyToOne(targetEntity="StaffDepartment", inversedBy="functionalAreas", fetch="LAZY")
     */
    private $dept;
    
    /**
     * @ORM\OneToMany(targetEntity="Staff", mappedBy="staffFunctionalArea", cascade={"persist"}, orphanRemoval=true)
     */
    private $users;
    
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
    
    public function setDept(StaffDepartment $dept){
      $this->dept = $dept;
      return $this;
    }
    
    public function getDept(){
      return $this->dept;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->users = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add user
     *
     * @param \AppBundle\Entity\Staff $user
     *
     * @return StaffFunctionalArea
     */
    public function addUser(\AppBundle\Entity\Staff $user)
    {
        $this->users[] = $user;

        return $this;
    }

    /**
     * Remove user
     *
     * @param \AppBundle\Entity\Staff $user
     */
    public function removeUser(\AppBundle\Entity\Staff $user)
    {
        $this->users->removeElement($user);
    }

    /**
     * Get users
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getUsers()
    {
        return $this->users;
    }
    
    public function getCreated()
    {
        return $this->created;
    }

    public function getUpdated()
    {
        return $this->updated;
    }
    
    public function __toString() {
        return $this->getFunctionalArea();
    }
}
