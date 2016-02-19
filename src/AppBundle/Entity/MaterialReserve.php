<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\Common\Collections\ArrayCollection;
use AppBundle\Entity\MaterialReserveItem;

/**
 * MediaReserve
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class MaterialReserve
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
     * @ORM\Column(name="semester", type="string", length=6)
     */
    private $semester;

    /**
     * @var integer
     *
     * @ORM\Column(name="year", type="integer")
     */
    private $year;

    /**
     * @var string
     *
     * @ORM\Column(name="course", type="string", length=15)
     */
    private $course;

    /**
     * @var integer
     *
     * @ORM\Column(name="enrollment", type="integer")
     */
    private $enrollment;

    /**
     * @var string
     *
     * @ORM\Column(name="instructor", type="string", length=50)
     */
    private $instructor;

    /**
     * @var string
     *
     * @ORM\Column(name="phone", type="string", length=15)
     */
    private $phone;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=50)
     */
    private $email;
    
    /**
     * @ORM\OneToMany(targetEntity="MaterialReserveItem", mappedBy="materialreserve", cascade={"persist"})
     */
    private $items;
    
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
     * @var string $contentChangedBy
     *
     * @ORM\Column(name="content_changed_by", type="string", nullable=true)
     * @Gedmo\Blameable(on="change", field={"semester", "year", "course", "enrollment", "instructor", "phone", "email"})
     */
    private $contentChangedBy;

    public function __construct() {
      $this->items = new ArrayCollection();
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
     * Set semester
     *
     * @param string $semester
     *
     * @return MediaReserve
     */
    public function setSemester($semester)
    {
        $this->semester = $semester;

        return $this;
    }

    /**
     * Get semester
     *
     * @return string
     */
    public function getSemester()
    {
        return $this->semester;
    }

    /**
     * Set year
     *
     * @param integer $year
     *
     * @return MediaReserve
     */
    public function setYear($year)
    {
        $this->year = $year;

        return $this;
    }

    /**
     * Get year
     *
     * @return integer
     */
    public function getYear()
    {
        return $this->year;
    }

    /**
     * Set course
     *
     * @param string $course
     *
     * @return MediaReserve
     */
    public function setCourse($course)
    {
        $this->course = $course;

        return $this;
    }

    /**
     * Get course
     *
     * @return string
     */
    public function getCourse()
    {
        return $this->course;
    }

    /**
     * Set enrollment
     *
     * @param integer $enrollment
     *
     * @return MediaReserve
     */
    public function setEnrollment($enrollment)
    {
        $this->enrollment = $enrollment;

        return $this;
    }

    /**
     * Get enrollment
     *
     * @return integer
     */
    public function getEnrollment()
    {
        return $this->enrollment;
    }

    /**
     * Set instructor
     *
     * @param string $instructor
     *
     * @return MediaReserve
     */
    public function setInstructor($instructor)
    {
        $this->instructor = $instructor;

        return $this;
    }

    /**
     * Get instructor
     *
     * @return string
     */
    public function getInstructor()
    {
        return $this->instructor;
    }

    /**
     * Set phone
     *
     * @param string $phone
     *
     * @return MediaReserve
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * Get phone
     *
     * @return string
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return MediaReserve
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }
    
    /**
     * Add item
     *
     * @param AppBundle\Entity\MaterialReserveItem $item
     * @return MaterialReserve
     */
    public function addItem(MaterialReserveItem $item)
    {
        $item->setMaterialReserve($this); //also add this MaterialReserve as the foreign key of the event
        $this->items->add($item);

        return $this;
    }
    
    /**
     * Remove items
     *
     * @param AppBundle\Entity\MaterialReserveItem $item
     * @return MaterialReserve
     */
    public function removeItem(MaterialReserveItem $item)
    {
        $this->items->removeElement($item);
        
        return $this;
    }
    
    /**
     * Get items
     *
     * @return AppBundle\Entity\MaterialReserveItem
     */
    public function getItem()
    {
        return $this->items;
    }
    
    /**
     * Get created
     *
     * @return \DateTime
     */
    public function getCreated()
    {
        return $this->created;
    }
    public function setCreated($created)
    {
        $this->created = $created;
        
        return $this;
    }

    /**
     * Get updated
     *
     * @return \DateTime
     */
    public function getUpdated()
    {
        return $this->updated;
    }
    public function setUpdated($updated)
    {
        $this->updated = $updated;
        
        return $this;
    }

    /**
     * Get contentChangedBy
     *
     * @return string
     */
    public function getContentChangedBy()
    {
        return $this->contentChangedBy;
    }
    public function setContentChangedBy($changedby)
    {
        $this->contentChangedBy = $changedby;
        
        return $this;
    }
    
    public function __toString() {
       return $this->getCreated(); 
    }
}

