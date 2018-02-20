<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * RarLocation
 *
 * @ORM\Table(name="rar_location")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\RarLocationRepository")
 */
class RarLocation
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
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="secondName", type="string", length=255)
     */
    private $secondName;

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
     * @ORM\Column(name="accessCode", type="string", length=255)
     */
    private $accessCode;

    /**
     * @var string
     *
     * @ORM\Column(name="information", type="blob", nullable=true)
     */
    private $information;

    /**
     * @var string
     *
     * @ORM\Column(name="urlPlace", type="string", length=255)
     */
    private $urlPlace;

    /**
     * @var string
     *
     * @ORM\Column(name="url2", type="string", length=255)
     */
    private $url2;


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
     * Set name
     *
     * @param string $name
     *
     * @return RarLocation
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
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
     * Set secondName
     *
     * @param string $secondName
     *
     * @return RarLocation
     */
    public function setSecondName($secondName)
    {
        $this->secondName = $secondName;

        return $this;
    }

    /**
     * Get secondName
     *
     * @return string
     */
    public function getSecondName()
    {
        return $this->secondName;
    }

    /**
     * Set address
     *
     * @param string $address
     *
     * @return RarLocation
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
     * @return RarLocation
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
     * @return RarLocation
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
     * @return RarLocation
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
     * Set accessCode
     *
     * @param string $accessCode
     *
     * @return RarLocation
     */
    public function setAccessCode($accessCode)
    {
        $this->accessCode = $accessCode;

        return $this;
    }

    /**
     * Get accessCode
     *
     * @return string
     */
    public function getAccessCode()
    {
        return $this->accessCode;
    }

    /**
     * Set information
     *
     * @param string $information
     *
     * @return RarLocation
     */
    public function setInformation($information)
    {
        $this->information = $information;

        return $this;
    }

    /**
     * Get information
     *
     * @return string
     */
    public function getInformation()
    {
        return $this->information;
    }

    /**
     * Set urlPlace
     *
     * @param string $urlPlace
     *
     * @return RarLocation
     */
    public function setUrlPlace($urlPlace)
    {
        $this->urlPlace = $urlPlace;

        return $this;
    }

    /**
     * Get urlPlace
     *
     * @return string
     */
    public function getUrlPlace()
    {
        return $this->urlPlace;
    }

    /**
     * Set url2
     *
     * @param string $url2
     *
     * @return RarLocation
     */
    public function setUrl2($url2)
    {
        $this->url2 = $url2;

        return $this;
    }

    /**
     * Get url2
     *
     * @return string
     */
    public function getUrl2()
    {
        return $this->url2;
    }
}

