<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;
use JMS\Serializer\Annotation as Serializer;

/**
 * MonthlyStatsMapLibrary
 *
 * @ORM\Table()
 * @ORM\Entity
 * @UniqueEntity(fields={"month"}, message="This month already has statistics associated with it.")
 */
class MonthlyStatsMapLibrary
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
     * @ORM\Column(name="mapsAddedGross", type="integer")
     */
    private $mapsAddedGross;

    /**
     * @var integer
     *
     * @ORM\Column(name="mapsWithdrawn", type="integer")
     */
    private $mapsWithdrawn;

    /**
     * @var integer
     *
     * @ORM\Column(name="materialsAddedGross", type="integer")
     */
    private $materialsAddedGross;

    /**
     * @var integer
     *
     * @ORM\Column(name="materialsWithdrawn", type="integer")
     */
    private $materialsWithdrawn;

    /**
     * @var integer
     *
     * @ORM\Column(name="itemsShelved", type="integer")
     */
    private $itemsShelved;

    /**
     * @var integer
     *
     * @ORM\Column(name="itemsAdded", type="integer")
     */
    private $itemsAdded;

    /**
     * @var integer
     *
     * @ORM\Column(name="procedureQuestion1", type="integer")
     */
    private $procedureQuestion1;

    /**
     * @var integer
     *
     * @ORM\Column(name="procedureQuestion3", type="integer")
     */
    private $procedureQuestion3;

    /**
     * @var integer
     *
     * @ORM\Column(name="procedureQuestion5", type="integer")
     */
    private $procedureQuestion5;

    /**
     * @var integer
     *
     * @ORM\Column(name="procedureQuestion10", type="integer")
     */
    private $procedureQuestion10;

    /**
     * @var integer
     *
     * @ORM\Column(name="procedureQuestion10Plus", type="integer")
     */
    private $procedureQuestion10Plus;

    /**
     * @var integer
     *
     * @ORM\Column(name="researchQuestion1", type="integer")
     */
    private $researchQuestion1;

    /**
     * @var integer
     *
     * @ORM\Column(name="researchQuestion3", type="integer")
     */
    private $researchQuestion3;

    /**
     * @var integer
     *
     * @ORM\Column(name="researchQuestion5", type="integer")
     */
    private $researchQuestion5;

    /**
     * @var integer
     *
     * @ORM\Column(name="researchQuestion10", type="integer")
     */
    private $researchQuestion10;

    /**
     * @var integer
     *
     * @ORM\Column(name="researchQuestion15", type="integer")
     */
    private $researchQuestion15;

    /**
     * @var integer
     *
     * @ORM\Column(name="researchQuestion20", type="integer")
     */
    private $researchQuestion20;

    /**
     * @var integer
     *
     * @ORM\Column(name="researchQuestion25", type="integer")
     */
    private $researchQuestion25;

    /**
     * @var integer
     *
     * @ORM\Column(name="researchQuestion25Plus", type="integer")
     */
    private $researchQuestion25Plus;
    
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="month", type="date")
     */
    private $month;
    
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
     * @Gedmo\Blameable(on="change", field={"mapsAddedGross", "mapsWithdrawn", "materialsAddedGross", "materialsWithdrawn", "itemsShelved", "itemsAdded", "procedureQuestion1", "procedureQuestion3", "procedureQuestion5", "procedureQuestion10", "procedureQuestion10Plus", "researchQuestion1", "researchQuestion3", "researchQuestion5", "researchQuestion10", "researchQuestion15", "researchQuestion20", "researchQuestion25", "researchQuestion25Plus"})
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumn(referencedColumnName="id")
     * @Serializer\Exclude //exclude from API calls 
     */
    private $contentChangedBy;

    public function __construct(\DateTime $month) {
        $this->month = $month;
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
     * Set mapsAddedGross
     *
     * @param integer $mapsAddedGross
     *
     * @return MonthlyStatsMapLibrary
     */
    public function setMapsAddedGross($mapsAddedGross)
    {
        $this->mapsAddedGross = $mapsAddedGross;

        return $this;
    }

    /**
     * Get mapsAddedGross
     *
     * @return integer
     */
    public function getMapsAddedGross()
    {
        return $this->mapsAddedGross;
    }

    /**
     * Set mapsWithdrawn
     *
     * @param integer $mapsWithdrawn
     *
     * @return MonthlyStatsMapLibrary
     */
    public function setMapsWithdrawn($mapsWithdrawn)
    {
        $this->mapsWithdrawn = $mapsWithdrawn;

        return $this;
    }

    /**
     * Get mapsWithdrawn
     *
     * @return integer
     */
    public function getMapsWithdrawn()
    {
        return $this->mapsWithdrawn;
    }

    /**
     * Set materialsAddedGross
     *
     * @param integer $materialsAddedGross
     *
     * @return MonthlyStatsMapLibrary
     */
    public function setMaterialsAddedGross($materialsAddedGross)
    {
        $this->materialsAddedGross = $materialsAddedGross;

        return $this;
    }

    /**
     * Get materialsAddedGross
     *
     * @return integer
     */
    public function getMaterialsAddedGross()
    {
        return $this->materialsAddedGross;
    }

    /**
     * Set materialsWithdrawn
     *
     * @param integer $materialsWithdrawn
     *
     * @return MonthlyStatsMapLibrary
     */
    public function setMaterialsWithdrawn($materialsWithdrawn)
    {
        $this->materialsWithdrawn = $materialsWithdrawn;

        return $this;
    }

    /**
     * Get materialsWithdrawn
     *
     * @return integer
     */
    public function getMaterialsWithdrawn()
    {
        return $this->materialsWithdrawn;
    }

    /**
     * Set itemsShelved
     *
     * @param integer $itemsShelved
     *
     * @return MonthlyStatsMapLibrary
     */
    public function setItemsShelved($itemsShelved)
    {
        $this->itemsShelved = $itemsShelved;

        return $this;
    }

    /**
     * Get itemsShelved
     *
     * @return integer
     */
    public function getItemsShelved()
    {
        return $this->itemsShelved;
    }

    /**
     * Set itemsAdded
     *
     * @param integer $itemsAdded
     *
     * @return MonthlyStatsMapLibrary
     */
    public function setItemsAdded($itemsAdded)
    {
        $this->itemsAdded = $itemsAdded;

        return $this;
    }

    /**
     * Get itemsAdded
     *
     * @return integer
     */
    public function getItemsAdded()
    {
        return $this->itemsAdded;
    }

    /**
     * Set procedureQuestion1
     *
     * @param integer $procedureQuestion1
     *
     * @return MonthlyStatsMapLibrary
     */
    public function setProcedureQuestion1($procedureQuestion1)
    {
        $this->procedureQuestion1 = $procedureQuestion1;

        return $this;
    }

    /**
     * Get procedureQuestion1
     *
     * @return integer
     */
    public function getProcedureQuestion1()
    {
        return $this->procedureQuestion1;
    }

    /**
     * Set procedureQuestion3
     *
     * @param integer $procedureQuestion3
     *
     * @return MonthlyStatsMapLibrary
     */
    public function setProcedureQuestion3($procedureQuestion3)
    {
        $this->procedureQuestion3 = $procedureQuestion3;

        return $this;
    }

    /**
     * Get procedureQuestion3
     *
     * @return integer
     */
    public function getProcedureQuestion3()
    {
        return $this->procedureQuestion3;
    }

    /**
     * Set procedureQuestion5
     *
     * @param integer $procedureQuestion5
     *
     * @return MonthlyStatsMapLibrary
     */
    public function setProcedureQuestion5($procedureQuestion5)
    {
        $this->procedureQuestion5 = $procedureQuestion5;

        return $this;
    }

    /**
     * Get procedureQuestion5
     *
     * @return integer
     */
    public function getProcedureQuestion5()
    {
        return $this->procedureQuestion5;
    }

    /**
     * Set procedureQuestion10
     *
     * @param integer $procedureQuestion10
     *
     * @return MonthlyStatsMapLibrary
     */
    public function setProcedureQuestion10($procedureQuestion10)
    {
        $this->procedureQuestion10 = $procedureQuestion10;

        return $this;
    }

    /**
     * Get procedureQuestion10
     *
     * @return integer
     */
    public function getProcedureQuestion10()
    {
        return $this->procedureQuestion10;
    }

    /**
     * Set procedureQuestion10Plus
     *
     * @param integer $procedureQuestion10Plus
     *
     * @return MonthlyStatsMapLibrary
     */
    public function setProcedureQuestion10Plus($procedureQuestion10Plus)
    {
        $this->procedureQuestion10Plus = $procedureQuestion10Plus;

        return $this;
    }

    /**
     * Get procedureQuestion10Plus
     *
     * @return integer
     */
    public function getProcedureQuestion10Plus()
    {
        return $this->procedureQuestion10Plus;
    }

    /**
     * Set researchQuestion1
     *
     * @param integer $researchQuestion1
     *
     * @return MonthlyStatsMapLibrary
     */
    public function setResearchQuestion1($researchQuestion1)
    {
        $this->researchQuestion1 = $researchQuestion1;

        return $this;
    }

    /**
     * Get researchQuestion1
     *
     * @return integer
     */
    public function getResearchQuestion1()
    {
        return $this->researchQuestion1;
    }

    /**
     * Set researchQuestion3
     *
     * @param integer $researchQuestion3
     *
     * @return MonthlyStatsMapLibrary
     */
    public function setResearchQuestion3($researchQuestion3)
    {
        $this->researchQuestion3 = $researchQuestion3;

        return $this;
    }

    /**
     * Get researchQuestion3
     *
     * @return integer
     */
    public function getResearchQuestion3()
    {
        return $this->researchQuestion3;
    }

    /**
     * Set researchQuestion5
     *
     * @param integer $researchQuestion5
     *
     * @return MonthlyStatsMapLibrary
     */
    public function setResearchQuestion5($researchQuestion5)
    {
        $this->researchQuestion5 = $researchQuestion5;

        return $this;
    }

    /**
     * Get researchQuestion5
     *
     * @return integer
     */
    public function getResearchQuestion5()
    {
        return $this->researchQuestion5;
    }

    /**
     * Set researchQuestion10
     *
     * @param integer $researchQuestion10
     *
     * @return MonthlyStatsMapLibrary
     */
    public function setResearchQuestion10($researchQuestion10)
    {
        $this->researchQuestion10 = $researchQuestion10;

        return $this;
    }

    /**
     * Get researchQuestion10
     *
     * @return integer
     */
    public function getResearchQuestion10()
    {
        return $this->researchQuestion10;
    }

    /**
     * Set researchQuestion15
     *
     * @param integer $researchQuestion15
     *
     * @return MonthlyStatsMapLibrary
     */
    public function setResearchQuestion15($researchQuestion15)
    {
        $this->researchQuestion15 = $researchQuestion15;

        return $this;
    }

    /**
     * Get researchQuestion15
     *
     * @return integer
     */
    public function getResearchQuestion15()
    {
        return $this->researchQuestion15;
    }

    /**
     * Set researchQuestion20
     *
     * @param integer $researchQuestion20
     *
     * @return MonthlyStatsMapLibrary
     */
    public function setResearchQuestion20($researchQuestion20)
    {
        $this->researchQuestion20 = $researchQuestion20;

        return $this;
    }

    /**
     * Get researchQuestion20
     *
     * @return integer
     */
    public function getResearchQuestion20()
    {
        return $this->researchQuestion20;
    }

    /**
     * Set researchQuestion25
     *
     * @param integer $researchQuestion25
     *
     * @return MonthlyStatsMapLibrary
     */
    public function setResearchQuestion25($researchQuestion25)
    {
        $this->researchQuestion25 = $researchQuestion25;

        return $this;
    }

    /**
     * Get researchQuestion25
     *
     * @return integer
     */
    public function getResearchQuestion25()
    {
        return $this->researchQuestion25;
    }

    /**
     * Set researchQuestion25Plus
     *
     * @param integer $researchQuestion25Plus
     *
     * @return MonthlyStatsMapLibrary
     */
    public function setResearchQuestion25Plus($researchQuestion25Plus)
    {
        $this->researchQuestion25Plus = $researchQuestion25Plus;

        return $this;
    }

    /**
     * Get researchQuestion25Plus
     *
     * @return integer
     */
    public function getResearchQuestion25Plus()
    {
        return $this->researchQuestion25Plus;
    }
    
    /**
     * Set month
     *
     * @param \DateTime $month
     *
     * @return MonthlyStatsGovernmentDocuments
     */
    public function setMonth($month)
    {
        $this->month = $month;

        return $this;
    }

    /**
     * Get month
     *
     * @return \DateTime
     */
    public function getMonth()
    {
        return $this->month;
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

