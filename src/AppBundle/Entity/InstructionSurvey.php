<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;
use AppBundle\Entity\User;
use AppBundle\Entity\Instruction;
use JMS\Serializer\Annotation as Serializer;
use Hateoas\Configuration\Annotation as Hateoas;

/**
 * InstructionSurvey
 *
 * @ORM\Table()
 * @ORM\Entity
 * 
 * @Serializer\XmlRoot("instructionSurvey")
 * @Hateoas\Relation("self", href="expr('/api/instructionsurvey/' ~ object.getStaffId())")
 * @Hateoas\Relation(
 *    "instruction",
 *    href = "expr('/api/instructionsurvey/sessiondata' ~ object.getInstruction().getId())",
 *    embedded = "expr(object.getInstruction())",
 *    exclusion = @Hateoas\Exclusion(excludeIf = "expr(object.getInstruction() === null)")
 * )
 */
class InstructionSurvey
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
     * @ORM\Column(name="studentFirstName", type="string", length=30, nullable=true)
     */
    private $studentFirstName;

    /**
     * @var string
     *
     * @ORM\Column(name="studentLastName", type="string", length=40, nullable=true)
     */
    private $studentLastName;

    /**
     * @var string
     *
     * @ORM\Column(name="studentEmail", type="string", length=70, nullable=true)
     */
    private $studentEmail;

    /**
     * @var integer
     *
     * @ORM\Column(name="questionLearnedSomething", type="smallint")
     */
    private $questionLearnedSomething;

    /**
     * @var integer
     *
     * @ORM\Column(name="questionSkillsImproved", type="smallint")
     */
    private $questionSkillsImproved;

    /**
     * @var integer
     *
     * @ORM\Column(name="questionRelevantSession", type="smallint")
     */
    private $questionRelevantSession;

    /**
     * @var integer
     *
     * @ORM\Column(name="questionKnowledgableSpeaker", type="smallint")
     */
    private $questionKnowledgableSpeaker;

    /**
     * @var integer
     *
     * @ORM\Column(name="questionClearlyExplained", type="smallint")
     */
    private $questionClearlyExplained;

    /**
     * @var boolean
     *
     * @ORM\Column(name="questionIsFirstSession", type="boolean")
     */
    private $questionIsFirstSession;

    /**
     * @var boolean
     *
     * @ORM\Column(name="questionDidUseEsearch", type="boolean")
     */
    private $questionDidUseEsearch;

    /**
     * @var integer
     *
     * @ORM\Column(name="questionEsearchRelevant", type="smallint")
     */
    private $questionEsearchRelevant;

    /**
     * @var string
     *
     * @ORM\Column(name="questionMostImportantThingLearned", type="text", nullable=true)
     */
    private $questionMostImportantThingLearned;
    
    /** 
     * @var array
     * 
     * @ORM\Column(name="questionOtherQuestions", type="text", nullable=true)
     */
    private $questionOtherQuestions;
    
    /**
     * @var string
     *
     * @ORM\Column(name="otherSuggestions", type="text", nullable=true)
     */
    private $otherSuggestions;
    
    /**
     * @ORM\ManyToOne(targetEntity="Instruction", cascade={"persist"}, fetch="LAZY")
     * @ORM\JoinColumn(name="instruction_id", referencedColumnName="id", nullable=true, onDelete="CASCADE")
     * @Serializer\Exclude //exclude from API calls 
     */
    private $instruction;
    
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
     * @var User $updatedBy
     *
     * @Gedmo\Blameable(on="update")
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumn(referencedColumnName="id")
     * @Serializer\Exclude //exclude from API calls 
     */
    private $updatedBy;
    
    /**
     * @var User $contentChangedBy
     *
     * @Gedmo\Blameable(on="change", field={"course", "instructionDate", "startTime", "endTime", "level", "levelDescription", "note", "program"})
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumn(referencedColumnName="id")
     * @Serializer\Exclude //exclude from API calls 
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
     * Set studentFirstName
     *
     * @param string $studentFirstName
     *
     * @return InstructionSurvey
     */
    public function setStudentFirstName($studentFirstName)
    {
        $this->studentFirstName = $studentFirstName;

        return $this;
    }

    /**
     * Get studentFirstName
     *
     * @return string
     */
    public function getStudentFirstName()
    {
        return $this->studentFirstName;
    }

    /**
     * Set studentLastName
     *
     * @param string $studentLastName
     *
     * @return InstructionSurvey
     */
    public function setStudentLastName($studentLastName)
    {
        $this->studentLastName = $studentLastName;

        return $this;
    }

    /**
     * Get studentLastName
     *
     * @return string
     */
    public function getStudentLastName()
    {
        return $this->studentLastName;
    }

    /**
     * Set studentEmail
     *
     * @param string $studentEmail
     *
     * @return InstructionSurvey
     */
    public function setStudentEmail($studentEmail)
    {
        $this->studentEmail = $studentEmail;

        return $this;
    }

    /**
     * Get studentEmail
     *
     * @return string
     */
    public function getStudentEmail()
    {
        return $this->studentEmail;
    }

    /**
     * Set questionLearnedSomething
     *
     * @param integer $questionLearnedSomething
     *
     * @return InstructionSurvey
     */
    public function setQuestionLearnedSomething($questionLearnedSomething)
    {
        $this->questionLearnedSomething = $questionLearnedSomething;

        return $this;
    }

    /**
     * Get questionLearnedSomething
     *
     * @return integer
     */
    public function getQuestionLearnedSomething()
    {
        return $this->questionLearnedSomething;
    }

    /**
     * Set questionSkillsImproved
     *
     * @param integer $questionSkillsImproved
     *
     * @return InstructionSurvey
     */
    public function setQuestionSkillsImproved($questionSkillsImproved)
    {
        $this->questionSkillsImproved = $questionSkillsImproved;

        return $this;
    }

    /**
     * Get questionSkillsImproved
     *
     * @return integer
     */
    public function getQuestionSkillsImproved()
    {
        return $this->questionSkillsImproved;
    }

    /**
     * Set questionRelevantSession
     *
     * @param integer $questionRelevantSession
     *
     * @return InstructionSurvey
     */
    public function setQuestionRelevantSession($questionRelevantSession)
    {
        $this->questionRelevantSession = $questionRelevantSession;

        return $this;
    }

    /**
     * Get questionRelevantSession
     *
     * @return integer
     */
    public function getQuestionRelevantSession()
    {
        return $this->questionRelevantSession;
    }

    /**
     * Set questionKnowledgableSpeaker
     *
     * @param integer $questionKnowledgableSpeaker
     *
     * @return InstructionSurvey
     */
    public function setQuestionKnowledgableSpeaker($questionKnowledgableSpeaker)
    {
        $this->questionKnowledgableSpeaker = $questionKnowledgableSpeaker;

        return $this;
    }

    /**
     * Get questionKnowledgableSpeaker
     *
     * @return integer
     */
    public function getQuestionKnowledgableSpeaker()
    {
        return $this->questionKnowledgableSpeaker;
    }

    /**
     * Set questionClearlyExplained
     *
     * @param integer $questionClearlyExplained
     *
     * @return InstructionSurvey
     */
    public function setQuestionClearlyExplained($questionClearlyExplained)
    {
        $this->questionClearlyExplained = $questionClearlyExplained;

        return $this;
    }

    /**
     * Get questionClearlyExplained
     *
     * @return integer
     */
    public function getQuestionClearlyExplained()
    {
        return $this->questionClearlyExplained;
    }

    /**
     * Set questionIsFirstSession
     *
     * @param boolean $questionIsFirstSession
     *
     * @return InstructionSurvey
     */
    public function setQuestionIsFirstSession($questionIsFirstSession)
    {
        $this->questionIsFirstSession = $questionIsFirstSession;

        return $this;
    }

    /**
     * Get questionIsFirstSession
     *
     * @return boolean
     */
    public function getQuestionIsFirstSession()
    {
        return $this->questionIsFirstSession;
    }

    /**
     * Set questionDidUseEsearch
     *
     * @param boolean $questionDidUseEsearch
     *
     * @return InstructionSurvey
     */
    public function setQuestionDidUseEsearch($questionDidUseEsearch)
    {
        $this->questionDidUseEsearch = $questionDidUseEsearch;

        return $this;
    }

    /**
     * Get questionDidUseEsearch
     *
     * @return boolean
     */
    public function getQuestionDidUseEsearch()
    {
        return $this->questionDidUseEsearch;
    }

    /**
     * Set questionEsearchRelevant
     *
     * @param integer $questionEsearchRelevant
     *
     * @return InstructionSurvey
     */
    public function setQuestionEsearchRelevant($questionEsearchRelevant)
    {
        $this->questionEsearchRelevant = $questionEsearchRelevant;

        return $this;
    }

    /**
     * Get questionEsearchRelevant
     *
     * @return integer
     */
    public function getQuestionEsearchRelevant()
    {
        return $this->questionEsearchRelevant;
    }
    
    /**
     * Set questionMostImportantThingLearned
     *
     * @param string $questionMostImportantThingLearned
     *
     * @return InstructionSurvey
     */
    public function setQuestionMostImportantThingLearned($questionMostImportantThingLearned)
    {
        $this->questionMostImportantThingLearned = $questionMostImportantThingLearned;

        return $this;
    }

    /**
     * Get questionMostImportantThingLearned
     *
     * @return string
     */
    public function getQuestionMostImportantThingLearned()
    {
        return $this->questionMostImportantThingLearned;
    }
    
    /**
     * Get questionOtherQuestions
     *
     * @return String 
     */
    public function getQuestionOtherQuestions()
    {
        return $this->questionOtherQuestions;
    }
    /**
     * Set otherSuggestions
     *
     * @param string $questionOtherQuestions
     *
     * @return InstructionSurvey
     */
    public function setQuestionOtherQuestions($questionOtherQuestions)
    {
        $this->questionOtherQuestions = $questionOtherQuestions;

        return $this;
    }

    /**
     * Set otherSuggestions
     *
     * @param string $otherSuggestions
     *
     * @return InstructionSurvey
     */
    public function setOtherSuggestions($otherSuggestions)
    {
        $this->otherSuggestions = $otherSuggestions;

        return $this;
    }

    /**
     * Get otherSuggestions
     *
     * @return string
     */
    public function getOtherSuggestions()
    {
        return $this->otherSuggestions;
    }
    
    /**
     * Set instruction
     *
     * @param \AppBundle\Entity\Instruction $instruction
     *
     * @return InstructionSurvey
     */
    public function setInstruction(Instruction $instruction = null)
    {
        $this->instruction = $instruction;

        return $this;
    }

    /**
     * Get instruction
     *
     * @return \AppBundle\Entity\Instruction
     */
    public function getInstruction()
    {
        return $this->instruction;
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
}

