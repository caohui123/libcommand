<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;
use AppBundle\Entity\AvRequestEvent;
use AppBundle\Entity\AvRequestEquipmentQuantity;
use AppBundle\Entity\LiaisonSubject;

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
     * @ORM\ManyToOne(targetEntity="LiaisonSubject")
     * @ORM\JoinColumn(name="liaisonsubject_id", referencedColumnName="id", nullable=true)
     */
    private $facultySubject;
    
    /**
     * @var string
     *
     * @ORM\Column(name="facultyPhone", type="string", length=15)
     */
    private $facultyPhone;
    
    /**
     * @var string
     *
     * @ORM\Column(name="facultyEmail", type="string", length=40)
     */
    private $facultyEmail;
    
    /**
     * @var string
     *
     * @ORM\Column(name="course", type="string", length=15, nullable=true)
     */
    private $course;
    
    /**
     * @var smallint
     *
     * @ORM\Column(name="attendees", type="smallint", nullable=true)
     */
    private $attendees;
    
    /**
     * @var string
     *
     * @ORM\Column(name="studentName", type="string", length=40, nullable=true)
     */
    private $studentName;
    
    /**
     * @var string
     *
     * @ORM\Column(name="studentEnumber", type="string", length=10, nullable=true)
     */
    private $studentEnumber;
    
    /**
     * @ORM\OneToMany(targetEntity="AvRequestEvent", mappedBy="avrequest", cascade={"persist"})
     */
    private $events;
    
    /**
     * @ORM\OneToMany(targetEntity="AvRequestEquipmentQuantity", mappedBy="avrequest", cascade={"persist"})
     */
    private $equipment;
    
    /**
     * @var string
     *
     * @ORM\Column(name="note", type="text", nullable=true)
     */
    private $note;
    
    /**
     * @ORM\ManyToOne(targetEntity="AvRequestStatus")
     * @ORM\JoinColumn(name="avrequeststatus_id", referencedColumnName="id", nullable=true)
     */
    private $status;
    
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="replyDate", type="datetime", nullable=true)
     * @Assert\DateTime()
     */
    private $replyDate;
    
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
     * @Gedmo\Blameable(on="change", field={"eventDate", "pickupDate", "returnDate", "status", "note"})
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
        $equipment->setAvRequest($this); //also add this avrequest as the foreign key of the equipment
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
    
    function getFacultyFirstName() {
      return $this->facultyFirstName;
    }

    function getFacultyLastName() {
      return $this->facultyLastName;
    }

    function getFacultyPhone() {
      return $this->facultyPhone;
    }

    function getFacultyEmail() {
      return $this->facultyEmail;
    }

    function getCourse() {
      return $this->course;
    }

    function getAttendees() {
      return $this->attendees;
    }

    function getStudentName() {
      return $this->studentName;
    }

    function getStudentEnumber() {
      return $this->studentEnumber;
    }
    
    function getNote() {
      return $this->note;
    }

    function setFacultyFirstName($facultyFirstName) {
      $this->facultyFirstName = $facultyFirstName;
      return $this;
    }

    function setFacultyLastName($facultyLastName) {
      $this->facultyLastName = $facultyLastName;
      return $this;
    }

    function setFacultyPhone($facultyPhone) {
      $this->facultyPhone = $facultyPhone;
      return $this;
    }

    function setFacultyEmail($facultyEmail) {
      $this->facultyEmail = $facultyEmail;
      return $this;
    }

    function setCourse($course) {
      $this->course = $course;
      return $this;
    }

    function setAttendees($attendees) {
      $this->attendees = $attendees;
      return $this;
    }

    function setStudentName($studentName) {
      $this->studentName = $studentName;
      return $this;
    }

    function setStudentEnumber($studentEnumber) {
      $this->studentEnumber = $studentEnumber;
      return $this;
    }
    
    function setNote($note) {
      $this->note = $note;
      return $this;
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
     * Set av request status
     *
     * @param AppBundle\Entity\AvRequestStatus $status
     *
     * @return AvRequest
     */
    function setStatus(AvRequestStatus $status) {
      $this->status = $status;
      return $this;
    }
    
    /**
     * Get av request status
     *
     * @return AppBundle\Entity\AvRequestStatus
     */
    function getStatus() {
      return $this->status;
    }
    
    /**
     * Set replyDate
     *
     * @param \DateTime $replyDate
     *
     * @return AvRequest
     */
    public function setReplyDate(\DateTime $replyDate)
    {
        $this->replyDate = $replyDate;

        return $this;
    }

    /**
     * Get replyDate
     *
     * @return \DateTime
     */
    public function getReplyDate()
    {
        return $this->replyDate;
    }
}

