<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;
use AppBundle\Entity\AvRequestEvent;

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
     * @ORM\OneToMany(targetEntity="AvRequestEvent", mappedBy="avrequest", cascade={"persist"})
     */
    private $events;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="requestDate", type="datetime")
     * @Assert\NotBlank()
     * @Assert\DateTime()
     */
    private $requestDate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="deliverDate", type="datetime")
     * @Assert\NotBlank()
     * @Assert\DateTime()
     */
    private $deliverDate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="returnDate", type="datetime")
     * @Assert\NotBlank()
     * @Assert\DateTime()
     */
    private $returnDate;

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
     * @Gedmo\Blameable(on="change", field={"title", "requestDate", "deliverDate", "returnDate"})
     */
    private $contentChangedBy;

    public function __construct() {
      $this->events = new ArrayCollection();
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
     * Set events
     *
     * @param AppBundle\Entity\AvRequestEvent $event
     * @return AvRequest
     */
    public function setEvent(AvRequestEvent $event)
    {
        $this->events[] = $event;

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
     * Set requestDate
     *
     * @param \DateTime $requestDate
     *
     * @return AvRequest
     */
    public function setRequestDate($requestDate)
    {
        $this->requestDate = $requestDate;

        return $this;
    }

    /**
     * Get requestDate
     *
     * @return \DateTime
     */
    public function getRequestDate()
    {
        return $this->requestDate;
    }

    /**
     * Set deliverDate
     *
     * @param \DateTime $deliverDate
     *
     * @return AvRequest
     */
    public function setDeliverDate($deliverDate)
    {
        $this->deliverDate = $deliverDate;

        return $this;
    }

    /**
     * Get deliverDate
     *
     * @return \DateTime
     */
    public function getDeliverDate()
    {
        return $this->deliverDate;
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
}

