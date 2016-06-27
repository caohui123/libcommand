<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;
use JMS\Serializer\Annotation as Serializer;

/**
 * MonthlyStatsArchivesFileDigitization
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class MonthlyStatsArchivesFileDigitization
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
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=50)
     */
    private $type;

    /**
     * @var integer
     *
     * @ORM\Column(name="quantity", type="integer")
     */
    private $quantity;


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
     * @Serializer\Exclude //exclude from API calls 
     */
    private $createdBy;

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
     * @Gedmo\Blameable(on="change", field={"name", "type", "quantity"})
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
     * Set name
     *
     * @param string $name
     *
     * @return MonthlyStatsArchivesFileRequested
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set type
     *
     * @param string $type
     *
     * @return MonthlyStatsArchivesFileRequested
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set quantity
     *
     * @param integer $quantity
     *
     * @return MonthlyStatsArchivesFileRequested
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
}

