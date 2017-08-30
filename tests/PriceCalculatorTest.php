<?php 

namespace Tests;

use PHPUnit\Framework\TestCase;
use OC\TicketingBundle\Entity\Ticket;
use OC\TicketingBundle\Entity\Commande;
use OC\TicketingBundle\PriceCalculator\OCPriceCalculator;

class PriceCalculatorTest extends TestCase
{
     public function testCalculate()
    {
        $commande = new Commande();
        
        $ticket = new Ticket();

        $ticket->setOwnerBirthday('20-03-1998');
        
        $commande->addTicket($ticket);

        $calc = new OCPriceCalculator();
        $calc->calculate($commande);

        // assert that your calculator added the numbers correctly!
        $this->assertEquals($commande->getPrice(), 16);
    }

    public function testCommandeReduced()
    {
        $commande = new Commande();
        
        $ticket = new Ticket();

        $ticket->setOwnerBirthday('20-03-1998');
        $ticket->setReduced(TRUE);
        $commande->addTicket($ticket);

        $calc = new OCPriceCalculator();
        $calc->calculate($commande);

        // assert that your calculator added the numbers correctly!
        $this->assertEquals($commande->getPrice(), 10);
    }



}