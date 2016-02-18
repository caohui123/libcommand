<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use AppBundle\Entity\MaterialReserveMedia;
use Symfony\Component\Validator\Constraints as Assert;
use AppBundle\Entity\MaterialReserve;

/**
 * MaterialReserveItem
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class MaterialReserveItem
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
     * @ORM\Column(name="author", type="string", length=100, nullable=true)
     */
    private $author;

    /**
     * @var string
     *
     * @ORM\Column(name="edition", type="string", length=15, nullable=true)
     */
    private $edition;

    /**
     * @var integer
     *
     * @ORM\Column(name="circulationHours", type="integer", nullable=true)
     */
    private $circulationHours;
    
    /**
     * @var AppBundle\Entity\MaterialReserveMedia
     *
     * @ORM\ManyToOne(targetEntity="MaterialReserveMedia", cascade={"persist"}, fetch="LAZY")
     * @ORM\JoinColumn(name="mediareservemedia_id", referencedColumnName="id", onDelete="SET NULL")
     */
    private $materialReserveMedia;
    
    /**
     * @ORM\ManyToOne(targetEntity="MaterialReserve", inversedBy="items", cascade={"persist"})
     * @ORM\JoinColumn(name="materialreserve_id", referencedColumnName="id", onDelete="CASCADE")
     * @Assert\NotBlank()
     */
    private $materialreserve;
    
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
     * @Gedmo\Blameable(on="change", field={"title", "author", "edition", "circulationHours"})
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
     * @return MaterialReserveItem
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
     * Set author
     *
     * @param string $author
     *
     * @return MaterialReserveItem
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
     * Set edition
     *
     * @param string $edition
     *
     * @return MaterialReserveItem
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
     * Set circulationHours
     *
     * @param integer $circulationHours
     *
     * @return MaterialReserveItem
     */
    public function setCirculationHours($circulationHours)
    {
        $this->circulationHours = $circulationHours;

        return $this;
    }

    /**
     * Get circulationHours
     *
     * @return integer
     */
    public function getCirculationHours()
    {
        return $this->circulationHours;
    }
    
    /**
     * Set materialReserveMedia
     *
     * @param \AppBundle\Entity\MaterialReserveMedia $materialReserveMedia
     *
     * @return MaterialPurchaseRequest
     */
    public function setMaterialReserveMedia(MaterialReserveMedia $materialReserveMedia)
    {
        $this->materialReserveMedia = $materialReserveMedia;

        return $this;
    }

    /**
     * Get MaterialReserveMedia
     *
     * @return \AppBundle\Entity\MediaType
     */
    public function getMaterialReserveMedia()
    {
        return $this->materialReserveMedia;
    }
    
    /**
     * Set materialReserveMedia
     *
     * @param \AppBundle\Entity\MaterialReserve $materialReserve
     *
     * @return MaterialReserveItem
     */
    public function setMaterialReserve(MaterialReserve $materialReserve)
    {
        $this->materialreserve = $materialReserve;

        return $this;
    }

    /**
     * Get MaterialReserve
     *
     * @return \AppBundle\Entity\MaterialReserve
     */
    public function getMaterialReserve()
    {
        return $this->materialreserve;
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
    
    public function __toString() {
       return $this->getName(); 
    }
}

