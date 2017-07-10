<?php

namespace OC\TicketingBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Commande
 */

 /**
 * @ORM\Entity
 */
class Commande
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var int
     * @ORM\ManyToOne(targetEntity="OC\TicketingBundle\Entity\Ticket", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $ticketId;

    /**
     * @var int
     */
    private $price;


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
     * Set ticketId
     *
     * @param integer $ticketId
     *
     * @return Commande
     */
    public function setTicketId($ticketId)
    {
        $this->ticketId = $ticketId;

        return $this;
    }

    /**
     * Get ticketId
     *
     * @return int
     */
    public function getTicketId()
    {
        return $this->ticketId;
    }

    /**
     * Set price
     *
     * @param integer $price
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
}

