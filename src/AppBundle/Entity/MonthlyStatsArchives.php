<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;
use JMS\Serializer\Annotation as Serializer;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Doctrine\Common\Collections\ArrayCollection;
use AppBundle\Entity\MonthlyStatsArchivesCollection;

/**
 * MonthlyStatsArchives
 *
 * @ORM\Table()
 * @ORM\Entity
 * @UniqueEntity(fields={"month"}, message="This month already has statistics associated with it.")
 */
class MonthlyStatsArchives
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
     * @ORM\Column(name="month", type="date")
     */
    private $month;
    
    /**
     * @ORM\ManyToMany(targetEntity="MonthlyStatsArchivesCollection", cascade={"persist"}, orphanRemoval=true, fetch="LAZY")
     * @ORM\JoinTable(name="monthlystatsarchives_monthlystatsarchivesrequestedcollection",
     *      joinColumns={@ORM\JoinColumn(name="report_id", referencedColumnName="id", onDelete="CASCADE")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="collection_id", referencedColumnName="id", unique=true, onDelete="CASCADE")},
     *      )
     */
    private $requestedCollections;
    
    /**
     * @ORM\ManyToMany(targetEntity="MonthlyStatsArchivesCollection", cascade={"persist"}, orphanRemoval=true, fetch="LAZY")
     * @ORM\JoinTable(name="monthlystatsarchives_monthlystatsarchivesdigitizationcollection",
     *      joinColumns={@ORM\JoinColumn(name="report_id", referencedColumnName="id", onDelete="CASCADE")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="collection_id", referencedColumnName="id", unique=true, onDelete="CASCADE")},
     *      )
     */
    private $digitizationCollections;
    

    /**
     * @var integer
     *
     * @ORM\Column(name="researchMinutes5", type="integer")
     */
    private $researchMinutes5;

    /**
     * @var integer
     *
     * @ORM\Column(name="researchMinutes10", type="integer")
     */
    private $researchMinutes10;

    /**
     * @var integer
     *
     * @ORM\Column(name="researchMinutes15", type="integer")
     */
    private $researchMinutes15;

    /**
     * @var integer
     *
     * @ORM\Column(name="researchMinutes20", type="integer")
     */
    private $researchMinutes20;

    /**
     * @var integer
     *
     * @ORM\Column(name="researchMinutes30", type="integer")
     */
    private $researchMinutes30;

    /**
     * @var integer
     *
     * @ORM\Column(name="researchMinutes45", type="integer")
     */
    private $researchMinutes45;

    /**
     * @var integer
     *
     * @ORM\Column(name="researchMinutes60", type="integer")
     */
    private $researchMinutes60;

    /**
     * @var integer
     *
     * @ORM\Column(name="instructionalMinutes5", type="integer")
     */
    private $instructionalMinutes5;

    /**
     * @var integer
     *
     * @ORM\Column(name="instructionalMinutes10", type="integer")
     */
    private $instructionalMinutes10;

    /**
     * @var integer
     *
     * @ORM\Column(name="instructionalMinutes15", type="integer")
     */
    private $instructionalMinutes15;

    /**
     * @var integer
     *
     * @ORM\Column(name="instructionalMinutes20", type="integer")
     */
    private $instructionalMinutes20;

    /**
     * @var integer
     *
     * @ORM\Column(name="instructionalMinutes30", type="integer")
     */
    private $instructionalMinutes30;

    /**
     * @var integer
     *
     * @ORM\Column(name="instructionalMinutes45", type="integer")
     */
    private $instructionalMinutes45;

    /**
     * @var integer
     *
     * @ORM\Column(name="instructionalMinutes60", type="integer")
     */
    private $instructionalMinutes60;

    /**
     * @var integer
     *
     * @ORM\Column(name="researchersFaculty", type="integer")
     */
    private $researchersFaculty;

    /**
     * @var integer
     *
     * @ORM\Column(name="researchersStaff", type="integer")
     */
    private $researchersStaff;

    /**
     * @var integer
     *
     * @ORM\Column(name="researchersUndergrad", type="integer")
     */
    private $researchersUndergrad;

    /**
     * @var integer
     *
     * @ORM\Column(name="researchersGrad", type="integer")
     */
    private $researchersGrad;

    /**
     * @var integer
     *
     * @ORM\Column(name="researchersCommunity", type="integer")
     */
    private $researchersCommunity;

    /**
     * @var integer
     *
     * @ORM\Column(name="researchersOther", type="integer")
     */
    private $researchersOther;

    /**
     * @var integer
     *
     * @ORM\Column(name="directionalEmailRef", type="integer")
     */
    private $directionalEmailRef;

    /**
     * @var integer
     *
     * @ORM\Column(name="directionalPhoneRef", type="integer")
     */
    private $directionalPhoneRef;

    /**
     * @var integer
     *
     * @ORM\Column(name="researchRequestsCollectionEmailRef", type="integer")
     */
    private $researchRequestsCollectionEmailRef;

    /**
     * @var integer
     *
     * @ORM\Column(name="researchRequestsCollectionPhoneRef", type="integer")
     */
    private $researchRequestsCollectionPhoneRef;

    /**
     * @var integer
     *
     * @ORM\Column(name="researchRequestsEmailRef", type="integer")
     */
    private $researchRequestsEmailRef;

    /**
     * @var integer
     *
     * @ORM\Column(name="researchRequestsPhoneRef", type="integer")
     */
    private $researchRequestsPhoneRef;

    /**
     * @var integer
     *
     * @ORM\Column(name="donationsEmailRef", type="integer")
     */
    private $donationsEmailRef;

    /**
     * @var integer
     *
     * @ORM\Column(name="donationsPhoneRef", type="integer")
     */
    private $donationsPhoneRef;

    /**
     * @var integer
     *
     * @ORM\Column(name="loansEmailRef", type="integer")
     */
    private $loansEmailRef;

    /**
     * @var integer
     *
     * @ORM\Column(name="loansPhoneRef", type="integer")
     */
    private $loansPhoneRef;

    /**
     * @var integer
     *
     * @ORM\Column(name="holdingsAddedBooks", type="integer")
     */
    private $holdingsAddedBooks;

    /**
     * @var integer
     *
     * @ORM\Column(name="holdingsAddedFacultyPublications", type="integer")
     */
    private $holdingsAddedFacultyPublications;

    /**
     * @var integer
     *
     * @ORM\Column(name="accessionsLinearFeet", type="integer")
     */
    private $accessionsLinearFeet;

    /**
     * @var integer
     *
     * @ORM\Column(name="accessionsTotalCollections", type="integer")
     */
    private $accessionsTotalCollections;
    
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
     * @Gedmo\Blameable(on="change", field={"researchMinutes5", "researchMinutes10", "researchMinutes15", "researchMinutes20", "researchMinutes30", "researchMinutes45", "researchMinutes60", "instructionalMinutes5", "instructionalMinutes10", "instructionalMinutes15", "instructionalMinutes20", "instructionalMinutes30", "instructionalMinutes45", "instructionalMinutes60", "researchersFaculty", "researchersStaff", "researchersUndergrad", "researchersGrad", "researchersCommunity", "researchersOther", "directionalEmailRef", "directionalPhoneRef", "researchRequestsCollectionEmailRef", "researchRequestsCollectionPhoneRef", "researchRequestsEmailRef", "researchRequestsPhoneRef", "donationsEmailRef", "donationsPhoneRef", "loansEmailRef", "loansPhoneRef", "collectionsProcessedLinearFeet", "collectionsProcessedCallNumber", "collectionsProcessedTotalCollection", "collectionsStoredLinearFeet", "collectionsStoredCallNumber", "collectionsStoredTotalCollection", "holdingsAddedBooks", "holdingsAddedFacultyPublications", "accessionsLinearFeet", "accessionsTotalCollections" })
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumn(referencedColumnName="id")
     * @Serializer\Exclude //exclude from API calls 
     */
    private $contentChangedBy;

    public function __construct(\DateTime $month) {
        $this->month = $month;
        $this->requestedCollections = new ArrayCollection();
        $this->digitizationCollections = new ArrayCollection();
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
     * Set month
     *
     * @param \DateTime $month
     *
     * @return MonthlyStatsArchives
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
     * Set researchMinutes5
     *
     * @param integer $researchMinutes5
     *
     * @return MonthlyStatsArchives
     */
    public function setResearchMinutes5($researchMinutes5)
    {
        $this->researchMinutes5 = $researchMinutes5;

        return $this;
    }

    /**
     * Get researchMinutes5
     *
     * @return integer
     */
    public function getResearchMinutes5()
    {
        return $this->researchMinutes5;
    }

    /**
     * Set researchMinutes10
     *
     * @param integer $researchMinutes10
     *
     * @return MonthlyStatsArchives
     */
    public function setResearchMinutes10($researchMinutes10)
    {
        $this->researchMinutes10 = $researchMinutes10;

        return $this;
    }

    /**
     * Get researchMinutes10
     *
     * @return integer
     */
    public function getResearchMinutes10()
    {
        return $this->researchMinutes10;
    }

    /**
     * Set researchMinutes15
     *
     * @param integer $researchMinutes15
     *
     * @return MonthlyStatsArchives
     */
    public function setResearchMinutes15($researchMinutes15)
    {
        $this->researchMinutes15 = $researchMinutes15;

        return $this;
    }

    /**
     * Get researchMinutes15
     *
     * @return integer
     */
    public function getResearchMinutes15()
    {
        return $this->researchMinutes15;
    }

    /**
     * Set researchMinutes20
     *
     * @param integer $researchMinutes20
     *
     * @return MonthlyStatsArchives
     */
    public function setResearchMinutes20($researchMinutes20)
    {
        $this->researchMinutes20 = $researchMinutes20;

        return $this;
    }

    /**
     * Get researchMinutes20
     *
     * @return integer
     */
    public function getResearchMinutes20()
    {
        return $this->researchMinutes20;
    }

    /**
     * Set researchMinutes30
     *
     * @param integer $researchMinutes30
     *
     * @return MonthlyStatsArchives
     */
    public function setResearchMinutes30($researchMinutes30)
    {
        $this->researchMinutes30 = $researchMinutes30;

        return $this;
    }

    /**
     * Get researchMinutes30
     *
     * @return integer
     */
    public function getResearchMinutes30()
    {
        return $this->researchMinutes30;
    }

    /**
     * Set researchMinutes45
     *
     * @param integer $researchMinutes45
     *
     * @return MonthlyStatsArchives
     */
    public function setResearchMinutes45($researchMinutes45)
    {
        $this->researchMinutes45 = $researchMinutes45;

        return $this;
    }

    /**
     * Get researchMinutes45
     *
     * @return integer
     */
    public function getResearchMinutes45()
    {
        return $this->researchMinutes45;
    }

    /**
     * Set researchMinutes60
     *
     * @param integer $researchMinutes60
     *
     * @return MonthlyStatsArchives
     */
    public function setResearchMinutes60($researchMinutes60)
    {
        $this->researchMinutes60 = $researchMinutes60;

        return $this;
    }

    /**
     * Get researchMinutes60
     *
     * @return integer
     */
    public function getResearchMinutes60()
    {
        return $this->researchMinutes60;
    }

    /**
     * Set instructionalMinutes5
     *
     * @param integer $instructionalMinutes5
     *
     * @return MonthlyStatsArchives
     */
    public function setInstructionalMinutes5($instructionalMinutes5)
    {
        $this->instructionalMinutes5 = $instructionalMinutes5;

        return $this;
    }

    /**
     * Get instructionalMinutes5
     *
     * @return integer
     */
    public function getInstructionalMinutes5()
    {
        return $this->instructionalMinutes5;
    }

    /**
     * Set instructionalMinutes10
     *
     * @param integer $instructionalMinutes10
     *
     * @return MonthlyStatsArchives
     */
    public function setInstructionalMinutes10($instructionalMinutes10)
    {
        $this->instructionalMinutes10 = $instructionalMinutes10;

        return $this;
    }

    /**
     * Get instructionalMinutes10
     *
     * @return integer
     */
    public function getInstructionalMinutes10()
    {
        return $this->instructionalMinutes10;
    }

    /**
     * Set instructionalMinutes15
     *
     * @param integer $instructionalMinutes15
     *
     * @return MonthlyStatsArchives
     */
    public function setInstructionalMinutes15($instructionalMinutes15)
    {
        $this->instructionalMinutes15 = $instructionalMinutes15;

        return $this;
    }

    /**
     * Get instructionalMinutes15
     *
     * @return integer
     */
    public function getInstructionalMinutes15()
    {
        return $this->instructionalMinutes15;
    }

    /**
     * Set instructionalMinutes20
     *
     * @param integer $instructionalMinutes20
     *
     * @return MonthlyStatsArchives
     */
    public function setInstructionalMinutes20($instructionalMinutes20)
    {
        $this->instructionalMinutes20 = $instructionalMinutes20;

        return $this;
    }

    /**
     * Get instructionalMinutes20
     *
     * @return integer
     */
    public function getInstructionalMinutes20()
    {
        return $this->instructionalMinutes20;
    }

    /**
     * Set instructionalMinutes30
     *
     * @param integer $instructionalMinutes30
     *
     * @return MonthlyStatsArchives
     */
    public function setInstructionalMinutes30($instructionalMinutes30)
    {
        $this->instructionalMinutes30 = $instructionalMinutes30;

        return $this;
    }

    /**
     * Get instructionalMinutes30
     *
     * @return integer
     */
    public function getInstructionalMinutes30()
    {
        return $this->instructionalMinutes30;
    }

    /**
     * Set instructionalMinutes45
     *
     * @param integer $instructionalMinutes45
     *
     * @return MonthlyStatsArchives
     */
    public function setInstructionalMinutes45($instructionalMinutes45)
    {
        $this->instructionalMinutes45 = $instructionalMinutes45;

        return $this;
    }

    /**
     * Get instructionalMinutes45
     *
     * @return integer
     */
    public function getInstructionalMinutes45()
    {
        return $this->instructionalMinutes45;
    }

    /**
     * Set instructionalMinutes60
     *
     * @param integer $instructionalMinutes60
     *
     * @return MonthlyStatsArchives
     */
    public function setInstructionalMinutes60($instructionalMinutes60)
    {
        $this->instructionalMinutes60 = $instructionalMinutes60;

        return $this;
    }

    /**
     * Get instructionalMinutes60
     *
     * @return integer
     */
    public function getInstructionalMinutes60()
    {
        return $this->instructionalMinutes60;
    }

    /**
     * Set researchersFaculty
     *
     * @param integer $researchersFaculty
     *
     * @return MonthlyStatsArchives
     */
    public function setResearchersFaculty($researchersFaculty)
    {
        $this->researchersFaculty = $researchersFaculty;

        return $this;
    }

    /**
     * Get researchersFaculty
     *
     * @return integer
     */
    public function getResearchersFaculty()
    {
        return $this->researchersFaculty;
    }

    /**
     * Set researchersStaff
     *
     * @param integer $researchersStaff
     *
     * @return MonthlyStatsArchives
     */
    public function setResearchersStaff($researchersStaff)
    {
        $this->researchersStaff = $researchersStaff;

        return $this;
    }

    /**
     * Get researchersStaff
     *
     * @return integer
     */
    public function getResearchersStaff()
    {
        return $this->researchersStaff;
    }

    /**
     * Set researchersUndergrad
     *
     * @param integer $researchersUndergrad
     *
     * @return MonthlyStatsArchives
     */
    public function setResearchersUndergrad($researchersUndergrad)
    {
        $this->researchersUndergrad = $researchersUndergrad;

        return $this;
    }

    /**
     * Get researchersUndergrad
     *
     * @return integer
     */
    public function getResearchersUndergrad()
    {
        return $this->researchersUndergrad;
    }

    /**
     * Set researchersGrad
     *
     * @param integer $researchersGrad
     *
     * @return MonthlyStatsArchives
     */
    public function setResearchersGrad($researchersGrad)
    {
        $this->researchersGrad = $researchersGrad;

        return $this;
    }

    /**
     * Get researchersGrad
     *
     * @return integer
     */
    public function getResearchersGrad()
    {
        return $this->researchersGrad;
    }

    /**
     * Set researchersCommunity
     *
     * @param integer $researchersCommunity
     *
     * @return MonthlyStatsArchives
     */
    public function setResearchersCommunity($researchersCommunity)
    {
        $this->researchersCommunity = $researchersCommunity;

        return $this;
    }

    /**
     * Get researchersCommunity
     *
     * @return integer
     */
    public function getResearchersCommunity()
    {
        return $this->researchersCommunity;
    }

    /**
     * Set researchersOther
     *
     * @param integer $researchersOther
     *
     * @return MonthlyStatsArchives
     */
    public function setResearchersOther($researchersOther)
    {
        $this->researchersOther = $researchersOther;

        return $this;
    }

    /**
     * Get researchersOther
     *
     * @return integer
     */
    public function getResearchersOther()
    {
        return $this->researchersOther;
    }

    /**
     * Set directionalEmailRef
     *
     * @param integer $directionalEmailRef
     *
     * @return MonthlyStatsArchives
     */
    public function setDirectionalEmailRef($directionalEmailRef)
    {
        $this->directionalEmailRef = $directionalEmailRef;

        return $this;
    }

    /**
     * Get directionalEmailRef
     *
     * @return integer
     */
    public function getDirectionalEmailRef()
    {
        return $this->directionalEmailRef;
    }

    /**
     * Set directionalPhoneRef
     *
     * @param integer $directionalPhoneRef
     *
     * @return MonthlyStatsArchives
     */
    public function setDirectionalPhoneRef($directionalPhoneRef)
    {
        $this->directionalPhoneRef = $directionalPhoneRef;

        return $this;
    }

    /**
     * Get directionalPhoneRef
     *
     * @return integer
     */
    public function getDirectionalPhoneRef()
    {
        return $this->directionalPhoneRef;
    }

    /**
     * Set researchRequestsCollectionEmailRef
     *
     * @param integer $researchRequestsCollectionEmailRef
     *
     * @return MonthlyStatsArchives
     */
    public function setResearchRequestsCollectionEmailRef($researchRequestsCollectionEmailRef)
    {
        $this->researchRequestsCollectionEmailRef = $researchRequestsCollectionEmailRef;

        return $this;
    }

    /**
     * Get researchRequestsCollectionEmailRef
     *
     * @return integer
     */
    public function getResearchRequestsCollectionEmailRef()
    {
        return $this->researchRequestsCollectionEmailRef;
    }

    /**
     * Set researchRequestsCollectionPhoneRef
     *
     * @param integer $researchRequestsCollectionPhoneRef
     *
     * @return MonthlyStatsArchives
     */
    public function setResearchRequestsCollectionPhoneRef($researchRequestsCollectionPhoneRef)
    {
        $this->researchRequestsCollectionPhoneRef = $researchRequestsCollectionPhoneRef;

        return $this;
    }

    /**
     * Get researchRequestsCollectionPhoneRef
     *
     * @return integer
     */
    public function getResearchRequestsCollectionPhoneRef()
    {
        return $this->researchRequestsCollectionPhoneRef;
    }

    /**
     * Set researchRequestsEmailRef
     *
     * @param integer $researchRequestsEmailRef
     *
     * @return MonthlyStatsArchives
     */
    public function setResearchRequestsEmailRef($researchRequestsEmailRef)
    {
        $this->researchRequestsEmailRef = $researchRequestsEmailRef;

        return $this;
    }

    /**
     * Get researchRequestsEmailRef
     *
     * @return integer
     */
    public function getResearchRequestsEmailRef()
    {
        return $this->researchRequestsEmailRef;
    }

    /**
     * Set researchRequestsPhoneRef
     *
     * @param integer $researchRequestsPhoneRef
     *
     * @return MonthlyStatsArchives
     */
    public function setResearchRequestsPhoneRef($researchRequestsPhoneRef)
    {
        $this->researchRequestsPhoneRef = $researchRequestsPhoneRef;

        return $this;
    }

    /**
     * Get researchRequestsPhoneRef
     *
     * @return integer
     */
    public function getResearchRequestsPhoneRef()
    {
        return $this->researchRequestsPhoneRef;
    }

    /**
     * Set donationsEmailRef
     *
     * @param integer $donationsEmailRef
     *
     * @return MonthlyStatsArchives
     */
    public function setDonationsEmailRef($donationsEmailRef)
    {
        $this->donationsEmailRef = $donationsEmailRef;

        return $this;
    }

    /**
     * Get donationsEmailRef
     *
     * @return integer
     */
    public function getDonationsEmailRef()
    {
        return $this->donationsEmailRef;
    }

    /**
     * Set donationsPhoneRef
     *
     * @param integer $donationsPhoneRef
     *
     * @return MonthlyStatsArchives
     */
    public function setDonationsPhoneRef($donationsPhoneRef)
    {
        $this->donationsPhoneRef = $donationsPhoneRef;

        return $this;
    }

    /**
     * Get donationsPhoneRef
     *
     * @return integer
     */
    public function getDonationsPhoneRef()
    {
        return $this->donationsPhoneRef;
    }

    /**
     * Set loansEmailRef
     *
     * @param integer $loansEmailRef
     *
     * @return MonthlyStatsArchives
     */
    public function setLoansEmailRef($loansEmailRef)
    {
        $this->loansEmailRef = $loansEmailRef;

        return $this;
    }

    /**
     * Get loansEmailRef
     *
     * @return integer
     */
    public function getLoansEmailRef()
    {
        return $this->loansEmailRef;
    }

    /**
     * Set loansPhoneRef
     *
     * @param integer $loansPhoneRef
     *
     * @return MonthlyStatsArchives
     */
    public function setLoansPhoneRef($loansPhoneRef)
    {
        $this->loansPhoneRef = $loansPhoneRef;

        return $this;
    }

    /**
     * Get loansPhoneRef
     *
     * @return integer
     */
    public function getLoansPhoneRef()
    {
        return $this->loansPhoneRef;
    }

    /**
     * Set holdingsAddedBooks
     *
     * @param integer $holdingsAddedBooks
     *
     * @return MonthlyStatsArchives
     */
    public function setHoldingsAddedBooks($holdingsAddedBooks)
    {
        $this->holdingsAddedBooks = $holdingsAddedBooks;

        return $this;
    }

    /**
     * Get holdingsAddedBooks
     *
     * @return integer
     */
    public function getHoldingsAddedBooks()
    {
        return $this->holdingsAddedBooks;
    }

    /**
     * Set holdingsAddedFacultyPublications
     *
     * @param integer $holdingsAddedFacultyPublications
     *
     * @return MonthlyStatsArchives
     */
    public function setHoldingsAddedFacultyPublications($holdingsAddedFacultyPublications)
    {
        $this->holdingsAddedFacultyPublications = $holdingsAddedFacultyPublications;

        return $this;
    }

    /**
     * Get holdingsAddedFacultyPublications
     *
     * @return integer
     */
    public function getHoldingsAddedFacultyPublications()
    {
        return $this->holdingsAddedFacultyPublications;
    }

    /**
     * Set accessionsLinearFeet
     *
     * @param integer $accessionsLinearFeet
     *
     * @return MonthlyStatsArchives
     */
    public function setAccessionsLinearFeet($accessionsLinearFeet)
    {
        $this->accessionsLinearFeet = $accessionsLinearFeet;

        return $this;
    }

    /**
     * Get accessionsLinearFeet
     *
     * @return integer
     */
    public function getAccessionsLinearFeet()
    {
        return $this->accessionsLinearFeet;
    }

    /**
     * Set accessionsTotalCollections
     *
     * @param integer $accessionsTotalCollections
     *
     * @return MonthlyStatsArchives
     */
    public function setAccessionsTotalCollections($accessionsTotalCollections)
    {
        $this->accessionsTotalCollections = $accessionsTotalCollections;

        return $this;
    }

    /**
     * Get accessionsTotalCollections
     *
     * @return integer
     */
    public function getAccessionsTotalCollections()
    {
        return $this->accessionsTotalCollections;
    }
    
    /**
     * Add RequestedCollections
     *
     * @param AppBundle\Entity\MonthlyStatsArchivesCollection  $requestedCollections
     * @return AnnualReport
     */
    public function addRequestedCollections(MonthlyStatsArchivesCollection $requestedCollections)
    {
        $this->requestedCollections->add($requestedCollections);

        return $this;
    }

    /**
     * Remove RequestedCollections
     *
     * @param AppBundle\Entity\MonthlyStatsArchivesCollection  $requestedCollections
     * @return MonthlyStatsArchives
     */
    public function removeRequestedCollections(MonthlyStatsArchivesCollection $requestedCollections)
    {
        $this->requestedCollections->removeElement($requestedCollections);
        
        return $this;
    }
    
    /**
     * Get RequestedCollections
     *
     * @return ArrayCollection 
     */
    public function getRequestedCollections()
    {
        return $this->requestedCollections;
    }
    
    /**
     * Add DigitizationCollections
     *
     * @param AppBundle\Entity\MonthlyStatsArchivesCollection  $digitizationCollections
     * @return AnnualReport
     */
    public function addDigitizationCollections(MonthlyStatsArchivesCollection $digitizationCollections)
    {
        $this->digitizationCollections->add($digitizationCollections);

        return $this;
    }

    /**
     * Remove DigitizationCollections
     *
     * @param AppBundle\Entity\MonthlyStatsArchivesCollection  $digitizationCollections
     * @return MonthlyStatsArchives
     */
    public function removeDigitizationCollections(MonthlyStatsArchivesCollection $digitizationCollections)
    {
        $this->digitizationCollections->removeElement($digitizationCollections);
        
        return $this;
    }
    
    /**
     * Get DigitizationCollections
     *
     * @return ArrayCollection 
     */
    public function getDigitizationCollections()
    {
        return $this->digitizationCollections;
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

