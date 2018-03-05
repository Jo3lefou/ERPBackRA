<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * RarPublicForm
 *
 * @ORM\Table(name="rar_public_form")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\RarPublicFormRepository")
 */
class RarPublicForm
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
     * @ORM\Column(name="q1", type="string", length=255)
     */
    private $q1;

    /**
     * @var string
     *
     * @ORM\Column(name="q", type="string", length=255)
     */
    private $q2;

    /**
     * @var string
     *
     * @ORM\Column(name="q3", type="string", length=255)
     */
    private $q3;

    /**
     * @var string
     *
     * @ORM\Column(name="q4", type="string", length=255)
     */
    private $q4;

    /**
     * @var string
     *
     * @ORM\Column(name="q5", type="string", length=255)
     */
    private $q5;

    /**
     * @var string
     *
     * @ORM\Column(name="q6", type="string", length=255)
     */
    private $q6;

    /**
     * @var string
     *
     * @ORM\Column(name="q7", type="string", length=255)
     */
    private $q7;

    /**
     * @var string
     *
     * @ORM\Column(name="q8", type="string", length=255)
     */
    private $q8;

    /**
     * @var string
     *
     * @ORM\Column(name="q9", type="string", length=255)
     */
    private $q9;

    /**
     * @var string
     *
     * @ORM\Column(name="q10", type="string", length=255)
     */
    private $q10;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="creationDate", type="datetime")
     */
    private $creationDate;


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
     * Set q1
     *
     * @param string $q1
     *
     * @return RarPublicForm
     */
    public function setQ1($q1)
    {
        $this->q1 = $q1;

        return $this;
    }

    /**
     * Get q1
     *
     * @return string
     */
    public function getQ1()
    {
        return $this->q1;
    }

    /**
     * Set q
     *
     * @param string $q
     *
     * @return RarPublicForm
     */
    public function setQ2($q)
    {
        $this->q2 = $q2;

        return $this;
    }

    /**
     * Get q
     *
     * @return string
     */
    public function getQ2()
    {
        return $this->q2;
    }

    /**
     * Set q3
     *
     * @param string $q3
     *
     * @return RarPublicForm
     */
    public function setQ3($q3)
    {
        $this->q3 = $q3;

        return $this;
    }

    /**
     * Get q3
     *
     * @return string
     */
    public function getQ3()
    {
        return $this->q3;
    }

    /**
     * Set q4
     *
     * @param string $q4
     *
     * @return RarPublicForm
     */
    public function setQ4($q4)
    {
        $this->q4 = $q4;

        return $this;
    }

    /**
     * Get q4
     *
     * @return string
     */
    public function getQ4()
    {
        return $this->q4;
    }

    /**
     * Set q5
     *
     * @param string $q5
     *
     * @return RarPublicForm
     */
    public function setQ5($q5)
    {
        $this->q5 = $q5;

        return $this;
    }

    /**
     * Get q5
     *
     * @return string
     */
    public function getQ5()
    {
        return $this->q5;
    }

    /**
     * Set q6
     *
     * @param string $q6
     *
     * @return RarPublicForm
     */
    public function setQ6($q6)
    {
        $this->q6 = $q6;

        return $this;
    }

    /**
     * Get q6
     *
     * @return string
     */
    public function getQ6()
    {
        return $this->q6;
    }

    /**
     * Set q7
     *
     * @param string $q7
     *
     * @return RarPublicForm
     */
    public function setQ7($q7)
    {
        $this->q7 = $q7;

        return $this;
    }

    /**
     * Get q7
     *
     * @return string
     */
    public function getQ7()
    {
        return $this->q7;
    }

    /**
     * Set q8
     *
     * @param string $q8
     *
     * @return RarPublicForm
     */
    public function setQ8($q8)
    {
        $this->q8 = $q8;

        return $this;
    }

    /**
     * Get q8
     *
     * @return string
     */
    public function getQ8()
    {
        return $this->q8;
    }

    /**
     * Set q9
     *
     * @param string $q9
     *
     * @return RarPublicForm
     */
    public function setQ9($q9)
    {
        $this->q9 = $q9;

        return $this;
    }

    /**
     * Get q9
     *
     * @return string
     */
    public function getQ9()
    {
        return $this->q9;
    }

    /**
     * Set q10
     *
     * @param string $q10
     *
     * @return RarPublicForm
     */
    public function setQ10($q10)
    {
        $this->q10 = $q10;

        return $this;
    }

    /**
     * Get q10
     *
     * @return string
     */
    public function getQ10()
    {
        return $this->q10;
    }

    /**
     * Set creationDate
     *
     * @param \DateTime $creationDate
     *
     * @return RarPublicForm
     */
    public function setCreationDate($creationDate)
    {
        $this->creationDate = $creationDate;

        return $this;
    }

    /**
     * Get creationDate
     *
     * @return \DateTime
     */
    public function getCreationDate()
    {
        return $this->creationDate;
    }
}

