<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\JoinColumn;

/**
 * HoursSpecial
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class HoursSpecial
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
     * @ORM\Column(name="openTime", type="date")
     */
    private $openTime;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="closeTime", type="date")
     */
    private $closeTime;

    /**
     * @var boolean
     *
     * @ORM\Column(name="is24Hour", type="boolean")
     */
    private $is24Hour;

    /**
     * @var boolean
     *
     * @ORM\Column(name="isClosed", type="boolean")
     */
    private $isClosed;
    
    /**
     * @var HoursEvent
     * 
     * @ORM\ManyToOne(targetEntity="HoursEvent", cascade={"persist"}, fetch="LAZY")
     * @JoinColumn(name="event", referencedColumnName="id")
     */
    private $event;
    
    /**
     * @var HoursArea
     * 
     * @ORM\ManyToOne(targetEntity="HoursArea", cascade={"persist"}, fetch="LAZY")
     * @JoinColumn(name="area", referencedColumnName="id")
     */
    private $area;


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
     * Set openTime
     *
     * @param \DateTime $openTime
     *
     * @return HoursSpecial
     */
    public function setOpenTime($openTime)
    {
        $this->openTime = $openTime;

        return $this;
    }

    /**
     * Get openTime
     *
     * @return \DateTime
     */
    public function getOpenTime()
    {
        return $this->openTime;
    }

    /**
     * Set closeTime
     *
     * @param \DateTime $closeTime
     *
     * @return HoursSpecial
     */
    public function setCloseTime($closeTime)
    {
        $this->closeTime = $closeTime;

        return $this;
    }

    /**
     * Get closeTime
     *
     * @return \DateTime
     */
    public function getCloseTime()
    {
        return $this->closeTime;
    }

    /**
     * Set is24Hour
     *
     * @param boolean $is24Hour
     *
     * @return HoursSpecial
     */
    public function setIs24Hour($is24Hour)
    {
        $this->is24Hour = $is24Hour;

        return $this;
    }

    /**
     * Get is24Hour
     *
     * @return boolean
     */
    public function getIs24Hour()
    {
        return $this->is24Hour;
    }

    /**
     * Set isClosed
     *
     * @param boolean $isClosed
     *
     * @return HoursSpecial
     */
    public function setIsClosed($isClosed)
    {
        $this->isClosed = $isClosed;

        return $this;
    }

    /**
     * Get isClosed
     *
     * @return boolean
     */
    public function getIsClosed()
    {
        return $this->isClosed;
    }
    
    /**
     * Get event
     *
     * @return HoursEvent
     */
    public function getEvent()
    {
        return $this->event;
    }
    
    /**
     * Set event
     *
     * @param \AppBundle\Entity\HoursEvent $event
     *
     * @return HoursSpecial
     */
    public function setEvent(\AppBundle\Entity\HoursEvent $event = null)
    {
        $this->event = $event;

        return $this;
    }
    
    /**
     * Get area
     *
     * @return HoursArea
     */
    public function getArea()
    {
        return $this->area;
    }
    
    /**
     * Set area
     *
     * @param \AppBundle\Entity\HoursArea $area
     *
     * @return HoursSpecial
     */
    public function setArea(\AppBundle\Entity\HoursArea $area = null)
    {
        $this->area = $area;

        return $this;
    }
}

