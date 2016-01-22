<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\JoinColumn;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use JMS\Serializer\Annotation as Serializer;
use Hateoas\Configuration\Annotation as Hateoas;


/**
 * LiaisonSubject
 * 
 * @Gedmo\Tree(type="nested")
 * @ORM\HasLifecycleCallbacks
 * @ORM\Table()
 * @ORM\Entity
 * @UniqueEntity(fields={"name"}, message="Department or program already exists.")
 * 
 * @Serializer\XmlRoot("liaisonSubject")
 * @Hateoas\Relation("self", href="expr('/api/liaisons/' ~ object.getId())")
 * @Hateoas\Relation(
 *    "primaryliaison",
 *    href = "expr('/api/staff/' ~ object.getPrimaryLiaison().getId())",
 *    embedded = "expr(object.getPrimaryLiaison())",
 *    exclusion = @Hateoas\Exclusion(excludeIf = "expr(object.getPrimaryLiaison() === null)")
 * )
 * @Hateoas\Relation(
 *    "secondaryliaison",
 *    href = "expr('/api/staff/' ~ object.getSecondaryLiaison().getId())",
 *    embedded = "expr(object.getSecondaryLiaison())",
 *    exclusion = @Hateoas\Exclusion(excludeIf = "expr(object.getSecondaryLiaison() === null)")
 * )
 */
