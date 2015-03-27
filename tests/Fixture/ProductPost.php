<?php

namespace AshleyDawson\DoctrineVirtualColumns\Tests\Fixture;

use Doctrine\ORM\Mapping as ORM;
use AshleyDawson\DoctrineVirtualColumns\Mapping\Annotation\VirtualColumn;

/**
 * Class ProductPost
 *
 * @package AshleyDawson\DoctrineVirtualColumns\Tests\Fixture
 *
 * @ORM\Entity
 */
class ProductPost extends AbstractPost
{
    /**
     * @var int
     *
     * @ORM\Column(name="name", type="string")
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="price", type="decimal", precision=10, scale=2)
     */
    private $price;

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
     * Get price
     *
     * @return string
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set price
     *
     * @param string $price
     * @return ProductPost
     */
    public function setPrice($price)
    {
        $this->price = $price;
        return $this;
    }
}