<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * HoursSemester
 *
 * @ORM\Table()
 * @ORM\Entity
 * @UniqueEntity(fields={"season","year"}, message="Semester already exsits.")
 */
class HoursSemester
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
     * @ORM\Column(name="season", type="integer", length=1, nullable=false)
     */
    private $season;

    /**
     * @var integer
     *
     * @ORM\Column(name="year", type="integer", nullable=false)
     */
    private $year;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="startDate", type="date", nullable=false)
     */
    private $startDate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="endDate", type="date", nullable=false)
     */
    private $endDate;
    
    /**
     * Provides a unique value for each semester/year pair
     * Multiply the year by 10 and place the semeseter number in the 'ones' place
     * Ex. Fall 2015 = 20153, Winter 2016 = 20160, Spring 2016 = 20161, Summer 2016 = 20162
     * @var integer
     *
     * @ORM\Column(name="chronOrder", type="integer", nullable=false)
     */
    private $chronOrder;


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
     * Set name
     *
     * @param string $name
     *
     * @return HoursSemester
     */
    public function setSeason($season)
    {
        $this->season = $season;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getSeason()
    {
        return $this->season;
    }

    /**
     * Set year
     *
     * @param integer $year
     *
     * @return HoursSemester
     */
    public function setYear($year)
    {
        $this->year = $year;

        return $this;
    }

    /**
     * Get year
     *
     * @return integer
     */
    public function getYear()
    {
        return $this->year;
    }

    /**
     * Set startDate
     *
     * @param \DateTime $startDate
     *
     * @return HoursSemester
     */
    public function setStartDate($startDate)
    {
        $this->startDate = $startDate;

        return $this;
    }

    /**
     * Get startDate
     *
     * @return \DateTime
     */
    public function getStartDate()
    {
        return $this->startDate;
    }

    /**
     * Set endDate
     *
     * @param \DateTime $endDate
     *
     * @return HoursSemester
     */
    public function setEndDate($endDate)
    {
        $this->endDate = $endDate;

        return $this;
    }

    /**
     * Get endDate
     *
     * @return \DateTime
     */
    public function getEndDate()
    {
        return $this->endDate;
    }
    
    /**
     * Set chronOrder
     * 
     * @var int $chronOrder
     *
     * @return HoursSemester
     */
    public function setChronOrder($chronOrder)
    {
        $this->chronOrder = $chronOrder;

        return $this;
    }

    /**
     * Get endDate
     *
     * @return integer
     */
    public function getChronOrder()
    {
        return $this->chronOrder;
    }
    
    public function getSeasonYear(){
        
        switch($this->season){
            case 0:
                return 'Winter ' . $this->year;
            case 1;
                return 'Spring ' . $this->year;
            case 2; 
                return 'Summer ' . $this->year;
            case 3;
                return 'Fall ' . $this->year;
        }
        
        return null;
    }
}

