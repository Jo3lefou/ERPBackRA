<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * RarPriceMatter
 *
 * @ORM\Table(name="rar_price_matter")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\RarPriceMatterRepository")
 */
class RarPriceMatter
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var float
     *
     * @ORM\Column(name="price", type="float")
     */
    private $price;

    /**
     * @var float
     *
     * @ORM\Column(name="minQuantity", type="float")
     */
    private $minQuantity;


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
     * Set price
     *
     * @param float $price
     *
     * @return RarPriceMatter
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return float
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set minQuantity
     *
     * @param float $minQuantity
     *
     * @return RarPriceMatter
     */
    public function setMinQuantity($minQuantity)
    {
        $this->minQuantity = $minQuantity;

        return $this;
    }

    /**
     * Get minQuantity
     *
     * @return float
     */
    public function getMinQuantity()
    {
        return $this->minQuantity;
    }
}

