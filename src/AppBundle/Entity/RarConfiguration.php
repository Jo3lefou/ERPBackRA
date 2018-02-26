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
     * @var string
     *
     * @ORM\Column(name="emailRdvOne", type="blob", nullable=true)
     */
    private $emailRdvOne;

    /**
     * @var string
     *
     * @ORM\Column(name="emailRdvTwo", type="blob", nullable=true)
     */
    private $emailRdvTwo;

    /**
     * @var string
     *
     * @ORM\Column(name="emailRdvConf", type="blob", nullable=true)
     */
    private $emailRdvConf;

    /**
     * @var string
     *
     * @ORM\Column(name="emailRdvCancelation", type="blob", nullable=true)
     */
    private $emailRdvCancelation;

    /**
     * @var string
     *
     * @ORM\Column(name="emailRdvEdition", type="blob", nullable=true)
     */
    private $emailRdvEdition;

    /**
     * @var string
     *
     * @ORM\Column(name="emailRdvOneEn", type="blob", nullable=true)
     */
    private $emailRdvOneEn;

    /**
     * @var string
     *
     * @ORM\Column(name="emailRdvTwoEn", type="blob", nullable=true)
     */
    private $emailRdvTwoEn;

    /**
     * @var string
     *
     * @ORM\Column(name="emailRdvConfEn", type="blob", nullable=true)
     */
    private $emailRdvConfEn;

    /**
     * @var string
     *
     * @ORM\Column(name="emailRdvCancelationEn", type="blob", nullable=true)
     */
    private $emailRdvCancelationEn;

    /**
     * @var string
     *
     * @ORM\Column(name="emailRdvEditionEn", type="blob", nullable=true)
     */
    private $emailRdvEditionEn;

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

    /**
     * Set emailRdvOne
     *
     * @param string $emailRdvOne
     *
     * @return RarConfiguration
     */
    public function setEmailRdvOne($emailRdvOne)
    {
        $this->emailRdvOne = $emailRdvOne;

        return $this;
    }

    /**
     * Get emailRdvOne
     *
     * @return string
     */
    public function getEmailRdvOne()
    {
        if($this->emailRdvOne != ''){
            return stream_get_contents($this->emailRdvOne);
        }
        return $this->emailRdvOne;
    }

    /**
     * Set emailRdvTwo
     *
     * @param string $emailRdvTwo
     *
     * @return RarConfiguration
     */
    public function setEmailRdvTwo($emailRdvTwo)
    {
        $this->emailRdvTwo = $emailRdvTwo;

        return $this;
    }

    /**
     * Get emailRdvTwo
     *
     * @return string
     */
    public function getEmailRdvTwo()
    {
        if($this->emailRdvTwo != ''){
            return stream_get_contents($this->emailRdvTwo);
        }
        return $this->emailRdvTwo;
    }

    /**
     * Set emailRdvConf
     *
     * @param string $emailRdvConf
     *
     * @return RarConfiguration
     */
    public function setEmailRdvConf($emailRdvConf)
    {
        $this->emailRdvConf = $emailRdvConf;

        return $this;
    }

    /**
     * Get emailRdvConf
     *
     * @return string
     */
    public function getEmailRdvConf()
    {
        if($this->emailRdvConf != ''){
            return stream_get_contents($this->emailRdvConf);
        }
        return $this->emailRdvConf;
    }

    /**
     * Set emailRdvCancelation
     *
     * @param string $emailRdvCancelation
     *
     * @return RarConfiguration
     */
    public function setEmailRdvCancelation($emailRdvCancelation)
    {
        $this->emailRdvCancelation = $emailRdvCancelation;

        return $this;
    }

    /**
     * Get emailRdvCancelation
     *
     * @return string
     */
    public function getEmailRdvCancelation()
    {
        if($this->emailRdvCancelation != ''){
            return stream_get_contents($this->emailRdvCancelation);
        }
        return $this->emailRdvCancelation;
    }

    /**
     * Set emailRdvEdition
     *
     * @param string $emailRdvEdition
     *
     * @return RarConfiguration
     */
    public function setEmailRdvEdition($emailRdvEdition)
    {
        $this->emailRdvEdition = $emailRdvEdition;

        return $this;
    }

    /**
     * Get emailRdvEdition
     *
     * @return string
     */
    public function getEmailRdvEdition()
    {
        if($this->emailRdvEdition != ''){
            return stream_get_contents($this->emailRdvEdition);
        }
        return $this->emailRdvEdition;
    }

    /**
     * Set emailRdvOneEn
     *
     * @param string $emailRdvOneEn
     *
     * @return RarConfiguration
     */
    public function setEmailRdvOneEn($emailRdvOneEn)
    {
        $this->emailRdvOneEn = $emailRdvOneEn;

        return $this;
    }

    /**
     * Get emailRdvOneEn
     *
     * @return string
     */
    public function getEmailRdvOneEn()
    {
        if($this->emailRdvOneEn != ''){
            return stream_get_contents($this->emailRdvOneEn);
        }
        return $this->emailRdvOneEn;
    }

    /**
     * Set emailRdvTwoEn
     *
     * @param string $emailRdvTwoEn
     *
     * @return RarConfiguration
     */
    public function setEmailRdvTwoEn($emailRdvTwoEn)
    {
        $this->emailRdvTwoEn = $emailRdvTwoEn;

        return $this;
    }

    /**
     * Get emailRdvTwoEn
     *
     * @return string
     */
    public function getEmailRdvTwoEn()
    {
        if($this->emailRdvTwoEn != ''){
            return stream_get_contents($this->emailRdvTwoEn);
        }
        return $this->emailRdvTwoEn;
    }

    /**
     * Set emailRdvConfEn
     *
     * @param string $emailRdvConfEn
     *
     * @return RarConfiguration
     */
    public function setEmailRdvConfEn($emailRdvConfEn)
    {
        $this->emailRdvConfEn = $emailRdvConfEn;

        return $this;
    }

    /**
     * Get emailRdvConfEn
     *
     * @return string
     */
    public function getEmailRdvConfEn()
    {
        if($this->emailRdvConfEn != ''){
            return stream_get_contents($this->emailRdvConfEn);
        }
        return $this->emailRdvConfEn;
    }

    /**
     * Set emailRdvCancelationEn
     *
     * @param string $emailRdvCancelationEn
     *
     * @return RarConfiguration
     */
    public function setEmailRdvCancelationEn($emailRdvCancelationEn)
    {
        $this->emailRdvCancelationEn = $emailRdvCancelationEn;

        return $this;
    }

    /**
     * Get emailRdvCancelationEn
     *
     * @return string
     */
    public function getEmailRdvCancelationEn()
    {
        if($this->emailRdvCancelationEn != ''){
            return stream_get_contents($this->emailRdvCancelationEn);
        }
        return $this->emailRdvCancelationEn;
    }

    /**
     * Set emailRdvEditionEn
     *
     * @param string $emailRdvEditionEn
     *
     * @return RarConfiguration
     */
    public function setEmailRdvEditionEn($emailRdvEditionEn)
    {
        $this->emailRdvEditionEn = $emailRdvEditionEn;

        return $this;
    }

    /**
     * Get emailRdvEditionEn
     *
     * @return string
     */
    public function getEmailRdvEditionEn()
    {
        if($this->emailRdvEditionEn != ''){
            return stream_get_contents($this->emailRdvEditionEn);
        }
        return $this->emailRdvEditionEn;
    }







}

