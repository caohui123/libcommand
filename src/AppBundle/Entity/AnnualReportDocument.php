<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use AppBundle\Entity\Document;

/**
 * AnnualReportDocument
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class AnnualReportDocument extends Document
{
    /**
     * @var string
     *
     * @ORM\Column(name="category", type="string", length=75)
     */
    private $category;
    
    /**
     * Set category
     *
     * @param String $category
     *
     * @return AnnualReport
     */
    public function setCategory($category)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Get category
     *
     * @return String
     */
    public function getCategory()
    {
        return $this->category;
    }
}

