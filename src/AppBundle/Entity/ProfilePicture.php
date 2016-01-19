<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 * @ORM\Table()
 */
class ProfilePicture{
   /**
    * @ORM\Id
    * @ORM\Column(type="integer")
    * @ORM\GeneratedValue(strategy="AUTO")
    */
    public $id;

    /**
    * @ORM\Column(type="string", length=255)
    * @Assert\NotBlank
    */
    public $name;

    /**
    * @ORM\Column(type="string", length=255, nullable=true)
    */
    public $path;
    
    /**
     * @Assert\File(maxSize="6000000")
     */
    private $file;

    /**
     * Sets name.
     *
     * @param String $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * Get name.
     *
     * @return UploadedFile
     */
    public function getName()
    {
        return $this->name;
    }
    
    /**
     * Sets file.
     *
     * @param UploadedFile $file
     */
    public function setFile(UploadedFile $file = null)
    {
        $this->file = $file;
    }

    /**
     * Get file.
     *
     * @return UploadedFile
     */
    public function getFile()
    {
        return $this->file;
    }

    public function getAbsolutePath()
    {
       return null === $this->path
           ? null
           : $this->getUploadRootDir().'/'.$this->path;
    }

    public function getWebPath()
    {
       return null === $this->path
           ? null
           : $this->getUploadDir().'/'.$this->path;
    }

    protected function getUploadRootDir()
    {
       // the absolute directory path where uploaded
       // documents should be saved
       return __DIR__.'/../../../../web/uploads/'.$this->getUploadDir();
    }

    protected function getUploadDir()
    {
       // get rid of the __DIR__ so it doesn't screw up
       // when displaying uploaded doc/image in the view.
       return 'uploads/profile';
    }
    
    public function upload()
{
      // the file property can be empty if the field is not required
      if (null === $this->getFile()) {
          return;
      }

      // use the original file name here but you should
      // sanitize it at least to avoid any security issues

      // move takes the target directory and then the
      // target filename to move to
      $this->getFile()->move(
          $this->getUploadRootDir(),
          $this->getFile()->getClientOriginalName()
      );

      // set the path property to the filename where you've saved the file
      $this->path = $this->getFile()->getClientOriginalName();

      // clean up the file property as you won't need it anymore
      $this->file = null;
  }
}
