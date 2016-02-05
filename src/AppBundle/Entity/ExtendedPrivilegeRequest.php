<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use AppBundle\Entity\LiaisonSubject;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;
use AppBundle\Entity\ExtendedPrivilegeRequestStatus;

/**
 * ExtendedPrivilegeRequest
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class ExtendedPrivilegeRequest
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
     * @ORM\Column(name="expirationDate", type="date")
     */
    private $expirationDate;

    /**
     * @var string
     *
     * @ORM\Column(name="studentFirstName", type="string", length=40)
     */
    private $studentFirstName;

    /**
     * @var string
     *
     * @ORM\Column(name="studentLastName", type="string", length=40)
     */
    private $studentLastName;

    /**
     * @var string
     *
     * @ORM\Column(name="studentEnumber", type="string", length=10)
     */
    private $studentEnumber;

    /**
     * @var string
     *
     * @ORM\Column(name="studentEmail", type="string", length=40)
     */
    private $studentEmail;

    /**
     * @var string
     *
     * @ORM\Column(name="studentPhone", type="string", length=15)
     */
    private $studentPhone;

    /**
     * @var string
     *
     * @ORM\Column(name="facultyFirstName", type="string", length=40)
     */
    private $facultyFirstName;

    /**
     * @var string
     *
     * @ORM\Column(name="facultyLastName", type="string", length=40)
     */
    private $facultyLastName;

    /**
     * @var string
     *
     * @ORM\Column(name="facultyEmail", type="string", length=30)
     */
    private $facultyEmail;

    /**
     * @var string
     *
     * @ORM\Column(name="facultyPhone", type="string", length=15)
     */
    private $facultyPhone;

    /**
     * @ORM\ManyToOne(targetEntity="LiaisonSubject")
     * @ORM\JoinColumn(name="liaisonsubject_id", referencedColumnName="id", nullable=true)
     */
    private $facultySubject;

    /**
     * @var string
     *
     * @ORM\Column(name="note", type="text", nullable=true)
     */
    private $note;

    /**
     * @ORM\ManyToOne(targetEntity="ExtendedPrivilegeRequestStatus")
     * @ORM\JoinColumn(name="extendedprivilegerequeststatus_id", referencedColumnName="id", nullable=true)
     */
    private $status;
    
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
     * Set expirationDate
     *
     * @param \DateTime $expirationDate
     *
     * @return ExtendedPrivilegeRequest
     */
    public function setExpirationDate(\DateTime $expirationDate)
    {
        $this->expirationDate = $expirationDate;

        return $this;
    }

    /**
     * Get expirationDate
     *
     * @return \DateTime
     */
    public function getExpirationDate()
    {
        return $this->expirationDate;
    }

    /**
     * Set studentFirstName
     *
     * @param string $studentFirstName
     *
     * @return ExtendedPrivilegeRequest
     */
    public function setStudentFirstName($studentFirstName)
    {
        $this->studentFirstName = $studentFirstName;

        return $this;
    }

    /**
     * Get studentFirstName
     *
     * @return string
     */
    public function getStudentFirstName()
    {
        return $this->studentFirstName;
    }

    /**
     * Set studentLastName
     *
     * @param string $studentLastName
     *
     * @return ExtendedPrivilegeRequest
     */
    public function setStudentLastName($studentLastName)
    {
        $this->studentLastName = $studentLastName;

        return $this;
    }

    /**
     * Get studentLastName
     *
     * @return string
     */
    public function getStudentLastName()
    {
        return $this->studentLastName;
    }

    /**
     * Set studentEnumber
     *
     * @param string $studentEnumber
     *
     * @return ExtendedPrivilegeRequest
     */
    public function setStudentEnumber($studentEnumber)
    {
        $this->studentEnumber = $studentEnumber;

        return $this;
    }

    /**
     * Get studentEnumber
     *
     * @return string
     */
    public function getStudentEnumber()
    {
        return $this->studentEnumber;
    }

    /**
     * Set studentEmail
     *
     * @param string $studentEmail
     *
     * @return ExtendedPrivilegeRequest
     */
    public function setStudentEmail($studentEmail)
    {
        $this->studentEmail = $studentEmail;

        return $this;
    }

    /**
     * Get studentEmail
     *
     * @return string
     */
    public function getStudentEmail()
    {
        return $this->studentEmail;
    }

    /**
     * Set studentPhone
     *
     * @param string $studentPhone
     *
     * @return ExtendedPrivilegeRequest
     */
    public function setStudentPhone($studentPhone)
    {
        $this->studentPhone = $studentPhone;

        return $this;
    }

    /**
     * Get studentPhone
     *
     * @return string
     */
    public function getStudentPhone()
    {
        return $this->studentPhone;
    }

    /**
     * Set facultyFirstName
     *
     * @param string $facultyFirstName
     *
     * @return ExtendedPrivilegeRequest
     */
    public function setFacultyFirstName($facultyFirstName)
    {
        $this->facultyFirstName = $facultyFirstName;

        return $this;
    }

    /**
     * Get facultyFirstName
     *
     * @return string
     */
    public function getFacultyFirstName()
    {
        return $this->facultyFirstName;
    }

    /**
     * Set facultyLastName
     *
     * @param string $facultyLastName
     *
     * @return ExtendedPrivilegeRequest
     */
    public function setFacultyLastName($facultyLastName)
    {
        $this->facultyLastName = $facultyLastName;

        return $this;
    }

    /**
     * Get facultyLastName
     *
     * @return string
     */
    public function getFacultyLastName()
    {
        return $this->facultyLastName;
    }

    /**
     * Set facultyEmail
     *
     * @param string $facultyEmail
     *
     * @return ExtendedPrivilegeRequest
     */
    public function setFacultyEmail($facultyEmail)
    {
        $this->facultyEmail = $facultyEmail;

        return $this;
    }

    /**
     * Get facultyEmail
     *
     * @return string
     */
    public function getFacultyEmail()
    {
        return $this->facultyEmail;
    }

    /**
     * Set facultyPhone
     *
     * @param string $facultyPhone
     *
     * @return ExtendedPrivilegeRequest
     */
    public function setFacultyPhone($facultyPhone)
    {
        $this->facultyPhone = $facultyPhone;

        return $this;
    }

    /**
     * Get facultyPhone
     *
     * @return string
     */
    public function getFacultyPhone()
    {
        return $this->facultyPhone;
    }

    /**
     * Set facultySubject
     *
     * @param AppBundle\Entity\LiaisonSubject $liaisonSubject
     *
     * @return AvRequest
     */
    public function setFacultySubject(LiaisonSubject $liaisonSubject)
    {
        $this->facultySubject = $liaisonSubject;

        return $this;
    }

    /**
     * Get facultySubject
     *
     * @return AppBundle\Entity\LiaisonSubject
     */
    public function getFacultySubject()
    {
        return $this->facultySubject;
    }

    /**
     * Set note
     *
     * @param string $note
     *
     * @return ExtendedPrivilegeRequest
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
     * Set status
     *
     * @param AppBundle\Entity\ExtendedPrivilegeRequestStatus $status
     *
     * @return ExtendedPrivilegeRequest
     */
    public function setStatus(ExtendedPrivilegeRequestStatus $status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return AppBundle\Entity\ExtendedPrivilegeRequestStatus
     */
    public function getStatus()
    {
        return $this->status;
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

