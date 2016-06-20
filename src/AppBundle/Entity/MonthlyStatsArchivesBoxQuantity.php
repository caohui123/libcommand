<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;
use JMS\Serializer\Annotation as Serializer;

/**
 * MonthlyStatsArchivesBoxQuantity
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class MonthlyStatsArchivesBoxQuantity
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
     * @ORM\Column(name="quantity", type="integer")
     * @Assert\NotNull()
     */
    private $quantity;
    
    /**
     * @ORM\ManyToOne(targetEntity="MonthlyStatsArchivesBox")
     * @ORM\JoinColumn(name="box_id", referencedColumnName="id")
     * @Assert\NotNull()
     */
    private $box;
    
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
     * @Gedmo\Blameable(on="change", field={"quantity", "box"})
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
     * Set quantity
     *
     * @param integer $quantity
     *
     * @return MonthlyStatsArchivesBoxQuantity
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
     * Set Box
     *
     * @param AppBundle\Entity\MonthlyStatsArchivesBox $box
     *
     * @return MonthlyStatsArchivesBoxQuantity
     */
    public function setBox(MonthlyStatsArchivesBox $box)
    {
        $this->box = $box;

        return $this;
    }

    /**
     * Get Box
     *
     * @return AppBundle\Entity\MonthlyStatsArchivesBox
     */
    public function getBox()
    {
        return $this->box;
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

