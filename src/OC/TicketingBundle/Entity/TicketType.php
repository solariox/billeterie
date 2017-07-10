<?php

namespace OC\TicketingBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
/**
 * TicketType
 */

/**
 * @ORM\Table(name="oc_tickeType")
 * @ORM\Entity(repositoryClass="OC\TicketingBundle\Repository\TicketTypeRepository")
 */
class TicketType
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $name;


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
     * @return TicketType
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
}

