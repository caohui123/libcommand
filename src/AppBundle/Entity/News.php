<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use AppBundle\Entity\User;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;
use JMS\Serializer\Annotation as Serializer;
use Hateoas\Configuration\Annotation as Hateoas;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

/**
 * News
 *
 * @ORM\Table()
 * @ORM\Entity
 * 
 * @Serializer\XmlRoot("news")
 * @Hateoas\Relation("self", href="expr('/api/news/' ~ object.getId())")
 */
class News
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
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;
    
    /**
     * @var string
     *
     * @ORM\Column(name="teaser", type="string", length=100)
     */
    private $teaser;

    /**
     * @var string
     *
     * @ORM\Column(name="body", type="text")
     */
    private $body;
    
    /**
     * @var string
     *
     * @ORM\ManyToOne(targetEntity="User", cascade={"persist"}, fetch="LAZY")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id", onDelete="SET NULL")
     * 
     * @Serializer\Exclude //exclude from API calls 
     */
    private $author;
    
    /**
     * @var \DateTime $displayStart
     *
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $displayStart;
    
    /**
     * @var \DateTime $displayEnd
     *
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $displayEnd;
    
    /**
     * @var boolean
     *
     * @ORM\Column(name="hidden", type="boolean")
     */
    private $hidden;
    
    
    /**
     * @var boolean
     *
     * @ORM\Column(name="emergency", type="boolean")
     */
    private $emergency;
    
    /**
     * @var string 
     *
     * @ORM\Column(name="emergencyLevel", type="string", length=50, nullable=true)
     */
    private $emergencyLevel;
    
    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $photo;
    
    //UNMAPPED! used only for validation (getter and setter below)
    private $delayedPost;
    
    private $currentPhoto;
    
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
     * @Gedmo\Blameable(on="change", field={"title", "body", "hidden"})
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
     * Set title
     *
     * @param string $title
     *
     * @return News
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
     * Set teaser
     *
     * @param string $teaser
     *
     * @return News
     */
    public function setTeaser($teaser)
    {
        $this->teaser = $teaser;

        return $this;
    }

    /**
     * Get teaser
     *
     * @return string
     */
    public function getTeaser()
    {
        return $this->teaser;
    }

    /**
     * Set body
     *
     * @param string $body
     *
     * @return News
     */
    public function setBody($body)
    {
        $this->body = $body;

        return $this;
    }

    /**
     * Get body
     *
     * @return string
     */
    public function getBody()
    {
        return $this->body;
    }
    
    /**
     * Set author
     *
     * @param \AppBundle\Entity\User $user
     *
     * @return News
     */
    public function setAuthor(User $user)
    {
        $this->author = $user;

        return $this;
    }

    /**
     * Get author
     *
     * @return \AppBundle\Entity\User
     */
    public function getAuthor()
    {
        return $this->author;
    }
    
    /**
     * Get displayStart
     *
     * @return \DateTime
     */
    public function getDisplayStart()
    {
        return $this->displayStart;
    }
    public function setDisplayStart($displayStart = null)
    {
        $this->displayStart = $displayStart;
        
        return $this;
    }
    
    /**
     * Get displayEnd
     *
     * @return \DateTime
     */
    public function getDisplayEnd()
    {
        return $this->displayEnd;
    }
    public function setDisplayEnd($displayEnd = null)
    {
        $this->displayEnd = $displayEnd;
        
        return $this;
    }
    
    /**
     * Get emergency
     *
     * @return bool
     */
    public function getEmergency()
    {
        return $this->emergency;
    }
    public function setEmergency($emergency)
    {
        $this->emergency = $emergency;
        
        return $this;
    }
    
    /**
     * Get emergencyLevel
     *
     * @return string
     */
    public function getEmergencyLevel()
    {
        return $this->emergencyLevel;
    }
    public function setEmergencyLevel($emergencyLevel)
    {
        $this->emergencyLevel = $emergencyLevel;
        
        return $this;
    }

    /**
     * Set hidden
     *
     * @param boolean $hidden
     *
     * @return News
     */
    public function setHidden($hidden)
    {
        $this->hidden = $hidden;

        return $this;
    }

    /**
     * Get hidden
     *
     * @return boolean
     */
    public function getHidden()
    {
        return $this->hidden;
    }
    
    /**
     * Get delayedPost
     *
     * @return string
     */
    public function getDelayedPost()
    {
        return $this->delayedPost;
    }
    public function setDelayedPost($delayedPost)
    {
        $this->delayedPost = $delayedPost;
        
        return $this;
    }
    
    /**
     * Set photo
     *
     * @param string $photo
     *
     * @return News
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
     * Set currentPhoto
     *
     * @param string $currentPhoto
     *
     * @return Staff
     */
    public function setCurrentPhoto($currentPhoto)
    {
        $this->currentPhoto = $currentPhoto;

        return $this;
    }

    /**
     * Get currentPhoto
     *
     * @return string
     */
    public function getCurrentPhoto()
    {
        return $this->currentPhoto;
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
    
    /**
     *  Custom validation for emergency News entities
     *  
     *  @Assert\Callback
     */
    public function validate(ExecutionContextInterface $context){
        if(1 == $this->getEmergency() && null === $this->getEmergencyLevel()){
            $context->buildViolation('You must specify the type of alert. If this is not an alert bulletin, please uncheck the box above.')
                    ->atPath('emergencyLevel')
                    ->addViolation();
        }
        
        if( 1 == $this->getDelayedPost() && null === $this->getDisplayStart() ){
            $context->buildViolation('Since this is a delayed post, you must at least enter a start time. Otherwise, switch this option off above.')
                    ->atPath('displayStart')
                    ->addViolation();
        }
    }
}

