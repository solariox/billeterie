<?php

namespace OC\TicketingBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;

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
     * @ORM\ManyToOne(targetEntity="OC\TicketingBundle\Entity\Commande",inversedBy="tickets", cascade={"persist"})
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
     * @var \DateTime
     *
     * @ORM\Column(name="ownerBirthday", type="date")
     * @Assert\DateTime()
     */
    private $ownerBirthday;

    /**
     * @var bool
     *
     * @ORM\Column(name="reduced", type="boolean")
     */
    private $reduced;
    
     /**
     * @var bool
     *
     * @ORM\Column(name="halfday", type="boolean")
     */
    private $halfday;


    /**
     * @var \DateTime
     *
     * @ORM\Column(name="bookdate", type="date")
     * @Assert\DateTime()
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

    /**
     * Set ownerBirthday
     *
     * @param \DateTime $ownerBirthday
     *
     * @return Ticket
     */
    public function setOwnerBirthday($ownerBirthday)
    {
        $this->ownerBirthday = $ownerBirthday;

        return $this;
    }

    /**
     * Get ownerBirthday
     *
     * @return \DateTime
     */
    public function getOwnerBirthday()
    {
        return $this->ownerBirthday;
    }

    /**
     * Set reduced
     *
     * @param boolean $reduced
     *
     * @return Ticket
     */
    public function setReduced($reduced)
    {
        $this->reduced = $reduced;

        return $this;
    }

    /**
     * Get reduced
     *
     * @return boolean
     */
    public function getReduced()
    {
        return $this->reduced;
    }

    /**
     * Set halfday
     *
     * @param boolean $halfday
     *
     * @return Ticket
     */
    public function setHalfday($halfday)
    {
        $this->halfday = $halfday;

        return $this;
    }

    /**
     * Get halfday
     *
     * @return boolean
     */
    public function getHalfday()
    {
        return $this->halfday;
    }
}