class LiaisonSubject
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
     * @ORM\Column(name="name", type="string", length=100)
     */
    private $name;
    
    /**
     * @var string
     *
     * @ORM\Column(name="phone", type="string", length=15, nullable=true)
     */
    private $phone;
    
    /**
     * @var string
     *
     * @ORM\Column(name="faculty_name", type="string", length=100, nullable=true)
     * @Serializer\Exclude //exclude from API calls 
     */
    private $facultyName;
    
    /**
     * @var string
     *
     * @ORM\Column(name="faculty_phone", type="string", length=15, nullable=true)
     * @Serializer\Exclude //exclude from API calls 
     */
    private $facultyPhone;
    
    /**
     * @var string
     *
     * @ORM\Column(name="faculty_office", type="string", length=15, nullable=true)
     * @Serializer\Exclude //exclude from API calls 
     */
    private $facultyOffice;


    /**
     * @var integer
     *
     * @Gedmo\TreeLeft
     * @ORM\Column(name="lft", type="integer")
     * @Serializer\Exclude //exclude from API calls 
     */
    private $lft;

    /**
     * @var integer
     *
     * @Gedmo\TreeLevel
     * @ORM\Column(name="lvl", type="integer")
     */
    private $lvl;

    /**
     * @var integer
     *
     * @Gedmo\TreeRight
     * @ORM\Column(name="rgt", type="integer")
     * @Serializer\Exclude //exclude from API calls 
     */
    private $rgt;

    /**
     * @var integer
     * 
     * @Gedmo\TreeRoot
     * @ORM\Column(name="root", type="integer", nullable=true)
     * @Serializer\Exclude //exclude from API calls 
     */
    private $root;
    
    /**
     * @Gedmo\TreeParent
     * @ORM\ManyToOne(targetEntity="LiaisonSubject", inversedBy="children")
     * @ORM\JoinColumn(name="parent_id", referencedColumnName="id", onDelete="CASCADE")
     */
    private $parent;

    /**
     * @ORM\OneToMany(targetEntity="LiaisonSubject", mappedBy="parent")
     * @ORM\OrderBy({"name" = "ASC"})
     */
    private $children;
    
    /**
     * @ORM\ManyToOne(targetEntity="Staff")
     * @JoinColumn(name="primary_liaison", referencedColumnName="id", nullable=true, onDelete="SET NULL")
     * @Serializer\Exclude //embedded
     */
    private $primaryLiaison;
    
    /**
     * @ORM\ManyToOne(targetEntity="Staff")
     * @JoinColumn(name="secondary_liaison", referencedColumnName="id", nullable=true, onDelete="SET NULL")
     * @Serializer\Exclude //embedded
     */
    private $secondaryLiaison;
    
    /**
     * @var \DateTime $created
     *
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(type="datetime")
     * @Serializer\Exclude //exclude from API calls 
     */
    private $created;

    /**
     * @var \DateTime $updated
     *
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(type="datetime")
     * @Serializer\Exclude //exclude from API calls 
     */
    private $updated;
    
    /**
     * @var string $contentChangedBy
     *
     * @ORM\Column(name="content_changed_by", type="string", nullable=true)
     * @Gedmo\Blameable(on="change", field={"name", "phone", "parent", "primaryLiaison", "secondaryLiaison"})
     * @Serializer\Exclude //exclude from API calls 
     */
    private $contentChangedBy;


    private $indentedName; //use get method to display nested tree format
    
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->children = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Get name with indentations for nested lists
     * 
     * @return string
     */
    public function getIndentedTitle(){
      return str_repeat("-", $this->lvl)." ".$this->name;
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
     * @return LiaisonSubject
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
     * Set phone
     *
     * @param string $phone
     *
     * @return LiaisonSubject
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
     * Set faculty name
     *
     * @param string $facultyName
     *
     * @return LiaisonSubject
     */
    public function setFacultyName($facultyName)
    {
        $this->facultyName = $facultyName;

        return $this;
    }

    /**
     * Get faculty name
     *
     * @return string
     */
    public function getFacultyName()
    {
        return $this->facultyName;
    }
    
    /**
     * Set faculty phone
     *
     * @param string $facultyPhone
     *
     * @return LiaisonSubject
     */
    public function setFacultyPhone($facultyPhone)
    {
        $this->facultyPhone = $facultyPhone;
        
        return $this;
    }

    /**
     * Get faculty phone
     *
     * @return string
     */
    public function getFacultyPhone()
    {
        return $this->facultyPhone;
    }
    
    /**
     * Set faculty office
     *
     * @param string $facultyOffice
     *
     * @return LiaisonSubject
     */
    public function setFacultyOffice($facultyOffice)
    {
        $this->facultyOffice = $facultyOffice;
        
        return $this;
    }

    /**
     * Get faculty office
     *
     * @return string
     */
    public function getFacultyOffice()
    {
        return $this->facultyOffice;
    }

    /**
     * Set lft
     *
     * @param integer $lft
     *
     * @return LiaisonSubject
     */
    public function setLft($lft)
    {
        $this->lft = $lft;

        return $this;
    }

    /**
     * Get lft
     *
     * @return integer
     */
    public function getLft()
    {
        return $this->lft;
    }

    /**
     * Set lvl
     *
     * @param integer $lvl
     *
     * @return LiaisonSubject
     */
    public function setLvl($lvl)
    {
        $this->lvl = $lvl;

        return $this;
    }

    /**
     * Get lvl
     *
     * @return integer
     */
    public function getLvl()
    {
        return $this->lvl;
    }

    /**
     * Set rgt
     *
     * @param integer $rgt
     *
     * @return LiaisonSubject
     */
    public function setRgt($rgt)
    {
        $this->rgt = $rgt;

        return $this;
    }

    /**
     * Get rgt
     *
     * @return integer
     */
    public function getRgt()
    {
        return $this->rgt;
    }

    /**
     * Set root
     *
     * @param integer $root
     *
     * @return LiaisonSubject
     */
    public function setRoot($root)
    {
        $this->root = $root;

        return $this;
    }

    /**
     * Get root
     *
     * @return integer
     */
    public function getRoot()
    {
        return $this->root;
    }
    
    /**
     * Set parent
     *
     * @param \AppBundle\Entity\LiaisonSubject $parent
     *
     * @return LiaisonSubject
     */
    public function setParent(\AppBundle\Entity\LiaisonSubject $parent = null)
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * Get parent
     *
     * @return \AppBundle\Entity\LiaisonSubject
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * Add child
     *
     * @param \AppBundle\Entity\LiaisonSubject $child
     *
     * @return StaffArea
     */
    public function addChild(\AppBundle\Entity\LiaisonSubject $child)
    {
        $this->children[] = $child;

        return $this;
    }

    /**
     * Remove child
     *
     * @param \AppBundle\Entity\LiaisonSubject $child
     */
    public function removeChild(\AppBundle\Entity\LiaisonSubject $child)
    {
        $this->children->removeElement($child);
    }

    /**
     * Get children
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getChildren()
    {
        return $this->children;
    }
    
    /**
     * Set primary liaison
     *
     * @param \AppBundle\Entity\Staff $primaryLiaison
     *
     * @return Staff
     */
    public function setPrimaryLiaison(\AppBundle\Entity\Staff $primaryLiaison = null)
    {
        $this->primaryLiaison = $primaryLiaison;

        return $this;
    }
    
    /**
     * Get primary liaison
     *
     * @return Staff
     */
    public function getPrimaryLiaison()
    {
        return $this->primaryLiaison;
    }
    
    /**
     * Set secondary liaison
     *
     * @param \AppBundle\Entity\Staff $primaryLiaison
     *
     * @return Staff
     */
    public function setSecondaryLiaison(\AppBundle\Entity\Staff $secondaryLiaison = null)
    {
        $this->secondaryLiaison = $secondaryLiaison;

        return $this;
    }
    
    /**
     * Get secondary liaison
     *
     * @return Staff
     */
    public function getSecondaryLiaison()
    {
        return $this->secondaryLiaison;
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
      return $this->getTitle();
    }
}

