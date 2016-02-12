<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use AppBundle\Entity\PatronGroup;
use AppBundle\Entity\MediaType;
use AppBundle\Entity\LiaisonSubject;
use AppBundle\Entity\MaterialPurchaseRequestReason;
use Gedmo\Mapping\Annotation as Gedmo;
use AppBundle\Entity\MaterialPurchaseRequestStatus;

/**
 * MaterialPurchaseRequest
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class MaterialPurchaseRequest
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
     * @ORM\Column(name="patronFirstName", type="string", length=40)
     */
    private $patronFirstName;

    /**
     * @var string
     *
     * @ORM\Column(name="patronLastName", type="string", length=40)
     */
    private $patronLastName;

    /**
     * @var string
     *
     * @ORM\Column(name="patronEmail", type="string", length=50)
     */
    private $patronEmail;

    /**
     * @ORM\ManyToOne(targetEntity="LiaisonSubject")
     * @ORM\JoinColumn(name="liaisonsubject_id", referencedColumnName="id", nullable=true)
     */
    private $patronDepartment;

    /**
     * @ORM\ManyToOne(targetEntity="PatronGroup", cascade={"persist"}, fetch="LAZY")
     * @ORM\JoinColumn(name="patrongroup_id", referencedColumnName="id", onDelete="SET NULL")
     */
    private $patronGroup;

    /**
     * @var boolean
     *
     * @ORM\Column(name="notify", type="boolean")
     */
    private $notify;

    /**
     * @var boolean
     *
     * @ORM\Column(name="isNotified", type="boolean")
     */
    private $isNotified;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="notifiedDate", type="datetime", nullable=true)
     */
    private $notifiedDate;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="isbn", type="string", length=25, nullable=true)
     */
    private $isbn;

    /**
     * @var string
     *
     * @ORM\Column(name="issn", type="string", length=25, nullable=true)
     */
    private $issn;

    /**
     * @var string
     *
     * @ORM\Column(name="author", type="string", length=100, nullable=true)
     */
    private $author;

    /**
     * @var string
     *
     * @ORM\Column(name="publisher", type="string", length=255)
     */
    private $publisher;

    /**
     * @var integer
     *
     * @ORM\Column(name="publicationYear", type="integer", nullable=true)
     */
    private $publicationYear;

    /**
     * @var string
     *
     * @ORM\Column(name="edition", type="string", length=10, nullable=true)
     */
    private $edition;

    /**
     * @var string
     *
     * @ORM\Column(name="price", type="decimal", nullable=true)
     */
    private $price;

    /**
     * @var string
     *
     * @ORM\ManyToOne(targetEntity="MediaType", cascade={"persist"}, fetch="LAZY")
     * @ORM\JoinColumn(name="mediatype_id", referencedColumnName="id", onDelete="SET NULL")
     */
    private $mediaType;

    /**
     * @var string
     *
     * @ORM\Column(name="source", type="text")
     */
    private $source;

    /**
     * @var boolean
     *
     * @ORM\Column(name="isInCatalog", type="boolean")
     */
    private $isInCatalog;

    /**
     * @var string
     *
     * @ORM\ManyToOne(targetEntity="MaterialPurchaseRequestReason", cascade={"persist"}, fetch="LAZY")
     * @ORM\JoinColumn(name="materialpurchaserequestreason_id", referencedColumnName="id", onDelete="SET NULL")
     */
    private $reasonToAdd;

    /**
     * @var string
     *
     * @ORM\Column(name="reasonToAddExplain", type="text", nullable=true)
     */
    private $reasonToAddExplain;
    
    /**
     * @var string
     *
     * @ORM\ManyToOne(targetEntity="MaterialPurchaseRequestStatus", cascade={"persist"}, fetch="LAZY")
     * @ORM\JoinColumn(name="materialpurchaserequeststatus_id", referencedColumnName="id", onDelete="SET NULL", nullable=true)
     */
    private $status;
    
    /**
     * @var string
     *
     * @ORM\Column(name="note", type="text", nullable=true)
     */
    private $note;
    
    /**
     * @var \DateTime $created
     *
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(type="datetime")
     */
    private $created;

    /**
     * @var \DateTime $updated
     *
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(type="datetime")
     */
    private $updated;
    
    /**
     * @var string $contentChangedBy
     *
     * @ORM\Column(name="content_changed_by", type="string", nullable=true)
     * @Gedmo\Blameable(on="change", field={"note", "status"})
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
     * Set patronFirstName
     *
     * @param string $patronFirstName
     *
     * @return MaterialPurchaseRequest
     */
    public function setPatronFirstName($patronFirstName)
    {
        $this->patronFirstName = $patronFirstName;

        return $this;
    }

    /**
     * Get patronFirstName
     *
     * @return string
     */
    public function getPatronFirstName()
    {
        return $this->patronFirstName;
    }

    /**
     * Set patronLastName
     *
     * @param string $patronLastName
     *
     * @return MaterialPurchaseRequest
     */
    public function setPatronLastName($patronLastName)
    {
        $this->patronLastName = $patronLastName;

        return $this;
    }

    /**
     * Get patronLastName
     *
     * @return string
     */
    public function getPatronLastName()
    {
        return $this->patronLastName;
    }

    /**
     * Set patronEmail
     *
     * @param string $patronEmail
     *
     * @return MaterialPurchaseRequest
     */
    public function setPatronEmail($patronEmail)
    {
        $this->patronEmail = $patronEmail;

        return $this;
    }

    /**
     * Get patronEmail
     *
     * @return string
     */
    public function getPatronEmail()
    {
        return $this->patronEmail;
    }

    /**
     * Set patronDepartment
     *
     * @param AppBundle\Entity\LiaisonSubject $liaisonSubject
     *
     * @return MaterialPurchaseRequest
     */
    public function setPatronDepartment(LiaisonSubject $liaisonSubject)
    {
        $this->patronDepartment = $liaisonSubject;

        return $this;
    }

    /**
     * Get patronDepartment
     *
     * @return AppBundle\Entity\LiaisonSubject
     */
    public function getPatronDepartment()
    {
        return $this->patronDepartment;
    }

    /**
     * Set patron group
     *
     * @param \AppBundle\Entity\PatronGroup $patronGroup
     *
     * @return Feedback
     */
    public function setPatronGroup(PatronGroup $patronGroup = null)
    {
        $this->patronGroup = $patronGroup;

        return $this;
    }

    /**
     * Get patron group
     *
     * @return \AppBundle\Entity\PatronGroup
     */
    public function getPatronGroup()
    {
        return $this->patronGroup;
    }

    /**
     * Set notify
     *
     * @param boolean $notify
     *
     * @return MaterialPurchaseRequest
     */
    public function setNotify($notify)
    {
        $this->notify = $notify;

        return $this;
    }

    /**
     * Get notify
     *
     * @return boolean
     */
    public function getNotify()
    {
        return $this->notify;
    }

    /**
     * Set isNotified
     *
     * @param boolean $isNotified
     *
     * @return MaterialPurchaseRequest
     */
    public function setIsNotified($isNotified)
    {
        $this->isNotified = $isNotified;

        return $this;
    }

    /**
     * Get isNotified
     *
     * @return boolean
     */
    public function getIsNotified()
    {
        return $this->isNotified;
    }

    /**
     * Set notifiedDate
     *
     * @param \DateTime $notifiedDate
     *
     * @return MaterialPurchaseRequest
     */
    public function setNotifiedDate($notifiedDate)
    {
        $this->notifiedDate = $notifiedDate;

        return $this;
    }

    /**
     * Get notifiedDate
     *
     * @return \DateTime
     */
    public function getNotifiedDate()
    {
        return $this->notifiedDate;
    }

    /**
     * Set title
     *
     * @param string $title
     *
     * @return MaterialPurchaseRequest
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set isbn
     *
     * @param string $isbn
     *
     * @return MaterialPurchaseRequest
     */
    public function setIsbn($isbn)
    {
        $this->isbn = $isbn;

        return $this;
    }

    /**
     * Get isbn
     *
     * @return string
     */
    public function getIsbn()
    {
        return $this->isbn;
    }

    /**
     * Set issn
     *
     * @param string $issn
     *
     * @return MaterialPurchaseRequest
     */
    public function setIssn($issn)
    {
        $this->issn = $issn;

        return $this;
    }

    /**
     * Get issn
     *
     * @return string
     */
    public function getIssn()
    {
        return $this->issn;
    }

    /**
     * Set author
     *
     * @param string $author
     *
     * @return MaterialPurchaseRequest
     */
    public function setAuthor($author)
    {
        $this->author = $author;

        return $this;
    }

    /**
     * Get author
     *
     * @return string
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * Set publisher
     *
     * @param string $publisher
     *
     * @return MaterialPurchaseRequest
     */
    public function setPublisher($publisher)
    {
        $this->publisher = $publisher;

        return $this;
    }

    /**
     * Get publisher
     *
     * @return string
     */
    public function getPublisher()
    {
        return $this->publisher;
    }

    /**
     * Set publicationYear
     *
     * @param integer $publicationYear
     *
     * @return MaterialPurchaseRequest
     */
    public function setPublicationYear($publicationYear)
    {
        $this->publicationYear = $publicationYear;

        return $this;
    }

    /**
     * Get publicationYear
     *
     * @return integer
     */
    public function getPublicationYear()
    {
        return $this->publicationYear;
    }

    /**
     * Set edition
     *
     * @param string $edition
     *
     * @return MaterialPurchaseRequest
     */
    public function setEdition($edition)
    {
        $this->edition = $edition;

        return $this;
    }

    /**
     * Get edition
     *
     * @return string
     */
    public function getEdition()
    {
        return $this->edition;
    }

    /**
     * Set price
     *
     * @param string $price
     *
     * @return MaterialPurchaseRequest
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return string
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set mediaType
     *
     * @param \AppBundle\Entity\MediaType $mediaType
     *
     * @return MaterialPurchaseRequest
     */
    public function setMediaType(MediaType $mediaType)
    {
        $this->mediaType = $mediaType;

        return $this;
    }

    /**
     * Get mediaType
     *
     * @return \AppBundle\Entity\MediaType
     */
    public function getMediaType()
    {
        return $this->mediaType;
    }

    /**
     * Get status
     *
     * @return AppBundle\Entity\MaterialPurchaseRequestStatus
     */
    public function getStatus()
    {
        return $this->status;
    }
    /**
     * Set status
     *
     * @param \AppBundle\Entity\MaterialPurchaseRequestStatus $status
     *
     * @return MaterialPurchaseRequest
     */
    public function setStatus(MaterialPurchaseRequestStatus $status)
    {
        $this->status = $status;

        return $this;
    }
    
    /**
     * Set source
     *
     * @var string $source
     * 
     * @return MaterialPurchaseRequest
     */
    public function setSource($source)
    {
        $this->source = $source;
        
        return $this;
    }

    /**
     * Get source
     *
     * @return string
     */
    public function getSource()
    {
        return $this->source;
    }

    /**
     * Set isInCatalog
     *
     * @param boolean $isInCatalog
     *
     * @return MaterialPurchaseRequest
     */
    public function setIsInCatalog($isInCatalog)
    {
        $this->isInCatalog = $isInCatalog;

        return $this;
    }

    /**
     * Get isInCatalog
     *
     * @return boolean
     */
    public function getIsInCatalog()
    {
        return $this->isInCatalog;
    }

    /**
     * Set reasonToAdd
     *
     * @param \AppBundle\Entity\MaterialPurchaseRequestReason $reasonToAdd
     *
     * @return MaterialPurchaseRequest
     */
    public function setReasonToAdd(MaterialPurchaseRequestReason $reasonToAdd)
    {
        $this->reasonToAdd = $reasonToAdd;

        return $this;
    }

    /**
     * Get reasonToAdd
     *
     * @return \AppBundle\Entity\MaterialPurchaseRequestReason
     */
    public function getReasonToAdd()
    {
        return $this->reasonToAdd;
    }

    /**
     * Set reasonToAddExplain
     *
     * @param string $reasonToAddExplain
     *
     * @return MaterialPurchaseRequest
     */
    public function setReasonToAddExplain($reasonToAddExplain)
    {
        $this->reasonToAddExplain = $reasonToAddExplain;

        return $this;
    }

    /**
     * Get reasonToAddExplain
     *
     * @return string
     */
    public function getReasonToAddExplain()
    {
        return $this->reasonToAddExplain;
    }
    
    /**
     * Get source
     *
     * @return string
     */
    public function getNote()
    {
        return $this->note;
    }

    /**
     * Set isInCatalog
     *
     * @param string $note
     *
     * @return MaterialPurchaseRequest
     */
    public function setNote($note)
    {
        $this->note = $note;

        return $this;
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
     * Get contentChangedBy
     *
     * @return string
     */
    public function getContentChangedBy()
    {
        return $this->contentChangedBy;
    }
    public function setContentChangedBy($changedby)
    {
        $this->contentChangedBy = $changedby;
        
        return $this;
    }
}

