<?php

namespace OC\TicketingBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Ticket
 */

 /**
 * @ORM\Entity
 */
class Ticket
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    /**
    * @ORM\ManyToMany(targetEntity="OC\TicketingBundle\Entity\TicketType", cascade={"persist"})
    * @ORM\JoinTable(name="oc_ticket_type")
    */
    private $type;

    /**
     * @var \DateTime
     */
    private $date;

    /**
     * @var string
     */
    private $owner;


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
     * Set type
     *
     * @param string $type
     *
     * @return Ticket
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     *
     * @return Ticket
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
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
}

