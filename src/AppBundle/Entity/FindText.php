<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * FindText
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class FindText
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
     * @var string
     *
     * @ORM\Column(name="comment", type="text")
     */
    private $comment;
    
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
     * @Gedmo\Blameable(on="change", field={"patronFirstName", "patronLastName", "comment"})
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
     * @return FindText
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
     * @return FindText
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
     * @return Feedback
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
     * Set comment
     *
     * @param string $comment
     *
     * @return FindText
     */
    public function setComment($comment)
    {
        $this->comment = $comment;

        return $this;
    }

    /**
     * Get comment
     *
     * @return string
     */
    public function getComment()
    {
        return $this->comment;
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

