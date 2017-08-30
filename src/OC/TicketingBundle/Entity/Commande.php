<?php

namespace OC\TicketingBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
/**
 * Commande
 *
 * @ORM\Table(name="commande")
 * @ORM\Entity(repositoryClass="OC\TicketingBundle\Repository\CommandeRepository")
 */
class Commande
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
     * @ORM\OneToMany(targetEntity="OC\TicketingBundle\Entity\Ticket",mappedBy="commandeId",cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $tickets;

     /**
     * @var \DateTime
     *
     * @ORM\Column(name="orderDate", type="date")
     * @Assert\DateTime()
     */
    private $orderDate;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255)
     * @Assert\Email
     */
    private $email;

    /**
     * @var int
     *
     * @ORM\Column(name="price", type="integer")
     */
    private $price;

    /**
     * @var string
     *
     * @ORM\Column(name="paiementOK", type="string", nullable=TRUE)
     */
    private $paiementOK;


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
     * Set tickets
     *
     * @param string $tickets
     *
     * @return Commande
     */
    public function setTickets($tickets)
    {
        $this->tickets = $tickets;

        return $this;
    }

    /**
     * Get tickets
     *
     * @return string
     */
    public function getTickets()
    {
        return $this->tickets;
    }


    /**
     * Set email
     *
     * @param string $email
     *
     * @return Commande
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set price
     *
     * @param int $price
     *
     * @return Commande
     */

    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return int
     */
    public function getPrice()
    {
        return $this->price;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->tickets = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add ticket
     *
     * @param \OC\TicketingBundle\Entity\Ticket $ticket
     *
     * @return Commande
     */
    public function addTicket(\OC\TicketingBundle\Entity\Ticket $ticket)
    {
        $this->tickets[] = $ticket;
        $ticket->setCommandeId($this);
        return $this;
    }

    /**
     * Remove ticket
     *
     * @param \OC\TicketingBundle\Entity\Ticket $ticket
     */
    public function removeTicket(\OC\TicketingBundle\Entity\Ticket $ticket)
    {
        $this->tickets->removeElement($ticket);
    }

    /**
     * Set orderDate
     *
     * @param \DateTime $orderDate
     *
     * @return Commande
     */
    public function setOrderDate($orderDate)
    {
        $this->orderDate = $orderDate;

        return $this;
    }

    /**
     * Get orderDate
     *
     * @return \DateTime
     */
    public function getOrderDate()
    {
        return $this->orderDate;
    }

    /**
     * Set paiementOK
     *
     * @param string $paiementOK
     *
     * @return Commande
     */
    public function setPaiementOK($paiementOK)
    {
        $this->paiementOK = $paiementOK;

        return $this;
    }

    /**
     * Get paiementOK
     *
     * @return string
     */
    public function getPaiementOK()
    {
        return $this->paiementOK;
    }
}
