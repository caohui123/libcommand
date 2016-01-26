<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use AppBundle\Entity\FeedbackArea;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\ExecutionContextInterface;

/**
 * Feedback
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Feedback
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
     * @ORM\Column(name="receivedDate", type="datetime")
     * @Assert\NotBlank()
     * @Assert\DateTime()
     */
    private $receivedDate;

    /**
     * @var string
     *
     * @ORM\Column(name="body", type="text")
     */
    private $body;

    /**
     * @var string
     *
     * @ORM\Column(name="patronEmail", type="string", length=50)
     */
    private $patronEmail;

    /**
     * @var string
     *
     * @ORM\Column(name="patronFirstName", type="string", length=40, nullable=true)
     */
    private $patronFirstName;

    /**
     * @var string
     *
     * @ORM\Column(name="patronLastName", type="string", length=40, nullable=true)
     */
    private $patronLastName;

    /**
     * @var string
     *
     * @ORM\Column(name="patronPhone", type="string", length=15, nullable=true)
     */
    private $patronPhone;

    /**
     * @var string
     *
     * @ORM\Column(name="response", type="text", nullable=true)
     */
    private $response;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="replyDate", type="datetime", nullable=true)
     */
    private $replyDate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="lastForwardDate", type="datetime", nullable=true)
     */
    private $lastForwardDate;
    
    /**
     * @ORM\ManyToMany(targetEntity="FeedbackArea")
     * @ORM\JoinTable(name="feedback_feedbackarea",
     *      joinColumns={@ORM\JoinColumn(name="feedback_id", referencedColumnName="id", nullable=true)},
     *      inverseJoinColumns={@ORM\JoinColumn(name="feedbackarea_id", referencedColumnName="id")}
     *      )
     */
    private $areas;
    
    /**
     * @ORM\ManyToOne(targetEntity="FeedbackCategory", cascade={"persist"}, fetch="LAZY")
     * @ORM\JoinColumn(name="feedbackcategory_id", referencedColumnName="id", nullable=true, onDelete="SET NULL")
     */
    private $category;
    
    /**
     * @ORM\ManyToOne(targetEntity="PatronGroup", cascade={"persist"}, fetch="LAZY")
     * @ORM\JoinColumn(name="patrongroup_id", referencedColumnName="id", nullable=true, onDelete="SET NULL")
     */
    private $patronGroup;

    public function __construct() {
        $this->areas = new ArrayCollection();
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
     * Set receivedDate
     *
     * @param \DateTime $receivedDate
     *
     * @return Feedback
     */
    public function setReceivedDate(\DateTime $receivedDate)
    {
        $this->receivedDate = $receivedDate;
    
        return $this;
    }

    /**
     * Get receivedDate
     *
     * @return \DateTime
     */
    public function getReceivedDate()
    {
        return $this->receivedDate;
    }

    /**
     * Set body
     *
     * @param string $body
     *
     * @return Feedback
     */
    public function setBody($body)
    {
        $this->body = $body;
    
        return $this;
    }

    /**
     * Get body
     *
     * @return string
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * Set patronEmail
     *
     * @param string $patronEmail
     *
     * @return Feedback
     */
    public function setPatronEmail($patronEmail)
    {
        $this->patronEmail = $patronEmail;
    
        return $this;
    }

    /**
     * Get patronEmail
     *
     * @return string
     */
    public function getPatronEmail()
    {
        return $this->patronEmail;
    }

    /**
     * Set patronFirstName
     *
     * @param string $patronFirstName
     *
     * @return Feedback
     */
    public function setPatronFirstName($patronFirstName)
    {
        $this->patronFirstName = $patronFirstName;
    
        return $this;
    }

    /**
     * Get patronFirstName
     *
     * @return string
     */
    public function getPatronFirstName()
    {
        return $this->patronFirstName;
    }

    /**
     * Set patronLastName
     *
     * @param string $patronLastName
     *
     * @return Feedback
     */
    public function setPatronLastName($patronLastName)
    {
        $this->patronLastName = $patronLastName;
    
        return $this;
    }

    /**
     * Get patronLastName
     *
     * @return string
     */
    public function getPatronLastName()
    {
        return $this->patronLastName;
    }

    /**
     * Set patronPhone
     *
     * @param string $patronPhone
     *
     * @return Feedback
     */
    public function setPatronPhone($patronPhone)
    {
        $this->patronPhone = $patronPhone;
    
        return $this;
    }

    /**
     * Get patronPhone
     *
     * @return string
     */
    public function getPatronPhone()
    {
        return $this->patronPhone;
    }

    /**
     * Set response
     *
     * @param string $response
     *
     * @return Feedback
     */
    public function setResponse($response)
    {
        $this->response = $response;
    
        return $this;
    }

    /**
     * Get response
     *
     * @return string
     */
    public function getResponse()
    {
        return $this->response;
    }

    /**
     * Set replyDate
     *
     * @param \DateTime $replyDate
     *
     * @return Feedback
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

    /**
     * Set lastForwardDate
     *
     * @param \DateTime $forwardDate
     *
     * @return Feedback
     */
    public function setLastForwardDate(\DateTime $forwardDate)
    {
        $this->lastForwardDate = $forwardDate;
    
        return $this;
    }

    /**
     * Get lastForwardDate
     *
     * @return \DateTime
     */
    public function getLastForwardDate()
    {
        return $this->lastForwardDate;
    }
    
    /**
     * Set feedbackArea
     *
     * @param \AppBundle\Entity\FeedbackArea $feedbackArea
     *
     * @return Feedback
     */
    public function setAreas(ArrayCollection $feedbackAreas = null)
    {
      foreach($feedbackAreas as $area){
        $this->areas[] = $area;
      }
      
      return $this;
    }

    /**
     * Get feedbackArea
     *
     * @return \AppBundle\Entity\FeedbackArea
     */
    public function getAreas()
    {
        return $this->areas;
    }
    
    /**
     * Set category
     *
     * @param \AppBundle\Entity\FeedbackCategory $category
     *
     * @return Feedback
     */
    public function setCategory(\AppBundle\Entity\FeedbackCategory $category = null)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Get category
     *
     * @return \AppBundle\Entity\FeedbackCategory
     */
    public function getCategory()
    {
        return $this->category;
    }
    
    /**
     * Set patron group
     *
     * @param \AppBundle\Entity\PatronGroup $patronGroup
     *
     * @return Feedback
     */
    public function setPatronGroup(\AppBundle\Entity\PatronGroup $patronGroup = null)
    {
        $this->patronGroup = $patronGroup;

        return $this;
    }

    /**
     * Get patron group
     *
     * @return \AppBundle\Entity\PatronGroup
     */
    public function getPatronGroup()
    {
        return $this->patronGroup;
    }
}

