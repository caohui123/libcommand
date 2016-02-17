<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * MediaReserve
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class MaterialReserve
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
     * @ORM\Column(name="semester", type="string", length=6)
     */
    private $semester;

    /**
     * @var integer
     *
     * @ORM\Column(name="year", type="integer")
     */
    private $year;

    /**
     * @var string
     *
     * @ORM\Column(name="course", type="string", length=15)
     */
    private $course;

    /**
     * @var integer
     *
     * @ORM\Column(name="enrollment", type="integer")
     */
    private $enrollment;

    /**
     * @var string
     *
     * @ORM\Column(name="instructor", type="string", length=50)
     */
    private $instructor;

    /**
     * @var string
     *
     * @ORM\Column(name="phone", type="string", length=15)
     */
    private $phone;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=50)
     */
    private $email;


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
     * Set semester
     *
     * @param string $semester
     *
     * @return MediaReserve
     */
    public function setSemester($semester)
    {
        $this->semester = $semester;

        return $this;
    }

    /**
     * Get semester
     *
     * @return string
     */
    public function getSemester()
    {
        return $this->semester;
    }

    /**
     * Set year
     *
     * @param integer $year
     *
     * @return MediaReserve
     */
    public function setYear($year)
    {
        $this->year = $year;

        return $this;
    }

    /**
     * Get year
     *
     * @return integer
     */
    public function getYear()
    {
        return $this->year;
    }

    /**
     * Set course
     *
     * @param string $course
     *
     * @return MediaReserve
     */
    public function setCourse($course)
    {
        $this->course = $course;

        return $this;
    }

    /**
     * Get course
     *
     * @return string
     */
    public function getCourse()
    {
        return $this->course;
    }

    /**
     * Set enrollment
     *
     * @param integer $enrollment
     *
     * @return MediaReserve
     */
    public function setEnrollment($enrollment)
    {
        $this->enrollment = $enrollment;

        return $this;
    }

    /**
     * Get enrollment
     *
     * @return integer
     */
    public function getEnrollment()
    {
        return $this->enrollment;
    }

    /**
     * Set instructor
     *
     * @param string $instructor
     *
     * @return MediaReserve
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
     * Set phone
     *
     * @param string $phone
     *
     * @return MediaReserve
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
     * Set email
     *
     * @param string $email
     *
     * @return MediaReserve
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }
}

