<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\JoinColumn;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Doctrine\Common\Collections\ArrayCollection;
use JMS\Serializer\Annotation as Serializer;
use Hateoas\Configuration\Annotation as Hateoas;
use AppBundle\Entity\RoomRequestEquipment;
use AppBundle\Entity\RoomRequestRoom;
use AppBundle\Entity\LiaisonSubject;

/**
 * RoomRequest
 *
 * @ORM\Table()
 * @ORM\Entity
 * 
 * @Serializer\XmlRoot("roomrequest")
 * @Hateoas\Relation("self", href="expr('/api/roomrequest/' ~ object.getId())")
 */
class RoomRequest
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
     * @ORM\Column(name="reserveDate", type="date")
     */
    private $reserveDate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="startTime", type="time")
     */
    private $startTime;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="endTime", type="time")
     */
    private $endTime;

    /**
     * @var string
     *
     * @ORM\Column(name="facultyFirstName", type="string", length=50)
     */
    private $facultyFirstName;

    /**
     * @var string
     *
     * @ORM\Column(name="facultyLastName", type="string", length=50)
     */
    private $facultyLastName;

    /**
     * @ORM\ManyToOne(targetEntity="LiaisonSubject")
     * @ORM\JoinColumn(name="liaisonsubject_id", referencedColumnName="id", nullable=true)
     */
    private $facultySubject;

    /**
     * @var string
     *
     * @ORM\Column(name="event", type="string", length=50)
     */
    private $event;

    /**
     * @var integer
     *
     * @ORM\Column(name="attendees", type="integer")
     */
    private $attendees;

    /**
     * @var string
     *
     * @ORM\Column(name="facultyPhone", type="string", length=15)
     */
    private $facultyPhone;

    /**
     * @var string
     *
     * @ORM\Column(name="facultyEmail", type="string", length=70)
     */
    private $facultyEmail;

    /**
     * @var boolean
     *
     * @ORM\Column(name="isTrainingNeeded", type="boolean")
     */
    private $isTrainingNeeded;

    /**
     * @var string
     *
     * @ORM\Column(name="otherDetails", type="text")
     */
    private $otherDetails;

    /**
     * @var string
     *
     * @ORM\Column(name="note", type="text", nullable=true)
     */
    private $note;
    
    /**
     * @ORM\ManyToMany(targetEntity="RoomRequestEquipment", inversedBy="roomrequest")
     * @ORM\JoinTable(name="roomrequests_equipment",
     *      joinColumns={@ORM\JoinColumn(name="roomrequest_id", referencedColumnName="id", onDelete="cascade")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="equipment_id", referencedColumnName="id", onDelete="cascade")},
     *      )
     */
    private $equipment;
    
    /**
     * @ORM\ManyToOne(targetEntity="RoomRequestRoom", cascade={"persist"}, fetch="LAZY")
     * @ORM\JoinColumn(name="room_id", referencedColumnName="id", nullable=true, onDelete="SET NULL")
     */
    private $room;
    
    
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
     * @Serializer\Exclude //exclude from API calls 
     */
    private $updated;
    
    /**
     * @var string $contentChangedBy
     *
     * @ORM\Column(name="content_changed_by", type="string", nullable=true)
     * @Gedmo\Blameable(on="change", field={"note"})
     * @Serializer\Exclude //exclude from API calls 
     */
    private $contentChangedBy;
    
    public function __construct() {
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
     * Set reserveDate
     *
     * @param \DateTime $reserveDate
     *
     * @return RoomRequest
     */
    public function setReserveDate($reserveDate)
    {
        $this->reserveDate = $reserveDate;

        return $this;
    }

    /**
     * Get reserveDate
     *
     * @return \DateTime
     */
    public function getReserveDate()
    {
        return $this->reserveDate;
    }

    /**
     * Set startTime
     *
     * @param \DateTime $startTime
     *
     * @return RoomRequest
     */
    public function setStartTime($startTime)
    {
        $this->startTime = $startTime;

        return $this;
    }

    /**
     * Get startTime
     *
     * @return \DateTime
     */
    public function getStartTime()
    {
        return $this->startTime;
    }

    /**
     * Set endTime
     *
     * @param \DateTime $endTime
     *
     * @return RoomRequest
     */
    public function setEndTime($endTime)
    {
        $this->endTime = $endTime;

        return $this;
    }

    /**
     * Get endTime
     *
     * @return \DateTime
     */
    public function getEndTime()
    {
        return $this->endTime;
    }

    /**
     * Set facultyFirstName
     *
     * @param string $facultyFirstName
     *
     * @return RoomRequest
     */
    public function setFacultyFirstName($facultyFirstName)
    {
        $this->facultyFirstName = $facultyFirstName;

        return $this;
    }

    /**
     * Get facultyFirstName
     *
     * @return string
     */
    public function getFacultyFirstName()
    {
        return $this->facultyFirstName;
    }

    /**
     * Set facultyLastName
     *
     * @param string $facultyLastName
     *
     * @return RoomRequest
     */
    public function setFacultyLastName($facultyLastName)
    {
        $this->facultyLastName = $facultyLastName;

        return $this;
    }

    /**
     * Get facultyLastName
     *
     * @return string
     */
    public function getFacultyLastName()
    {
        return $this->facultyLastName;
    }

    /**
     * Set facultySubject
     *
     * @param AppBundle\Entity\LiaisonSubject $liaisonSubject
     *
     * @return AvRequest
     */
    public function setFacultySubject(LiaisonSubject $liaisonSubject = null)
    {
        $this->facultySubject = $liaisonSubject;

        return $this;
    }

    /**
     * Get facultySubject
     *
     * @return AppBundle\Entity\LiaisonSubject
     */
    public function getFacultySubject()
    {
        return $this->facultySubject;
    }

    /**
     * Set event
     *
     * @param string $event
     *
     * @return RoomRequest
     */
    public function setEvent($event)
    {
        $this->event = $event;

        return $this;
    }

    /**
     * Get event
     *
     * @return string
     */
    public function getEvent()
    {
        return $this->event;
    }

    /**
     * Set attendees
     *
     * @param integer $attendees
     *
     * @return RoomRequest
     */
    public function setAttendees($attendees)
    {
        $this->attendees = $attendees;

        return $this;
    }

    /**
     * Get attendees
     *
     * @return integer
     */
    public function getAttendees()
    {
        return $this->attendees;
    }

    /**
     * Set facultyPhone
     *
     * @param string $facultyPhone
     *
     * @return RoomRequest
     */
    public function setFacultyPhone($facultyPhone)
    {
        $this->facultyPhone = $facultyPhone;

        return $this;
    }

    /**
     * Get facultyPhone
     *
     * @return string
     */
    public function getFacultyPhone()
    {
        return $this->facultyPhone;
    }

    /**
     * Set facultyEmail
     *
     * @param string $facultyEmail
     *
     * @return RoomRequest
     */
    public function setFacultyEmail($facultyEmail)
    {
        $this->facultyEmail = $facultyEmail;

        return $this;
    }

    /**
     * Get facultyEmail
     *
     * @return string
     */
    public function getFacultyEmail()
    {
        return $this->facultyEmail;
    }

    /**
     * Set isTrainingNeeded
     *
     * @param boolean $isTrainingNeeded
     *
     * @return RoomRequest
     */
    public function setIsTrainingNeeded($isTrainingNeeded)
    {
        $this->isTrainingNeeded = $isTrainingNeeded;

        return $this;
    }

    /**
     * Get isTrainingNeeded
     *
     * @return boolean
     */
    public function getIsTrainingNeeded()
    {
        return $this->isTrainingNeeded;
    }

    /**
     * Set otherDetails
     *
     * @param string $otherDetails
     *
     * @return RoomRequest
     */
    public function setOtherDetails($otherDetails)
    {
        $this->otherDetails = $otherDetails;

        return $this;
    }

    /**
     * Get otherDetails
     *
     * @return string
     */
    public function getOtherDetails()
    {
        return $this->otherDetails;
    }

    /**
     * Set note
     *
     * @param string $note
     *
     * @return RoomRequest
     */
    public function setNote($note)
    {
        $this->note = $note;

        return $this;
    }

    /**
     * Get note
     *
     * @return string
     */
    public function getNote()
    {
        return $this->note;
    }
    
    /**
     * Add equipment
     *
     * @param AppBundle\Entity\RoomRequestEquipment $equipment
     * @return RoomRequest
     */
    public function addEquipment(RoomRequestEquipment $equipment)
    {
        $this->equipment->add($equipment);

        return $this;
    }

    /**
     * Remove equipment
     *
     * @param AppBundle\Entity\RoomRequestEquipment $equipment
     * @return RoomRequest
     */
    public function removeEquipment(RoomRequestEquipment $equipment)
    {
        $this->equipment->removeElement($equipment);
        
        return $this;
    }
    
    /**
     * Get equipment
     *
     * @return AppBundle\Entity\RoomRequestEquipment
     */
    public function getEquipment()
    {
        return $this->equipment;
    }
    
    /**
     * Set room
     *
     * @param AppBundle\Entity\RoomRequestRoom $room
     *
     * @return RoomRequest
     */
    function setRoom(RoomRequestRoom $room) {
      $this->room = $room;
      return $this;
    }
    
    /**
     * Get room
     *
     * @return AppBundle\Entity\RoomRequestRoom
     */
    function getRoom() {
      return $this->room;
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
}

