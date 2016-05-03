<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use AppBundle\Entity\Instruction;

/**
 * GroupInstruction
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class GroupInstruction extends Instruction
{
    /**
     * @var string
     *
     * @ORM\Column(name="instructor", type="string", length=70)
     */
    private $instructor;

    /**
     * @var integer
     *
     * @ORM\Column(name="attendance", type="integer")
     */
    private $attendance;

    /**
     * @var string
     *
     * @ORM\Column(name="level", type="string", length=50)
     */
    private $level;

    /**
     * Set instructor
     *
     * @param string $instructor
     *
     * @return GroupInstruction
     */
    public function setInstructor($instructor)
    {
        $this->instructor = $instructor;

        return $this;
    }

    /**
     * Get instructor
     *
     * @return string
     */
    public function getInstructor()
    {
        return $this->instructor;
    }

    /**
     * Set attendance
     *
     * @param integer $attendance
     *
     * @return GroupInstruction
     */
    public function setAttendance($attendance)
    {
        $this->attendance = $attendance;

        return $this;
    }

    /**
     * Get attendance
     *
     * @return integer
     */
    public function getAttendance()
    {
        return $this->attendance;
    }

    /**
     * Set level
     *
     * @param string $level
     *
     * @return GroupInstruction
     */
    public function setLevel($level)
    {
        $this->level = $level;

        return $this;
    }

    /**
     * Get level
     *
     * @return string
     */
    public function getLevel()
    {
        return $this->level;
    }
}

