<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use AppBundle\Entity\AvRequest;
use AppBundle\Entity\AvRequestEquipment;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * AvRequestEquipmentQuantity
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class AvRequestEquipmentQuantity
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
     * @ORM\Column(name="quantity", type="smallint")
     */
    private $quantity;
    
    /**
     * @var AppBundle\Entity\AvRequestEquipment
     * 
     * @ORM\ManyToOne(targetEntity="AvRequestEquipment")
     * @ORM\JoinColumn(name="equipment_id", referencedColumnName="id", onDelete="SET NULL")
     */
    private $equipment;

    /**
     * @var AppBundle\Entity\AvRequest
     * 
     * @ORM\ManyToOne(targetEntity="AvRequest", inversedBy="equipment")
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
     * Set quantity
     *
     * @param integer $quantity
     *
     * @return AvRequestEquipmentQuantity
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;

        return $this;
    }

    /**
     * Get quantity
     *
     * @return integer
     */
    public function getQuantity()
    {
        return $this->quantity;
    }
    
    /**
     * Set AvRequest
     *
     * @param AppBundle\Entity\AvRequest $avrequest
     *
     * @return AvRequestEquipmentQuantity
     */
    public function setAvRequest(AvRequest $avrequest)
    {
        $this->avrequest = $avrequest;

        return $this;
    }

    /**
     * Get AvRequest
     *
     * @return AvRequest
     */
    public function getAvRequest()
    {
        return $this->avrequest;
    }
    
    /**
     * Set AvRequestEquipment
     *
     * @param AppBundle\Entity\AvRequestEquipment $equipment
     *
     * @return AvRequestEquipmentQuantity
     */
    public function setEquipment(AvRequestEquipment $equipment)
    {
        $this->equipment = $equipment;

        return $this;
    }

    /**
     * Get AvRequestEquipment
     *
     * @return AvRequestEquipment
     */
    public function getEquipment()
    {
        return $this->equipment;
    }
}

