<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * MonthlyStatsGovernmentDocuments
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class MonthlyStatsGovernmentDocuments
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
     * @var integer
     *
     * @ORM\Column(name="itemsAddedGross", type="integer")
     */
    private $itemsAddedGross;

    /**
     * @var integer
     *
     * @ORM\Column(name="itemsWithdrawn", type="integer")
     */
    private $itemsWithdrawn;

    /**
     * @var integer
     *
     * @ORM\Column(name="itemsAddedNet", type="integer")
     */
    private $itemsAddedNet;

    /**
     * @var integer
     *
     * @ORM\Column(name="paper", type="integer")
     */
    private $paper;

    /**
     * @var integer
     *
     * @ORM\Column(name="electronicOpacUrls", type="integer")
     */
    private $electronicOpacUrls;

    /**
     * @var integer
     *
     * @ORM\Column(name="weeklyRecordsAdded", type="integer")
     */
    private $weeklyRecordsAdded;

    /**
     * @var integer
     *
     * @ORM\Column(name="monthlyRecordsAdded", type="integer")
     */
    private $monthlyRecordsAdded;

    /**
     * @var integer
     *
     * @ORM\Column(name="monthlyNonOverlays", type="integer")
     */
    private $monthlyNonOverlays;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="month", type="date")
     */
    private $month;


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
     * Set itemsAddedGross
     *
     * @param integer $itemsAddedGross
     *
     * @return MonthlyStatsGovernmentDocuments
     */
    public function setItemsAddedGross($itemsAddedGross)
    {
        $this->itemsAddedGross = $itemsAddedGross;

        return $this;
    }

    /**
     * Get itemsAddedGross
     *
     * @return integer
     */
    public function getItemsAddedGross()
    {
        return $this->itemsAddedGross;
    }

    /**
     * Set itemsWithdrawn
     *
     * @param integer $itemsWithdrawn
     *
     * @return MonthlyStatsGovernmentDocuments
     */
    public function setItemsWithdrawn($itemsWithdrawn)
    {
        $this->itemsWithdrawn = $itemsWithdrawn;

        return $this;
    }

    /**
     * Get itemsWithdrawn
     *
     * @return integer
     */
    public function getItemsWithdrawn()
    {
        return $this->itemsWithdrawn;
    }

    /**
     * Set itemsAddedNet
     *
     * @param integer $itemsAddedNet
     *
     * @return MonthlyStatsGovernmentDocuments
     */
    public function setItemsAddedNet($itemsAddedNet)
    {
        $this->itemsAddedNet = $itemsAddedNet;

        return $this;
    }

    /**
     * Get itemsAddedNet
     *
     * @return integer
     */
    public function getItemsAddedNet()
    {
        return $this->itemsAddedNet;
    }

    /**
     * Set paper
     *
     * @param integer $paper
     *
     * @return MonthlyStatsGovernmentDocuments
     */
    public function setPaper($paper)
    {
        $this->paper = $paper;

        return $this;
    }

    /**
     * Get paper
     *
     * @return integer
     */
    public function getPaper()
    {
        return $this->paper;
    }

    /**
     * Set electronicOpacUrls
     *
     * @param integer $electronicOpacUrls
     *
     * @return MonthlyStatsGovernmentDocuments
     */
    public function setElectronicOpacUrls($electronicOpacUrls)
    {
        $this->electronicOpacUrls = $electronicOpacUrls;

        return $this;
    }

    /**
     * Get electronicOpacUrls
     *
     * @return integer
     */
    public function getElectronicOpacUrls()
    {
        return $this->electronicOpacUrls;
    }

    /**
     * Set weeklyRecordsAdded
     *
     * @param integer $weeklyRecordsAdded
     *
     * @return MonthlyStatsGovernmentDocuments
     */
    public function setWeeklyRecordsAdded($weeklyRecordsAdded)
    {
        $this->weeklyRecordsAdded = $weeklyRecordsAdded;

        return $this;
    }

    /**
     * Get weeklyRecordsAdded
     *
     * @return integer
     */
    public function getWeeklyRecordsAdded()
    {
        return $this->weeklyRecordsAdded;
    }

    /**
     * Set monthlyRecordsAdded
     *
     * @param integer $monthlyRecordsAdded
     *
     * @return MonthlyStatsGovernmentDocuments
     */
    public function setMonthlyRecordsAdded($monthlyRecordsAdded)
    {
        $this->monthlyRecordsAdded = $monthlyRecordsAdded;

        return $this;
    }

    /**
     * Get monthlyRecordsAdded
     *
     * @return integer
     */
    public function getMonthlyRecordsAdded()
    {
        return $this->monthlyRecordsAdded;
    }

    /**
     * Set monthlyNonOverlays
     *
     * @param integer $monthlyNonOverlays
     *
     * @return MonthlyStatsGovernmentDocuments
     */
    public function setMonthlyNonOverlays($monthlyNonOverlays)
    {
        $this->monthlyNonOverlays = $monthlyNonOverlays;

        return $this;
    }

    /**
     * Get monthlyNonOverlays
     *
     * @return integer
     */
    public function getMonthlyNonOverlays()
    {
        return $this->monthlyNonOverlays;
    }

    /**
     * Set month
     *
     * @param \DateTime $month
     *
     * @return MonthlyStatsGovernmentDocuments
     */
    public function setMonth($month)
    {
        $this->month = $month;

        return $this;
    }

    /**
     * Get month
     *
     * @return \DateTime
     */
    public function getMonth()
    {
        return $this->month;
    }
}

