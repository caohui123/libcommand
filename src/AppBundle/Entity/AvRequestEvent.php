<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use AppBundle\Entity\AvRequest;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * AvRequestEvent
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class AvRequestEvent
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
     * @ORM\Column(name="location", type="string", length=100)
     */
    private $location;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="time", type="time")
     * @Assert\NotBlank()
     * @Assert\DateTime()
     */
    private $time;
    
    /**
     * @ORM\ManyToOne(targetEntity="AvRequest", inversedBy="events", cascade={"persist"})
     * @ORM\JoinColumn(name="avrequest_id", referencedColumnName="id", onDelete="CASCADE")
     * @Assert\NotBlank()
     */
    private $avrequest;


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
     * Set location
     *
     * @param string $location
     *
     * @return AvRequestEvent
     */
    public function setLocation($location)
    {
        $this->location = $location;

        return $this;
    }

    /**
     * Get location
     *
     * @return string
     */
    public function getLocation()
    {
        return $this->location;
    }

    /**
     * Set time
     *
     * @param \DateTime $time
     *
     * @return AvRequestEvent
     */
    public function setTime(\DateTime $time)
    {
        $this->time = $time;

        return $this;
    }

    /**
     * Get time
     *
     * @return \DateTime
     */
    public function getTime()
    {
        return $this->time;
    }
    
    /**
     * Set AvRequest
     *
     * @param AppBundle\Entity\AvRequest $avrequest
     *
     * @return AvRequestEvent
     */
    public function setAvRequest(AvRequest $avrequest)
    {
        $this->avrequest = $avrequest;

        return $this;
    }

    /**
     * Get AvRequest
     *
     * @return AppBundle\Entity\AvRequest
     */
    public function getAvRequest()
    {
        return $this->avrequest;
    }
}

