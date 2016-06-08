<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;
use JMS\Serializer\Annotation as Serializer;
use Hateoas\Configuration\Annotation as Hateoas;
use AppBundle\Entity\AnnualReportUnit;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use AppBundle\Entity\AnnualReportStaffing;
use AppBundle\Entity\AnnualReportDetail;
use AppBundle\Entity\AnnualReportDocument;

/**
 * AnnualReport
 *
 * @ORM\Table()
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks()
 * @UniqueEntity(fields={"year", "unit"}, message="A report for this year has already been created for this unit.")
 */
class AnnualReport
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
     * @ORM\Column(name="year", type="integer")
     */
    private $year;
    
    /**
     * @var boolean
     *
     * @ORM\Column(name="isFinal", type="boolean")
     */
    private $isFinal;

    /**
     * @ORM\ManyToOne(targetEntity="AnnualReportUnit", cascade={"persist"}, fetch="LAZY")
     * @ORM\JoinColumn(name="unit_id", referencedColumnName="id", nullable=true, onDelete="CASCADE")
     */
    private $unit;
    
    /**
     * @ORM\ManyToMany(targetEntity="AnnualReportStaffing", cascade={"persist", "detach", "remove"}, orphanRemoval=true, fetch="LAZY")
     * @ORM\JoinTable(name="annualreports_staffingtenure",
     *      joinColumns={@ORM\JoinColumn(name="annualreport_id", referencedColumnName="id", onDelete="CASCADE")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="staffing_id", referencedColumnName="id", onDelete="CASCADE")},
     *      )
     */
    private $staffingTenured;
    
    /**
     * @ORM\ManyToMany(targetEntity="AnnualReportStaffing", cascade={"persist", "detach", "remove"}, orphanRemoval=true, fetch="LAZY")
     * @ORM\JoinTable(name="annualreports_staffingclerical",
     *      joinColumns={@ORM\JoinColumn(name="annualreport_id", referencedColumnName="id", onDelete="CASCADE")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="staffing_id", referencedColumnName="id", onDelete="CASCADE")},
     *      )
     */
    private $staffingClerical;
    
    /**
     * @ORM\ManyToMany(targetEntity="AnnualReportStaffing", cascade={"persist", "detach", "remove"}, orphanRemoval=true, fetch="LAZY")
     * @ORM\JoinTable(name="annualreports_staffinglecturers",
     *      joinColumns={@ORM\JoinColumn(name="annualreport_id", referencedColumnName="id", onDelete="CASCADE")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="staffing_id", referencedColumnName="id", onDelete="CASCADE")},
     *      )
     */
    private $staffingLecturers;
    
    /**
     * @ORM\ManyToMany(targetEntity="AnnualReportStaffing", cascade={"persist", "detach", "remove"}, orphanRemoval=true, fetch="LAZY")
     * @ORM\JoinTable(name="annualreports_staffingother",
     *      joinColumns={@ORM\JoinColumn(name="annualreport_id", referencedColumnName="id", onDelete="CASCADE")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="staffing_id", referencedColumnName="id", onDelete="CASCADE")},
     *      )
     */
    private $staffingOther;
    
    /**
     * Category 1. Core Services/Responsibilities
     * @ORM\ManyToMany(targetEntity="AnnualReportDetail", cascade={"persist", "detach", "remove"}, orphanRemoval=true, fetch="LAZY")
     * @ORM\JoinTable(name="annualreports_detailcore",
     *      joinColumns={@ORM\JoinColumn(name="annualreport_id", referencedColumnName="id", onDelete="CASCADE")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="detail_id", referencedColumnName="id", onDelete="CASCADE")},
     *      )
     */
    private $detailCore;
    
    /**
     * Category 2. Progress on Goals
     * @ORM\ManyToMany(targetEntity="AnnualReportDetail", cascade={"persist", "detach", "remove"}, orphanRemoval=true, fetch="LAZY")
     * @ORM\JoinTable(name="annualreports_detailprogress",
     *      joinColumns={@ORM\JoinColumn(name="annualreport_id", referencedColumnName="id", onDelete="CASCADE")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="detail_id", referencedColumnName="id", onDelete="CASCADE")},
     *      )
     */
    private $detailProgress;
    
    /**
     * Category 3. Non-Core Initiatives
     * @ORM\ManyToMany(targetEntity="AnnualReportDetail", cascade={"persist", "detach", "remove"}, orphanRemoval=true, fetch="LAZY")
     * @ORM\JoinTable(name="annualreports_detailinitatives",
     *      joinColumns={@ORM\JoinColumn(name="annualreport_id", referencedColumnName="id", onDelete="CASCADE")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="detail_id", referencedColumnName="id", onDelete="CASCADE")},
     *      )
     */
    private $detailInitiatives;
    
    /**
     * Category 4. Noteworthy Accomplishments
     * @ORM\ManyToMany(targetEntity="AnnualReportDetail", cascade={"persist", "detach", "remove"}, orphanRemoval=true, fetch="LAZY")
     * @ORM\JoinTable(name="annualreports_detailaccomplishments",
     *      joinColumns={@ORM\JoinColumn(name="annualreport_id", referencedColumnName="id", onDelete="CASCADE")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="detail_id", referencedColumnName="id", onDelete="CASCADE")},
     *      )
     */
    private $detailAccomplishments;
    
    /**
     * Category 5. Changes for Next Year
     * @ORM\ManyToMany(targetEntity="AnnualReportDetail", cascade={"persist", "detach", "remove"}, orphanRemoval=true, fetch="LAZY")
     * @ORM\JoinTable(name="annualreports_detailchanges",
     *      joinColumns={@ORM\JoinColumn(name="annualreport_id", referencedColumnName="id", onDelete="CASCADE")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="detail_id", referencedColumnName="id", onDelete="CASCADE")},
     *      )
     */
    private $detailChanges;
    
    /**
     * Category 6. Objectives for Next Year
     * @ORM\ManyToMany(targetEntity="AnnualReportDetail", cascade={"persist", "detach", "remove"}, orphanRemoval=true, fetch="LAZY")
     * @ORM\JoinTable(name="annualreports_detailobjectives",
     *      joinColumns={@ORM\JoinColumn(name="annualreport_id", referencedColumnName="id", onDelete="CASCADE")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="detail_id", referencedColumnName="id", onDelete="CASCADE")},
     *      )
     */
    private $detailObjectives;
    
    /**
     * @ORM\ManyToMany(targetEntity="Document", cascade={"persist", "detach", "remove"}, orphanRemoval=true, fetch="LAZY")
     * @ORM\JoinTable(name="annualreports_documents",
     *      joinColumns={@ORM\JoinColumn(name="annualreport_id", referencedColumnName="id", onDelete="CASCADE")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="document_id", referencedColumnName="id", onDelete="CASCADE")},
     *      )
     */
    private $documents;

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
     * @Gedmo\Blameable(on="change", field={"year"})
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumn(referencedColumnName="id")
     * @Serializer\Exclude //exclude from API calls 
     */
    private $contentChangedBy;
    
    public function __construct(AnnualReportUnit $unit, $year) {
        $this->unit = $unit;
        $this->year = $year;
        $this->staffingTenured = new ArrayCollection();
        $this->staffingClerical = new ArrayCollection();
        $this->staffingLecturers = new ArrayCollection();
        $this->staffingOther = new ArrayCollection();
        $this->detailCore = new ArrayCollection();
        $this->detailProgress = new ArrayCollection();
        $this->detailInitiatives = new ArrayCollection();
        $this->detailAccomplishments = new ArrayCollection();
        $this->detailChanges = new ArrayCollection();
        $this->detailObjectives = new ArrayCollection();
        $this->documents = new ArrayCollection();
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
     * Set year
     *
     * @param integer $year
     *
     * @return AnnualReport
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
     * Set isFinal
     *
     * @param boolean $isFinal
     *
     * @return AnnualReport
     */
    public function setIsFinal($isFinal)
    {
        $this->isFinal = $isFinal;

        return $this;
    }

    /**
     * Get isFinal
     *
     * @return boolean
     */
    public function getIsFinal()
    {
        return $this->isFinal;
    }

    /**
     * Set unit
     *
     * @param \AppBundle\Entity\AnnualReportUnit $unit
     *
     * @return AnnualReport
     */
    public function setUnit(AnnualReportUnit $unit)
    {
        $this->unit = $unit;

        return $this;
    }

    /**
     * Get unit
     *
     * @return AppBundle\Entity\AnnualReportUnit
     */
    public function getUnit()
    {
        return $this->unit;
    }
    
    /**
     * Add staffingTenured
     *
     * @param AppBundle\Entity\AnnualReportStaffing  $staffing
     * @return AnnualReport
     */
    public function addStaffingTenured(AnnualReportStaffing $staffing)
    {
        $this->staffingTenured->add($staffing);

        return $this;
    }

    /**
     * Remove staffingTenured
     *
     * @param AppBundle\Entity\AnnualReportStaffing  $staffing
     * @return AnnualReport
     */
    public function removeStaffingTenured(AnnualReportStaffing $staffing)
    {
        $this->staffingTenured->removeElement($staffing);
        
        return $this;
    }
    
    /**
     * Get staffingTenured
     *
     * @return ArrayCollection 
     */
    public function getStaffingTenured()
    {
        return $this->staffingTenured;
    }
    
    /**
     * Add staffingClerical
     *
     * @param AppBundle\Entity\AnnualReportStaffing  $staffing
     * @return AnnualReport
     */
    public function addStaffingClerical(AnnualReportStaffing $staffing)
    {
        $this->staffingClerical->add($staffing);

        return $this;
    }

    /**
     * Remove staffingClerical
     *
     * @param AppBundle\Entity\AnnualReportStaffing  $staffing
     * @return AnnualReport
     */
    public function removeStaffingClerical(AnnualReportStaffing $staffing)
    {
        $this->staffingClerical->removeElement($staffing);
        
        return $this;
    }
    
    /**
     * Get staffingClerical
     *
     * @return ArrayCollection
     */
    public function getStaffingClerical()
    {
        return $this->staffingClerical;
    }
    
    /**
     * Add staffingLecturers
     *
     * @param AppBundle\Entity\AnnualReportStaffing  $staffing
     * @return AnnualReport
     */
    public function addStaffingLecturer(AnnualReportStaffing $staffing)
    {
        $this->staffingLecturers->add($staffing);

        return $this;
    }

    /**
     * Remove staffingLecturers
     *
     * @param AppBundle\Entity\AnnualReportStaffing  $staffing
     * @return AnnualReport
     */
    public function removeStaffingLecturer(AnnualReportStaffing $staffing)
    {
        $this->staffingLecturers->removeElement($staffing);
        
        return $this;
    }
    
    /**
     * Get staffingLecturers
     *
     * @return ArrayCollection
     */
    public function getStaffingLecturers()
    {
        return $this->staffingLecturers;
    }
    
    /**
     * Add staffingOther
     *
     * @param AppBundle\Entity\AnnualReportStaffing  $staffing
     * @return AnnualReport
     */
    public function addStaffingOther(AnnualReportStaffing $staffing)
    {
        $this->staffingOther->add($staffing);

        return $this;
    }

    /**
     * Remove staffingOther
     *
     * @param AppBundle\Entity\AnnualReportStaffing  $staffing
     * @return AnnualReport
     */
    public function removeStaffingOther(AnnualReportStaffing $staffing)
    {
        $this->staffingOther->removeElement($staffing);
        
        return $this;
    }
    
    /**
     * Get staffingOther
     *
     * @return ArrayCollection
     */
    public function getStaffingOther()
    {
        return $this->staffingOther;
    }
    
    /**
     * Add detailCore
     *
     * @param AppBundle\Entity\AnnualReportDetail  $detail
     * @return AnnualReport
     */
    public function addDetailCore(AnnualReportDetail $detail)
    {
        $this->detailCore->add($detail);

        return $this;
    }

    /**
     * Remove detailCore
     *
     * @param AppBundle\Entity\AnnualReportDetail  $detail
     * @return AnnualReport
     */
    public function removeDetailCore(AnnualReportDetail $detail)
    {
        $this->detailCore->removeElement($detail);
        
        return $this;
    }
    
    /**
     * Get detailCore
     *
     * @return ArrayCollection
     */
    public function getDetailCore()
    {
        return $this->detailCore;
    }
    
    /**
     * Add detailProgress
     *
     * @param AppBundle\Entity\AnnualReportDetail  $detail
     * @return AnnualReport
     */
    public function addDetailProgres(AnnualReportDetail $detail)
    {
        $this->detailProgress->add($detail);

        return $this;
    }

    /**
     * Remove detailProgress
     *
     * @param AppBundle\Entity\AnnualReportDetail  $detail
     * @return AnnualReport
     */
    public function removeDetailProgres(AnnualReportDetail $detail)
    {
        $this->detailProgress->removeElement($detail);
        
        return $this;
    }
    
    /**
     * Get detailProgress
     *
     * @return ArrayCollection
     */
    public function getDetailProgress()
    {
        return $this->detailProgress;
    }
    
    /**
     * Add detailInitiatives
     *
     * @param AppBundle\Entity\AnnualReportDetail  $detail
     * @return AnnualReport
     */
    public function addDetailInitiative(AnnualReportDetail $detail)
    {
        $this->detailInitiatives->add($detail);

        return $this;
    }

    /**
     * Remove detailInitiatives
     *
     * @param AppBundle\Entity\AnnualReportDetail  $detail
     * @return AnnualReport
     */
    public function removeDetailInitiative(AnnualReportDetail $detail)
    {
        $this->detailInitiatives->removeElement($detail);
        
        return $this;
    }
    
    /**
     * Get detailInitiatives
     *
     * @return ArrayCollection
     */
    public function getDetailInitiatives()
    {
        return $this->detailInitiatives;
    }
    
    /**
     * Add detailAccomplishments
     *
     * @param AppBundle\Entity\AnnualReportDetail  $detail
     * @return AnnualReport
     */
    public function addDetailAccomplishment(AnnualReportDetail $detail)
    {
        $this->detailAccomplishments->add($detail);

        return $this;
    }

    /**
     * Remove detailAccomplishments
     *
     * @param AppBundle\Entity\AnnualReportDetail  $detail
     * @return AnnualReport
     */
    public function removeDetailAccomplishment(AnnualReportDetail $detail)
    {
        $this->detailAccomplishments->removeElement($detail);
        
        return $this;
    }
    
    /**
     * Get detailAccomplishments
     *
     * @return ArrayCollection
     */
    public function getDetailAccomplishments()
    {
        return $this->detailAccomplishments;
    }
    
    /**
     * Add detailChanges
     *
     * @param AppBundle\Entity\AnnualReportDetail  $detail
     * @return AnnualReport
     */
    public function addDetailChange(AnnualReportDetail $detail)
    {
        $this->detailChanges->add($detail);

        return $this;
    }

    /**
     * Remove detailChanges
     *
     * @param AppBundle\Entity\AnnualReportDetail  $detail
     * @return AnnualReport
     */
    public function removeDetailChange(AnnualReportDetail $detail)
    {
        $this->detailChanges->removeElement($detail);
        
        return $this;
    }
    
    /**
     * Get detailChanges
     *
     * @return ArrayCollection
     */
    public function getDetailChanges()
    {
        return $this->detailChanges;
    }
    
    /**
     * Add detailObjectives
     *
     * @param AppBundle\Entity\AnnualReportDetail  $detail
     * @return AnnualReport
     */
    public function addDetailObjective(AnnualReportDetail $detail)
    {
        $this->detailObjectives->add($detail);

        return $this;
    }

    /**
     * Remove detailObjectives
     *
     * @param AppBundle\Entity\AnnualReportDetail  $detail
     * @return AnnualReport
     */
    public function removeDetailObjective(AnnualReportDetail $detail)
    {
        $this->detailObjectives->removeElement($detail);
        
        return $this;
    }
    
    /**
     * Get detailObjectives
     *
     * @return ArrayCollection
     */
    public function getDetailObjectives()
    {
        return $this->detailObjectives;
    }
    
    /**
     * Add document
     *
     * @param AppBundle\Entity\AnnualReportDocument  $document
     * @return AnnualReport
     */
    public function addDocument(AnnualReportDocument $document)
    {
        $this->documents->add($document);

        return $this;
    }

    /**
     * Remove document
     *
     * @param AppBundle\Entity\AnnualReportDocument  $document
     * @return AnnualReport
     */
    public function removeDocument(AnnualReportDocument $document)
    {
        $this->documents->removeElement($document);
        
        return $this;
    }
    
    /**
     * Get documents
     *
     * @return ArrayCollection
     */
    public function getDocuments()
    {
        return $this->documents;
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

