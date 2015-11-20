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
 * @UniqueEntity(fields={"username", "email"}, message="Username or Email address already taken.")
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
     * @Assert\NotBlank()
     * @Assert\Length(max = 4096)
     */
    protected $plainPassword;

    /**
     * @ORM\Column(name="isActive", type="boolean")
     */
    private $isActive;
    
    /**
     * @ORM\ManyToOne(targetEntity="StaffFunctionalArea", cascade={"all"}, fetch="LAZY")
     */
    private $staffFunctionalArea;
    
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
}

/**
 * Why the 4096 Password Limit?
 * Notice that the plainPassword field has a max length of 4096 characters. 
 * For security purposes (CVE-2013-5750), Symfony limits the plain password length to 4096 characters when encoding it. 
 * Adding this constraint makes sure that your form will give a validation error if anyone tries a super-long password.
 * 
 * You'll need to add this constraint anywhere in your application where your user submits a plaintext password (e.g. change password form). 
 * The only place where you don't need to worry about this is your login form, 
 * since Symfony's Security component handles this for you.
 */
