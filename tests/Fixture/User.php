<?php

namespace AshleyDawson\DoctrineVirtualColumns\Tests\Fixture;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class User
 *
 * @package AshleyDawson\DoctrineVirtualColumns\Tests\Fixture
 *
 * @ORM\Entity
 */
class User
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string")
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", unique=true)
     */
    private $email;

    /**
     * @var Review
     *
     * @ORM\ManyToMany(targetEntity="Department")
     */
    private $departments;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->departments = new ArrayCollection();
    }

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
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
     * Set name
     *
     * @param string $name
     * @return User
     */
    public function setName($name)
    {
        $this->name = $name;
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

    /**
     * Set email
     *
     * @param string $email
     * @return User
     */
    public function setEmail($email)
    {
        $this->email = $email;
        return $this;
    }

    /**
     * Add department
     *
     * @param Department $department
     * @return $this
     */
    public function addDepartment(Department $department)
    {
        $this->departments->add($department);
        return $this;
    }

    /**
     * Remove department
     *
     * @param Department $department
     * @return $this
     */
    public function removeDepartment(Department $department)
    {
        $this->departments->remove($department);
        return $this;
    }

    /**
     * Get departments
     *
     * @return User[]
     */
    public function getDepartments()
    {
        return $this->departments;
    }
}