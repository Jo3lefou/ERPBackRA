<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * RarSize
 *
 * @ORM\Table(name="rar_size")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\RarSizeRepository")
 */
class RarSize
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
     * @var string
     *
     * @ORM\Column(name="name_size", type="string", length=255)
     */
    private $nameSize;

    /**
     * @var string
     *
     * @ORM\Column(name="code_size", type="string", length=255)
     */
    private $codeSize;

    /**
     * @var float
     *
     * @ORM\Column(name="supPriceHT", type="float")
     */
    private $supPriceHT;

    /**
     * @var float
     *
     * @ORM\Column(name="supPriceShop", type="float")
     */
    private $supPriceShop;

    /**
     * @var bool
     *
     * @ORM\Column(name="is_active", type="boolean")
     */
    private $isActive;

    /**
     * @ORM\ManyToOne(targetEntity="RarModel", inversedBy="sizes", cascade="persist")
     * @ORM\JoinColumn(name="model_id", referencedColumnName="id")
     */
    protected $model;

    public function getCodeSize()
    {
        return $this->codeSize;
    }

    public function setCodeSize($codeSize)
    {
        $this->codeSize = $codeSize;

        return $this;
    }

    public function getNameSize()
    {
        return $this->nameSize;
    }

    public function setNameSize($nameSize)
    {
        $this->nameSize = $nameSize;

        return $this;
    }
    
    public function getSupPriceHT()
    {
        return $this->supPriceHT;
    }

    public function setSupPriceHT($supPriceHT)
    {
        $this->supPriceHT = $supPriceHT;

        return $this;
    }

    public function getSupPriceShop()
    {
        return $this->supPriceShop;
    }

    public function setSupPriceShop($supPriceShop)
    {
        $this->supPriceShop = $supPriceShop;

        return $this;
    }

    public function getIsActive()
    {
        return $this->isActive;
    }

    public function setIsActive($isActive)
    {
        $this->isActive = $isActive;

        return $this;
    }
    public function setModel(RarModel $model = null) {
        $this->model = $model;
    }
}