<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;
use JMS\Serializer\Annotation as Serializer;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Doctrine\Common\Collections\ArrayCollection;
use AppBundle\Entity\MonthlyStatsArchivesBoxQuantity;

/**
 * MonthlyStatsArchivesCollection
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class MonthlyStatsArchivesCollection
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
     * @ORM\ManyToOne(targetEntity="MonthlyStatsArchivesCollectionTitle")
     * @ORM\JoinColumn(name="box_id", referencedColumnName="id")
     * @Assert\NotNull()
     */
    private $name;

    /**
     * @ORM\ManyToMany(targetEntity="MonthlyStatsArchivesBoxQuantity", cascade={"persist"}, orphanRemoval=true, fetch="LAZY")
     * @ORM\JoinTable(name="monthlystatsarchivescollection_monthlystatsarchivesboxquantity",
     *      joinColumns={@ORM\JoinColumn(name="collection_id", referencedColumnName="id", onDelete="CASCADE")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="boxquantity_id", referencedColumnName="id", onDelete="CASCADE")},
     *      )
     */
    private $boxQuantity;
    
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
     * @Gedmo\Blameable(on="change", field={"name", "boxQuantity"})
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumn(referencedColumnName="id")
     * @Serializer\Exclude //exclude from API calls 
     */
    private $contentChangedBy;
    
    public function __construct(){
        $this->boxQuantity = new ArrayCollection();;
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
     * Set name
     *
     * @param string $name
     *
     * @return MonthlyStatsArchivesCollection
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
     * Add BoxQuantity
     *
     * @param AppBundle\Entity\MonthlyStatsArchivesBoxQuantity  $boxQuantity
     * @return AnnualReport
     */
    public function addBoxQuantity(MonthlyStatsArchivesBoxQuantity $boxQuantity)
    {
        $this->boxQuantity->add($boxQuantity);

        return $this;
    }

    /**
     * Remove BoxQuantity
     *
     * @param AppBundle\Entity\MonthlyStatsArchivesBoxQuantity  $boxQuantity
     * @return AnnualReport
     */
    public function removeBoxQuantity(MonthlyStatsArchivesBoxQuantity $boxQuantity)
    {
        $this->boxQuantity->removeElement($boxQuantity);
        
        return $this;
    }
    
    /**
     * Get BoxQuantity
     *
     * @return ArrayCollection 
     */
    public function getBoxQuantity()
    {
        return $this->boxQuantity;
    }
    
}

