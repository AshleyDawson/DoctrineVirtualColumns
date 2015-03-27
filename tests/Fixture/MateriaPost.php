<?php

namespace AshleyDawson\DoctrineVirtualColumns\Tests\Fixture;

use Doctrine\ORM\Mapping as ORM;
use AshleyDawson\DoctrineVirtualColumns\Mapping\Annotation\VirtualColumn;

/**
 * Class MateriaPost
 *
 * @package AshleyDawson\DoctrineVirtualColumns\Tests\Fixture
 *
 * @ORM\Entity
 */
class MateriaPost extends AbstractPost
{
    /**
     * @var int
     *
     * @ORM\Column(name="name", type="string")
     */
    private $name;

    /**
     * @var int
     *
     * @ORM\Column(name="ability_points", type="integer")
     */
    private $abilityPoints;

    /**
     * @var MateriaType
     *
     * @ORM\ManyToOne(targetEntity="MateriaType")
     */
    private $type;

    /**
     * Get name
     *
     * @return int
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set name
     *
     * @param int $name
     * @return ProductPost
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * Get abilityPoints
     *
     * @return int
     */
    public function getAbilityPoints()
    {
        return $this->abilityPoints;
    }

    /**
     * Set abilityPoints
     *
     * @param int $abilityPoints
     * @return MateriaPost
     */
    public function setAbilityPoints($abilityPoints)
    {
        $this->abilityPoints = $abilityPoints;
        return $this;
    }

    /**
     * Get type
     *
     * @return MateriaType
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set type
     *
     * @param MateriaType $type
     * @return MateriaPost
     */
    public function setType(MateriaType $type)
    {
        $this->type = $type;
        return $this;
    }
}