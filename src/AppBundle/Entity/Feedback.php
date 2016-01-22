<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use AppBundle\Entity\FeedbackArea;
use Doctrine\Common\Collections\ArrayCollection;

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
     * @ORM\Column(name="patronEmail", type="string", length=255)
     */
    private $patronEmail;

    /**
     * @var string
     *
     * @ORM\Column(name="patronFirstName", type="string", length=40)
     */
    private $patronFirstName;

    /**
     * @var string
     *
     * @ORM\Column(name="patronLastName", type="string", length=40)
     */
    private $patronLastName;

    /**
     * @var string
     *
     * @ORM\Column(name="patronPhone", type="string", length=15)
     */
    private $patronPhone;

    /**
     * @var integer
     *
     * @ORM\Column(name="patronStatus", type="smallint")
     */
    private $patronStatus;

    /**
     * @var string
     *
     * @ORM\Column(name="response", type="text")
     */
    private $response;

    /**
     * @var string
     *
     * @ORM\Column(name="forwardedTo", type="string", length=50)
     */
    private $forwardedTo;

    /**
     * @var string
     *
     * @ORM\Column(name="forwardedMessage", type="text")
     */
    private $forwardedMessage;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="replyDate", type="datetime")
     */
    private $replyDate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="forwardDate", type="datetime")
     */
    private $forwardDate;
    
    /**
     * @ORM\ManyToMany(targetEntity="FeedbackArea")
     * @ORM\JoinTable(name="feedback_feedbackarea",
     *      joinColumns={@ORM\JoinColumn(name="feedback_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="feedbackarea_id", referencedColumnName="id")}
     *      )
     */
    private $areas;
    
    /**
     * @ORM\ManyToOne(targetEntity="FeedbackCategory", cascade={"persist"}, fetch="LAZY")
     * @ORM\JoinColumn(name="feedbackcategory_id", referencedColumnName="id", nullable=true, onDelete="SET NULL")
     */
    private $category;

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
    public function setReceivedDate($receivedDate)
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
     * Set patronStatus
     *
     * @param integer $patronStatus
     *
     * @return Feedback
     */
    public function setPatronStatus($patronStatus)
    {
        $this->patronStatus = $patronStatus;
    
        return $this;
    }

    /**
     * Get patronStatus
     *
     * @return integer
     */
    public function getPatronStatus()
    {
        return $this->patronStatus;
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
     * Set forwardedTo
     *
     * @param string $forwardedTo
     *
     * @return Feedback
     */
    public function setForwardedTo($forwardedTo)
    {
        $this->forwardedTo = $forwardedTo;
    
        return $this;
    }

    /**
     * Get forwardedTo
     *
     * @return string
     */
    public function getForwardedTo()
    {
        return $this->forwardedTo;
    }

    /**
     * Set forwardedMessage
     *
     * @param string $forwardedMessage
     *
     * @return Feedback
     */
    public function setForwardedMessage($forwardedMessage)
    {
        $this->forwardedMessage = $forwardedMessage;
    
        return $this;
    }

    /**
     * Get forwardedMessage
     *
     * @return string
     */
    public function getForwardedMessage()
    {
        return $this->forwardedMessage;
    }

    /**
     * Set replyDate
     *
     * @param \DateTime $replyDate
     *
     * @return Feedback
     */
    public function setReplyDate($replyDate)
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
     * Set forwardDate
     *
     * @param \DateTime $forwardDate
     *
     * @return Feedback
     */
    public function setForwardDate($forwardDate)
    {
        $this->forwardDate = $forwardDate;
    
        return $this;
    }

    /**
     * Get forwardDate
     *
     * @return \DateTime
     */
    public function getForwardDate()
    {
        return $this->forwardDate;
    }
    
    /**
     * Set feedbackArea
     *
     * @param \AppBundle\Entity\FeedbackArea $feedbackArea
     *
     * @return Feedback
     */
    public function setArea(\AppBundle\Entity\FeedbackArea $feedbackArea = null)
    {
        $this->area = $feedbackArea;

        return $this;
    }

    /**
     * Get feedbackArea
     *
     * @return \AppBundle\Entity\FeedbackArea
     */
    public function getArea()
    {
        return $this->area;
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
}

