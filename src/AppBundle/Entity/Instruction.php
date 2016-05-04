<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;
use AppBundle\Entity\User;

/**
 * Instruction
 *
 * @ORM\Table()
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 * @ORM\InheritanceType("JOINED")
 * @ORM\DiscriminatorColumn(name="class_name", type="string")
 * @ORM\DiscriminatorMap({
 *  "AppBundle\Entity\GroupInstruction"     = "AppBundle\Entity\GroupInstruction",
 *  "AppBundle\Entity\IndividualInstruction" = "AppBundle\Entity\IndividualInstruction",
 * })
 */
abstract class Instruction
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
     * @ORM\ManyToOne(targetEntity="Staff")
     * @ORM\JoinColumn(name="staff_id", referencedColumnName="id")
     */
    private $librarian;

    /**
     * @var string
     *
     * @ORM\Column(name="course", type="string", length=20)
     */
    private $course;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="instructionDate", type="date")
     */
    private $instructionDate;

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
     * @ORM\ManyToOne(targetEntity="LiaisonSubject")
     * @ORM\JoinColumn(name="program_id", referencedColumnName="id")
     */
    private $program;
    
    /**
     * @var string
     *
     * @ORM\Column(name="level", type="string", length=20)
     */
    private $level;
    
    /**
     * @var string
     *
     * @ORM\Column(name="levelDescription", type="text", nullable=true)
     */
    private $levelDescription;

    /**
     * @var string
     *
     * @ORM\Column(name="note", type="text", nullable=true)
     */
    private $note;
    
    /**
     * @var \DateTime $created
     *
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(type="datetime")
     */
    private $created;
    
    /**
     * @var User $createdBy
     *
     * @Gedmo\Blameable(on="create")
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumn(referencedColumnName="id")
     */
    private $createdBy;

    /**
     * @var \DateTime $updated
     *
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(type="datetime")
     */
    private $updated;
    
    /**
     * @var User $updatedBy
     *
     * @Gedmo\Blameable(on="update")
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumn(referencedColumnName="id")
     */
    private $updatedBy;
    
    /**
     * @var User $contentChangedBy
     *
     * @Gedmo\Blameable(on="change", field={"course", "instructionDate", "startTime", "endTime", "level", "levelDescription", "note", "program"})
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumn(referencedColumnName="id")
     */
    private $contentChangedBy;


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
     * Set librarian
     *
     * @param AppBundle\Entity\Staff $librarian
     *
     * @return Instruction
     */
    public function setLibrarian(Staff $librarian)
    {
        $this->librarian = $librarian;

        return $this;
    }

    /**
     * Get librarian
     *
     * @return AppBundle\Entity\Staff
     */
    public function getLibrarian()
    {
        return $this->librarian;
    }

    /**
     * Set course
     *
     * @param string $course
     *
     * @return Instruction
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
     * Set instructionDate
     *
     * @param \DateTime $instructionDate
     *
     * @return Instruction
     */
    public function setInstructionDate($instructionDate)
    {
        $this->instructionDate = $instructionDate;

        return $this;
    }

    /**
     * Get instructionDate
     *
     * @return \DateTime
     */
    public function getInstructionDate()
    {
        return $this->instructionDate;
    }

    /**
     * Set startTime
     *
     * @param \DateTime $startTime
     *
     * @return Instruction
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
     * @return Instruction
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
     * Set level
     *
     * @param string $level
     *
     * @return Instruction
     */
    public function setLevel($level)
    {
        $this->level = $level;

        return $this;
    }

    /**
     * Get level
     *
     * @return string
     */
    public function getLevel()
    {
        return $this->level;
    }

    /**
     * Set levelDescription
     *
     * @param string $levelDescription
     *
     * @return Instruction
     */
    public function setLevelDescription($levelDescription)
    {
        $this->levelDescription = $levelDescription;

        return $this;
    }

    /**
     * Get levelDescription
     *
     * @return string
     */
    public function getLevelDescription()
    {
        return $this->levelDescription;
    }
    
    /**
     * Set note
     *
     * @param string $note
     *
     * @return Instruction
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
     * Get createdBy
     * @return User
     */
    public function getCreatedBy()
    {
        return $this->createdBy;
    }
    public function setCreatedBy(User $createdBy)
    {
        $this->createdBy = $createdBy;
        
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
     * Get updatedBy
     *
     * @return User
     */
    public function getUpdatedBy()
    {
        return $this->updatedBy;
    }
    public function setUpdatedBy(User $updatedBy)
    {
        $this->updatedBy = $updatedBy;
        
        return $this;
    }

    /**
     * Get contentChangedBy
     *
     * @return User
     */
    public function getContentChangedBy()
    {
        return $this->contentChangedBy;
    }
    public function setContentChangedBy(User $changedby)
    {
        $this->contentChangedBy = $changedby;
        
        return $this;
    }
    
    /**
     * Get owner
     */
}

