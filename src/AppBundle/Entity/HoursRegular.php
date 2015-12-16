<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\JoinColumn;

/**
 * HoursRegular
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class HoursRegular
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
     * @var integer
     *
     * @ORM\Column(name="dayOfWeek", type="integer")
     */
    private $dayOfWeek;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="openTime", type="time")
     */
    private $openTime;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="closeTime", type="time")
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
     * @var HoursSemester
     * 
     * @ORM\ManyToOne(targetEntity="HoursSemester", cascade={"persist"}, fetch="LAZY")
     * @JoinColumn(name="semester", referencedColumnName="id")
     */
    private $semester;
    
    /**
     * @var HoursArea
     * 
     * @ORM\ManyToOne(targetEntity="HoursArea", cascade={"remove"}, fetch="LAZY")
     * @JoinColumn(name="area", referencedColumnName="id", onDelete="CASCADE")
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
     * Set dayOfWeek
     *
     * @param integer $dayOfWeek
     *
     * @return HoursRegular
     */
    public function setDayOfWeek($dayOfWeek)
    {
        $this->dayOfWeek = $dayOfWeek;

        return $this;
    }

    /**
     * Get dayOfWeek
     *
     * @return integer
     */
    public function getDayOfWeek()
    {
        return $this->dayOfWeek;
    }

    /**
     * Set openTime
     *
     * @param \DateTime $openTime
     *
     * @return HoursRegular
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
     * @return HoursRegular
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
     * @return HoursRegular
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
     * @return HoursRegular
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
     * Get semester
     *
     * @return HoursSemester
     */
    public function getSemester()
    {
        return $this->semester;
    }
    
    /**
     * Set semester
     *
     * @param \AppBundle\Entity\HoursSemester $semester
     *
     * @return HoursRegular
     */
    public function setSemester(\AppBundle\Entity\HoursSemester $semester = null)
    {
        $this->semester = $semester;

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
     * @return HoursRegular
     */
    public function setArea(\AppBundle\Entity\HoursArea $area = null)
    {
        $this->area = $area;

        return $this;
    }
}

