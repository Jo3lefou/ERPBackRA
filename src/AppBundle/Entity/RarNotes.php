<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * RarNotes
 *
 * @ORM\Table(name="rar_notes")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\RarNotesRepository")
 */
class RarNotes
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
     * @var \DateTime
     *
     * @ORM\Column(name="dateCreation", type="datetime")
     */
    private $dateCreation;

    /**
     * @var string
     *
     * @ORM\Column(name="note", type="blob")
     */
    private $note;

    /**
     * @ORM\ManyToOne(targetEntity="RarCustomer", inversedBy="notes",cascade={"persist"}, fetch="EAGER")
     * @ORM\JoinColumn(name="customer_id", referencedColumnName="id")
     */
    protected $customer;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="notes",cascade={"persist"}, fetch="EAGER")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    protected $user;


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
     * Set dateCreation
     *
     * @param \DateTime $dateCreation
     *
     * @return RarNotes
     */
    public function setDateCreation($dateCreation)
    {
        $this->dateCreation = $dateCreation;

        return $this;
    }

    /**
     * Get dateCreation
     *
     * @return \DateTime
     */
    public function getDateCreation()
    {
        return $this->dateCreation;
    }

    /**
     * Set note
     *
     * @param string $note
     *
     * @return RarNotes
     */
    public function setNote($note)
    {
        $this->note = $note;

        return $this;
    }

    /**
     * Get note
     *
     * @return string
     */
    public function getNote()
    {
        return $this->note;
    }

    /**
     * Set customer
     *
     * @param \AppBundle\Entity\RarCustomer $customer
     *
     * @return RarNotes
     */
    public function setCustomer(\AppBundle\Entity\RarCustomer $customer = null)
    {
        $this->customer = $customer;

        return $this;
    }

    /**
     * Get customer
     *
     * @return \AppBundle\Entity\RarCustomer
     */
    public function getCustomer()
    {
        return $this->customer;
    }

    /**
     * Set user
     *
     * @param \AppBundle\Entity\User $user
     *
     * @return RarNotes
     */
    public function setUser(\AppBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \AppBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }
}

