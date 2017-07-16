<?php

namespace OC\TicketingBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Ticket
 *
 * @ORM\Table(name="ticket")
 * @ORM\Entity(repositoryClass="OC\TicketingBundle\Repository\TicketRepository")
 */
class Ticket
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
     * @var int
     * @ORM\ManyToOne(targetEntity="OC\TicketingBundle\Entity\Commande", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $commandeId;

    /**
     * @var string
     *
     * @ORM\Column(name="owner", type="string", length=255)
     */
    private $owner;

    /**
     * @var bool
     *
     * @ORM\Column(name="tarif", type="boolean")
     */
    private $tarif;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="bookdate", type="date")
     */
    private $bookdate;


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
     * Set commandeId
     *
     * @param integer $commandeId
     *
     * @return Ticket
     */
    public function setCommandeId($commandeId)
    {
        $this->commandeId = $commandeId;

        return $this;
    }

    /**
     * Get commandeId
     *
     * @return int
     */
    public function getCommandeId()
    {
        return $this->commandeId;
    }

    /**
     * Set owner
     *
     * @param string $owner
     *
     * @return Ticket
     */
    public function setOwner($owner)
    {
        $this->owner = $owner;

        return $this;
    }

    /**
     * Get owner
     *
     * @return string
     */
    public function getOwner()
    {
        return $this->owner;
    }

    /**
     * Set tarif
     *
     * @param boolean $tarif
     *
     * @return Ticket
     */
    public function setTarif($tarif)
    {
        $this->tarif = $tarif;

        return $this;
    }

    /**
     * Get tarif
     *
     * @return bool
     */
    public function getTarif()
    {
        return $this->tarif;
    }

    /**
     * Set bookdate
     *
     * @param \DateTime $bookdate
     *
     * @return Ticket
     */
    public function setBookdate($bookdate)
    {
        $this->bookdate = $bookdate;

        return $this;
    }

    /**
     * Get bookdate
     *
     * @return \DateTime
     */
    public function getBookdate()
    {
        return $this->bookdate;
    }
}

