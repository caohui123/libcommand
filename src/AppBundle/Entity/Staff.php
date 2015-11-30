<?php

namespace AppBundle\Entity;

use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Staff
 *
 * @ORM\Table()
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 * @UniqueEntity(fields={"staffId"}, message="A staff member with that ID already exists.")
 * @UniqueEntity(fields={"firstName", "lastName"}, message="A staff member by that name already exists.")
 * @UniqueEntity(fields={"email"}, message="A staff member with email already exists.")
 */
class Staff
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
     * @ORM\Column(name="staffId", type="string", length=7)
     */
    private $staffId;

    /**
     * @var string
     *
     * @ORM\Column(name="employmentStatus", type="string")
     */
    private $employmentStatus;

    /**
     * @var string
     *
     * @ORM\Column(name="firstName", type="string", length=40)
     */
    private $firstName;

    /**
     * @var string
     *
     * @ORM\Column(name="lastName", type="string", length=55)
     */
    private $lastName;

    /**
     * @var string
     *
     * @ORM\Column(name="jobTitle", type="string", length=120)
     */
    private $jobTitle;

    /**
     * @var string
     *
     * @ORM\Column(name="guidesUrl", type="string", length=255)
     */
    private $guidesUrl;

    /**
     * @var string
     *
     * @ORM\Column(name="office", type="string", length=20)
     */
    private $office;

    /**
     * @var string
     *
     * @ORM\Column(name="phone", type="string", length=12)
     */
    private $phone;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=30)
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="jobDescription", type="text")
     */
    private $jobDescription;

    /**
     * @var boolean
     *
     * @ORM\Column(name="showPhoto", type="boolean")
     */
    private $showPhoto;

    /**
     * @var string
     *
     * @ORM\Column(name="homeStreet", type="string", length=70)
     */
    private $homeStreet;
    
    /**
     * @var string
     *
     * @ORM\Column(name="homeCity", type="string", length=20)
     */
    private $homeCity;
    
    /**
     * @var string
     *
     * @ORM\Column(name="homeState", type="string", length=2)
     */
    private $homeState;

    /**
     * @var string
     *
     * @ORM\Column(name="homeZip", type="string", length=10)
     */
    private $homeZip;

    /**
     * @var string
     *
     * @ORM\Column(name="homePhone", type="string", length=12)
     */
    private $homePhone;

    /**
     * @var string
     *
     * @ORM\Column(name="cellPhone", type="string", length=12)
     */
    private $cellPhone;

    /**
     * @var string
     *
     * @ORM\Column(name="selfIntro", type="text")
     */
    private $selfIntro;

    /**
     * @var string
     *
     * @ORM\Column(name="favoriteWebsites", type="text")
     */
    private $favoriteWebsites;

    /**
     * @var string
     *
     * @ORM\Column(name="photo", type="blob", nullable=true)
     */
    private $photo;
    
    /**
     * @ORM\ManyToOne(targetEntity="StaffArea", cascade={"persist"}, fetch="LAZY")
     */
    private $staffFunctionalArea;
    
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
     * @Gedmo\Blameable(on="change", field={"firstName", "lastName"})
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
     * Set staffId
     *
     * @param string $staffId
     *
     * @return Staff
     */
    public function setStaffId($staffId)
    {
        $this->staffId = $staffId;

        return $this;
    }

    /**
     * Get staffId
     *
     * @return string
     */
    public function getStaffId()
    {
        return $this->staffId;
    }

    /**
     * Set employmentStatus
     *
     * @param array $employmentStatus
     *
     * @return Staff
     */
    public function setEmploymentStatus($employmentStatus)
    {
        $this->employmentStatus = $employmentStatus;

        return $this;
    }

    /**
     * Get employmentStatus
     *
     * @return array
     */
    public function getEmploymentStatus()
    {
        return $this->employmentStatus;
    }

    /**
     * Set firstName
     *
     * @param string $firstName
     *
     * @return Staff
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * Get firstName
     *
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * Set lastName
     *
     * @param string $lastName
     *
     * @return Staff
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * Get lastName
     *
     * @return string
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * Set jobTitle
     *
     * @param string $jobTitle
     *
     * @return Staff
     */
    public function setJobTitle($jobTitle)
    {
        $this->jobTitle = $jobTitle;

        return $this;
    }

    /**
     * Get jobTitle
     *
     * @return string
     */
    public function getJobTitle()
    {
        return $this->jobTitle;
    }

    /**
     * Set guidesUrl
     *
     * @param string $guidesUrl
     *
     * @return Staff
     */
    public function setGuidesUrl($guidesUrl)
    {
        $this->guidesUrl = $guidesUrl;

        return $this;
    }

    /**
     * Get guidesUrl
     *
     * @return string
     */
    public function getGuidesUrl()
    {
        return $this->guidesUrl;
    }

    /**
     * Set office
     *
     * @param string $office
     *
     * @return Staff
     */
    public function setOffice($office)
    {
        $this->office = $office;

        return $this;
    }

    /**
     * Get office
     *
     * @return string
     */
    public function getOffice()
    {
        return $this->office;
    }

    /**
     * Set phone
     *
     * @param string $phone
     *
     * @return Staff
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * Get phone
     *
     * @return string
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return Staff
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set jobDescription
     *
     * @param string $jobDescription
     *
     * @return Staff
     */
    public function setJobDescription($jobDescription)
    {
        $this->jobDescription = $jobDescription;

        return $this;
    }

    /**
     * Get jobDescription
     *
     * @return string
     */
    public function getJobDescription()
    {
        return $this->jobDescription;
    }

    /**
     * Set showPhoto
     *
     * @param boolean $showPhoto
     *
     * @return Staff
     */
    public function setShowPhoto($showPhoto)
    {
        $this->showPhoto = $showPhoto;

        return $this;
    }

    /**
     * Get showPhoto
     *
     * @return boolean
     */
    public function getShowPhoto()
    {
        return $this->showPhoto;
    }

    /**
     * Set homeStreet
     *
     * @param string $homeStreet
     *
     * @return Staff
     */
    public function setHomeStreet($homeStreet)
    {
        $this->homeStreet = $homeStreet;

        return $this;
    }

    /**
     * Get homeStreet
     *
     * @return string
     */
    public function getHomeStreet()
    {
        return $this->homeStreet;
    }
    
    /**
     * Set homeCity
     *
     * @param string $homeCity
     *
     * @return Staff
     */
    public function setHomeCity($homeCity)
    {
        $this->homeCity = $homeCity;

        return $this;
    }

    /**
     * Get homeCity
     *
     * @return string
     */
    public function getHomeCity()
    {
        return $this->homeCity;
    }
    
    /**
     * Set homeState
     *
     * @param string $homeState
     *
     * @return Staff
     */
    public function setHomeState($homeState)
    {
        $this->homeState = $homeState;

        return $this;
    }

    /**
     * Get homeState
     *
     * @return string
     */
    public function getHomeState()
    {
        return $this->homeState;
    }

    /**
     * Set homeZip
     *
     * @param string $homeZip
     *
     * @return Staff
     */
    public function setHomeZip($homeZip)
    {
        $this->homeZip = $homeZip;

        return $this;
    }

    /**
     * Get homeZip
     *
     * @return string
     */
    public function getHomeZip()
    {
        return $this->homeZip;
    }

    /**
     * Set homePhone
     *
     * @param string $homePhone
     *
     * @return Staff
     */
    public function setHomePhone($homePhone)
    {
        $this->homePhone = $homePhone;

        return $this;
    }

    /**
     * Get homePhone
     *
     * @return string
     */
    public function getHomePhone()
    {
        return $this->homePhone;
    }

    /**
     * Set cellPhone
     *
     * @param string $cellPhone
     *
     * @return Staff
     */
    public function setCellPhone($cellPhone)
    {
        $this->cellPhone = $cellPhone;

        return $this;
    }

    /**
     * Get cellPhone
     *
     * @return string
     */
    public function getCellPhone()
    {
        return $this->cellPhone;
    }

    /**
     * Set selfIntro
     *
     * @param string $selfIntro
     *
     * @return Staff
     */
    public function setSelfIntro($selfIntro)
    {
        $this->selfIntro = $selfIntro;

        return $this;
    }

    /**
     * Get selfIntro
     *
     * @return string
     */
    public function getSelfIntro()
    {
        return $this->selfIntro;
    }

    /**
     * Set favoriteWebsites
     *
     * @param string $favoriteWebsites
     *
     * @return Staff
     */
    public function setFavoriteWebsites($favoriteWebsites)
    {
        $this->favoriteWebsites = $favoriteWebsites;

        return $this;
    }

    /**
     * Get favoriteWebsites
     *
     * @return string
     */
    public function getFavoriteWebsites()
    {
        return $this->favoriteWebsites;
    }

    /**
     * Set photo
     *
     * @param string $photo
     *
     * @return Staff
     */
    public function setPhoto($photo)
    {
        $this->photo = $photo;

        return $this;
    }

    /**
     * Get photo
     *
     * @return string
     */
    public function getPhoto()
    {
        return $this->photo;
    }

    /**
     * Set staffFunctionalArea
     *
     * @param \AppBundle\Entity\StaffFunctionalArea $staffFunctionalArea
     *
     * @return Staff
     */
    public function setStaffFunctionalArea(\AppBundle\Entity\StaffArea $staffFunctionalArea = null)
    {
        $this->staffFunctionalArea = $staffFunctionalArea;

        return $this;
    }

    /**
     * Get staffFunctionalArea
     *
     * @return \AppBundle\Entity\StaffFunctionalArea
     */
    public function getStaffFunctionalArea()
    {
        return $this->staffFunctionalArea;
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
    
    public function __toString() {
      return $this->getLastName() . ', ' . $this->getFirstName();
    }
}
