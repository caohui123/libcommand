<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * BookSearchRequest
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class BookSearchRequest
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
     * @ORM\Column(name="bookTitle", type="string", length=255)
     */
    private $bookTitle;

    /**
     * @var string
     *
     * @ORM\Column(name="bookAuthor", type="string", length=255)
     */
    private $bookAuthor;

    /**
     * @var string
     *
     * @ORM\Column(name="bookCallNumber", type="string", length=40)
     */
    private $bookCallNumber;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="usefulDate", type="datetime", nullable=true)
     */
    private $usefulDate;

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
     * @ORM\Column(name="patronPhone", type="string", length=15)
     */
    private $patronPhone;
    
    /**
     * @var string
     *
     * @ORM\Column(name="patronENumber", type="string", length=9)
     */
    private $patronENumber;
    
    /**
     * @var string
     *
     * @ORM\Column(name="note", type="text", nullable=true)
     */
    private $note;

    /**
     * @var string
     *
     * @ORM\Column(name="patronEmail", type="string", length=40)
     */
    private $patronEmail;
    
    /**
     * @var string
     *
     * @ORM\Column(name="bookStatus", type="string")
     */
    private $bookStatus;
    
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="patronEmailed", type="datetime")
     */
    private $patronEmailed;
    
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
     * @Gedmo\Blameable(on="change", field={"bookStatus", "bookTitle", "bookAuthor", "bookCallNumber", "isPatronEmailed", "patronEmailed"})
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
     * Set bookTitle
     *
     * @param string $bookTitle
     *
     * @return BookSearchRequest
     */
    public function setBookTitle($bookTitle)
    {
        $this->bookTitle = $bookTitle;

        return $this;
    }

    /**
     * Get bookTitle
     *
     * @return string
     */
    public function getBookTitle()
    {
        return $this->bookTitle;
    }

    /**
     * Set bookAuthor
     *
     * @param string $bookAuthor
     *
     * @return BookSearchRequest
     */
    public function setBookAuthor($bookAuthor)
    {
        $this->bookAuthor = $bookAuthor;

        return $this;
    }

    /**
     * Get bookAuthor
     *
     * @return string
     */
    public function getBookAuthor()
    {
        return $this->bookAuthor;
    }

    /**
     * Set bookCallNumber
     *
     * @param string $bookCallNumber
     *
     * @return BookSearchRequest
     */
    public function setBookCallNumber($bookCallNumber)
    {
        $this->bookCallNumber = $bookCallNumber;

        return $this;
    }

    /**
     * Get bookCallNumber
     *
     * @return string
     */
    public function getBookCallNumber()
    {
        return $this->bookCallNumber;
    }

    /**
     * Set usefulDate
     *
     * @param \DateTime $usefulDate
     *
     * @return BookSearchRequest
     */
    public function setUsefulDate($usefulDate)
    {
        $this->usefulDate = $usefulDate;

        return $this;
    }

    /**
     * Get usefulDate
     *
     * @return \DateTime
     */
    public function getUsefulDate()
    {
        return $this->usefulDate;
    }

    /**
     * Set patronFirstName
     *
     * @param string $patronFirstName
     *
     * @return BookSearchRequest
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
     * @return BookSearchRequest
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
     * Set patronPhone
     *
     * @param string $patronPhone
     *
     * @return BookSearchRequest
     */
    public function setPatronPhone($patronPhone)
    {
        $this->patronPhone = $patronPhone;

        return $this;
    }

    /**
     * Get patronPhone
     *
     * @return string
     */
    public function getPatronPhone()
    {
        return $this->patronPhone;
    }
    
    /**
     * Set patronENumber
     *
     * @param string $patronENumber
     *
     * @return BookSearchRequest
     */
    public function setPatronENumber($patronENumber)
    {
        $this->patronENumber = $patronENumber;

        return $this;
    }

    /**
     * Get patronENumber
     *
     * @return string
     */
    public function getPatronENumber()
    {
        return $this->patronENumber;
    }

    /**
     * Set patronEmail
     *
     * @param string $patronEmail
     *
     * @return BookSearchRequest
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
     * Set note
     *
     * @param string $note
     *
     * @return BookSearchRequest
     */
    public function setNote($note)
    {
        $this->note = $note;

        return $this;
    }

    /**
     * Get note
     *
     * @return string
     */
    public function getNote()
    {
        return $this->note;
    }
    
    /**
     * Set bookStatus
     *
     * @param string $bookStatus
     *
     * @return BookSearchRequest
     */
    public function setBookStatus($bookStatus)
    {
        $this->bookStatus = $bookStatus;

        return $this;
    }

    /**
     * Get bookStatus
     *
     * @return string
     */
    public function getBookStatus()
    {
        return $this->bookStatus;
    }
    
    /**
     * Set patronEmailed
     *
     * @param \DateTime $patronEmailed
     *
     * @return BookSearchRequest
     */
    public function setPatronEmailed(\DateTime $patronEmailed)
    {
        $this->patronEmailed = $patronEmailed;

        return $this;
    }

    /**
     * Get patronEmailed
     *
     * @return \DateTime
     */
    public function getPatronEmailed()
    {
        return $this->patronEmailed;
    }
    
    public function getCreated()
    {
        return $this->created;
    }

    public function getUpdated()
    {
        return $this->updated;
    }
    
    public function getContentChangedBy()
    {
        return $this->contentChangedBy;
    }
}

