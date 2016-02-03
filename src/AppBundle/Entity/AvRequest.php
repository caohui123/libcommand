<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;
use AppBundle\Entity\AvRequestEvent;
use AppBundle\Entity\AvRequestEquipmentQuantity;

/**
 * AvRequest
 *
 * @ORM\Table()
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 */
class AvRequest
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
     * @var \DateTime
     *
     * @ORM\Column(name="eventDate", type="date")
     * @Assert\NotBlank()
     * @Assert\DateTime()
     */
    private $eventDate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="pickupDate", type="datetime")
     * @Assert\NotBlank()
     * @Assert\DateTime()
     */
    private $pickupDate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="returnDate", type="datetime")
     * @Assert\NotBlank()
     * @Assert\DateTime()
     */
    private $returnDate;
    
    /**
     * @var string
     *
     * @ORM\Column(name="specialInstruction", type="text", nullable=true)
     */
    private $specialInstruction;
    
    /**
     * @var string
     *
     * @ORM\Column(name="facultyFirstName", type="string", length=40)
     */
    private $facultyFirstName;
    
    /**
     * @var string
     *
     * @ORM\Column(name="facultyLastName", type="string", length=40)
     */
    private $facultyLastName;
    
    /**
     * @ORM\ManyToOne(targetEntity="liaisonSubject")
     * @ORM\JoinColumn(name="liaisonsubject_id", referencedColumnName="id")
     */
    private $facultySubject;
    
    /**
     * @ORM\OneToMany(targetEntity="AvRequestEvent", mappedBy="avrequest", cascade={"persist"})
     */
    private $events;
    
    /**
     * @ORM\OneToMany(targetEntity="AvRequestEquipmentQuantity", mappedBy="avrequest", cascade={"persist"})
     */
    private $equipment;

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
     * @Gedmo\Blameable(on="change", field={"eventDate", "pickupDate", "returnDate"})
     */
    private $contentChangedBy;

    public function __construct() {
      $this->events = new ArrayCollection();
      $this->equipment = new ArrayCollection();
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
     * Add events
     *
     * @param AppBundle\Entity\AvRequestEvent $event
     * @return AvRequest
     */
    public function addEvent(AvRequestEvent $event)
    {
        $event->setAvRequest($this); //also add this avrequest as the foreign key of the event
        $this->events->add($event);

        return $this;
    }

    /**
     * Remove events
     *
     * @param AppBundle\Entity\AvRequestEvent $event
     * @return AvRequest
     */
    public function removeEvent(AvRequestEvent $event)
    {
        $this->events->removeElement($event);
        
        return $this;
    }
    
    /**
     * Get events
     *
     * @return AppBundle\Entity\AvRequestEvent
     */
    public function getEvent()
    {
        return $this->events;
    }

    /**
     * Add equipment
     *
     * @param AppBundle\Entity\AvRequestEquipmentQuantity  $equipment
     * @return AvRequest
     */
    public function addEquipment(AvRequestEquipmentQuantity  $equipment)
    {
        //$equipment->setAvRequest($this); //also add this avrequest as the foreign key of the event
        $this->equipment->add($equipment);

        return $this;
    }

    /**
     * Remove equipment
     *
     * @param AppBundle\Entity\AvRequestEquipmentQuantity  $equipment
     * @return AvRequest
     */
    public function removeEquipment(AvRequestEquipmentQuantity $equipment)
    {
        $this->equipment->removeElement($equipment);
        
        return $this;
    }
    
    /**
     * Get equipment
     *
     * @return AppBundle\Entity\AvRequestEquipmentQuantity 
     */
    public function getEquipment()
    {
        return $this->equipment;
    }
    
    /**
     * Set eventDate
     *
     * @param \DateTime $eventDate
     *
     * @return AvRequest
     */
    public function setEventDate(\DateTime $eventDate)
    {
        $this->eventDate = $eventDate;

        return $this;
    }

    /**
     * Get eventDate
     *
     * @return \DateTime
     */
    public function getEventDate()
    {
        return $this->eventDate;
    }

    /**
     * Set deliverDate
     *
     * @param \DateTime $pickupDate
     *
     * @return AvRequest
     */
    public function setPickupDate($pickupDate)
    {
        $this->pickupDate = $pickupDate;

        return $this;
    }

    /**
     * Get pickupDate
     *
     * @return \DateTime
     */
    public function getPickupDate()
    {
        return $this->pickupDate;
    }

    /**
     * Set returnDate
     *
     * @param \DateTime $returnDate
     *
     * @return AvRequest
     */
    public function setReturnDate($returnDate)
    {
        $this->returnDate = $returnDate;

        return $this;
    }

    /**
     * Get returnDate
     *
     * @return \DateTime
     */
    public function getReturnDate()
    {
        return $this->returnDate;
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
    
    /**
     * Set specialInstruction
     *
     * @param string $specialInstruction
     *
     * @return AvRequest
     */
    public function setSpecialInstruction($specialInstruction)
    {
        $this->specialInstruction = $specialInstruction;

        return $this;
    }

    /**
     * Get specialInstruction
     *
     * @return string
     */
    public function getSpecialInstruction()
    {
        return $this->specialInstruction;
    }
}

