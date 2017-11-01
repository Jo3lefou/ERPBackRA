<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * RarConfiguration
 *
 * @ORM\Table(name="rar_configuration")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\RarConfigurationRepository")
 */
class RarConfiguration
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
     * @ORM\Column(name="companyName", type="string", length=255)
     */
    private $companyName;

    /**
     * @var string
     *
     * @ORM\Column(name="address", type="string", length=255)
     */
    private $address;

    /**
     * @var string
     *
     * @ORM\Column(name="zipCode", type="string", length=255)
     */
    private $zipCode;

    /**
     * @var string
     *
     * @ORM\Column(name="city", type="string", length=255)
     */
    private $city;

    /**
     * @var string
     *
     * @ORM\Column(name="country", type="string", length=255)
     */
    private $country;

    /**
     * @var string
     *
     * @ORM\Column(name="VATnum", type="string", length=255)
     */
    private $vATnum;

    /**
     * @var string
     *
     * @ORM\Column(name="siretNum", type="string", length=255)
     */
    private $siretNum;

    /**
     * @var string
     *
     * @ORM\Column(name="siegeSocialName", type="string", length=255)
     */
    private $siegeSocialName;

    /**
     * @var string
     *
     * @ORM\Column(name="siegeSocialAddress", type="string", length=255)
     */
    private $siegeSocialAddress;

    /**
     * @var string
     *
     * @ORM\Column(name="siegeSocialZipCode", type="string", length=255)
     */
    private $siegeSocialZipCode;

    /**
     * @var string
     *
     * @ORM\Column(name="siegeSocialCity", type="string", length=255)
     */
    private $siegeSocialCity;

    /**
     * @var string
     *
     * @ORM\Column(name="siegeSocialCountry", type="string", length=255)
     */
    private $siegeSocialCountry;

    /**
     * @var string
     *
     * @ORM\Column(name="orderCondition", type="blob", nullable=true)
     */
    private $orderCondition;

    /**
     * @var string
     *
     * @ORM\Column(name="saleCondition", type="blob", nullable=true)
     */
    private $saleCondition;

    /**
     * @var string
     *
     * @ORM\Column(name="orderConditionEn", type="blob", nullable=true)
     */
    private $orderConditionEn;

    /**
     * @var string
     *
     * @ORM\Column(name="saleConditionEn", type="blob", nullable=true)
     */
    private $saleConditionEn;

    /**
     * @ORM\OneToMany(targetEntity="User", mappedBy="configuration")
     */
    private $users;

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
     * Set companyName
     *
     * @param string $companyName
     *
     * @return RarConfiguration
     */
    public function setCompanyName($companyName)
    {
        $this->companyName = $companyName;

        return $this;
    }

    /**
     * Get companyName
     *
     * @return string
     */
    public function getCompanyName()
    {
        return $this->companyName;
    }

    /**
     * Set address
     *
     * @param string $address
     *
     * @return RarConfiguration
     */
    public function setAddress($address)
    {
        $this->address = $address;

        return $this;
    }

    /**
     * Get address
     *
     * @return string
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Set zipCode
     *
     * @param string $zipCode
     *
     * @return RarConfiguration
     */
    public function setZipCode($zipCode)
    {
        $this->zipCode = $zipCode;

        return $this;
    }

    /**
     * Get zipCode
     *
     * @return string
     */
    public function getZipCode()
    {
        return $this->zipCode;
    }

    /**
     * Set city
     *
     * @param string $city
     *
     * @return RarConfiguration
     */
    public function setCity($city)
    {
        $this->city = $city;

        return $this;
    }

    /**
     * Get city
     *
     * @return string
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * Set country
     *
     * @param string $country
     *
     * @return RarConfiguration
     */
    public function setCountry($country)
    {
        $this->country = $country;

        return $this;
    }

    /**
     * Get country
     *
     * @return string
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * Set vATnum
     *
     * @param string $vATnum
     *
     * @return RarConfiguration
     */
    public function setVATnum($vATnum)
    {
        $this->vATnum = $vATnum;

        return $this;
    }

    /**
     * Get vATnum
     *
     * @return string
     */
    public function getVATnum()
    {
        return $this->vATnum;
    }

    /**
     * Set siretNum
     *
     * @param string $siretNum
     *
     * @return RarConfiguration
     */
    public function setSiretNum($siretNum)
    {
        $this->siretNum = $siretNum;

        return $this;
    }

    /**
     * Get siretNum
     *
     * @return string
     */
    public function getSiretNum()
    {
        return $this->siretNum;
    }

    /**
     * Set siegeSocialName
     *
     * @param string $siegeSocialName
     *
     * @return RarConfiguration
     */
    public function setSiegeSocialName($siegeSocialName)
    {
        $this->siegeSocialName = $siegeSocialName;

        return $this;
    }

    /**
     * Get siegeSocialName
     *
     * @return string
     */
    public function getSiegeSocialName()
    {
        return $this->siegeSocialName;
    }

    /**
     * Set siegeSocialAddress
     *
     * @param string $siegeSocialAddress
     *
     * @return RarConfiguration
     */
    public function setSiegeSocialAddress($siegeSocialAddress)
    {
        $this->siegeSocialAddress = $siegeSocialAddress;

        return $this;
    }

    /**
     * Get siegeSocialAddress
     *
     * @return string
     */
    public function getSiegeSocialAddress()
    {
        return $this->siegeSocialAddress;
    }

    /**
     * Set siegeSocialZipCode
     *
     * @param string $siegeSocialZipCode
     *
     * @return RarConfiguration
     */
    public function setSiegeSocialZipCode($siegeSocialZipCode)
    {
        $this->siegeSocialZipCode = $siegeSocialZipCode;

        return $this;
    }

    /**
     * Get siegeSocialZipCode
     *
     * @return string
     */
    public function getSiegeSocialZipCode()
    {
        return $this->siegeSocialZipCode;
    }

    /**
     * Set siegeSocialCity
     *
     * @param string $siegeSocialCity
     *
     * @return RarConfiguration
     */
    public function setSiegeSocialCity($siegeSocialCity)
    {
        $this->siegeSocialCity = $siegeSocialCity;

        return $this;
    }

    /**
     * Get siegeSocialCity
     *
     * @return string
     */
    public function getSiegeSocialCity()
    {
        return $this->siegeSocialCity;
    }

    /**
     * Set siegeSocialCountry
     *
     * @param string $siegeSocialCountry
     *
     * @return RarConfiguration
     */
    public function setSiegeSocialCountry($siegeSocialCountry)
    {
        $this->siegeSocialCountry = $siegeSocialCountry;

        return $this;
    }

    /**
     * Get siegeSocialCountry
     *
     * @return string
     */
    public function getSiegeSocialCountry()
    {
        return $this->siegeSocialCountry;
    }

    /**
     * Set orderCondition
     *
     * @param string $orderCondition
     *
     * @return RarConfiguration
     */
    public function setOrderCondition($orderCondition)
    {
        $this->orderCondition = $orderCondition;

        return $this;
    }

    /**
     * Get orderCondition
     *
     * @return string
     */
    public function getOrderCondition()
    {
        if($this->orderCondition != ''){
            return stream_get_contents($this->orderCondition);
        }
        return $this->orderCondition;
    }

    /**
     * Set saleCondition
     *
     * @param string $saleCondition
     *
     * @return RarConfiguration
     */
    public function setSaleCondition($saleCondition)
    {
        $this->saleCondition = $saleCondition;

        return $this;
    }

    /**
     * Get saleCondition
     *
     * @return string
     */
    public function getSaleCondition()
    {
        if($this->saleCondition != ''){
            return stream_get_contents($this->saleCondition);
        }
        return $this->saleCondition;
    }

    // English

    /**
     * Set orderConditionEn
     *
     * @param string $orderConditionEn
     *
     * @return RarConfiguration
     */
    public function setOrderConditionEn($orderConditionEn)
    {
        $this->orderConditionEn = $orderConditionEn;

        return $this;
    }

    /**
     * Get orderConditionEn
     *
     * @return string
     */
    public function getOrderConditionEn()
    {
        if($this->orderConditionEn != ''){
            return stream_get_contents($this->orderConditionEn);
        }
        return $this->orderConditionEn;
    }

    /**
     * Set saleConditionEn
     *
     * @param string $saleConditionEn
     *
     * @return RarConfiguration
     */
    public function setSaleConditionEn($saleConditionEn)
    {
        $this->saleConditionEn = $saleConditionEn;

        return $this;
    }

    /**
     * Get saleConditionEn
     *
     * @return string
     */
    public function getSaleConditionEn()
    {
        if($this->saleConditionEn != ''){
            return stream_get_contents($this->saleConditionEn);
        }
        return $this->saleConditionEn;
    }
}

