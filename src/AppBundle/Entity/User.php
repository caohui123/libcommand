<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Model\User as BaseUser;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * User
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="AppBundle\Entity\UserRepository")
 * @UniqueEntity(fields={"username"}, message="Username already taken.")
 * @UniqueEntity(fields={"email"}, message="Email address already taken.")
 */
class User extends BaseUser
{
    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    
    /**
     * @Assert\Length(max = 4096)
     */
    protected $plainPassword;

    /**
     * @ORM\Column(name="isActive", type="boolean")
     */
    private $isActive;
    
    /**
     * @ORM\OneToOne(targetEntity="Staff")
     * @ORM\JoinColumn(name="staff_id", referencedColumnName="id", nullable=true)
     */
    private $staffMember;
    
    public function __construct()
    {
        parent::__construct();

        $this->isActive = true;
        $this->setRoles(array("ROLE_UNCONFIRMED"));
    }
    
    /**
     * Get plainPassword
     *
     * @return string
     */
    public function getPlainPassword()
    {
        return $this->plainPassword;
    }

    /**
     * Set password
     *
     * @return User
     */
    public function setPlainPassword($password)
    {
        $this->plainPassword = $password;
        
        return $this;
    }

    /**
     * Set isActive
     *
     * @param boolean $isActive
     *
     * @return User
     */
    public function setIsActive($isActive)
    {
        $this->isActive = $isActive;

        return $this;
    }

    /**
     * Get isActive
     *
     * @return boolean
     */
    public function getIsActive()
    {
        return $this->isActive;
    }

    /**
     * Set staffMember
     *
     * @param \AppBundle\Entity\Staff $staffMember
     *
     * @return User
     */
    public function setStaffMember(\AppBundle\Entity\Staff $staffMember = null)
    {
        $this->staffMember = $staffMember;

        return $this;
    }

    /**
     * Get staffMember
     *
     * @return \AppBundle\Entity\Staff
     */
    public function getStaffMember()
    {
        return $this->staffMember;
    }
}
