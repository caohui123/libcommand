<?php
/**
 * This entity allows documents (images, for example) to be managed throughout
 * the lifecycle of other entities to which it belongs (i.e. a Photo Document 
 * belongs to a Staff entity)
 * 
 * Cookbook entry: http://symfony.com/doc/current/cookbook/doctrine/file_uploads.html
 */
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use AppBundle\Entity\Document;

/**
 * Document
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Image extends Document
{
    
}

