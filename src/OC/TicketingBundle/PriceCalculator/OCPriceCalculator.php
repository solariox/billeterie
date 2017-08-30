<?php 


namespace OC\TicketingBundle\PriceCalculator;

use OC\TicketingBundle\Entity\Ticket;
use OC\TicketingBundle\Entity\Commande;

use \DateTime;

class OCPriceCalculator
{
  public function calculate(Commande $commande)
  {
    $totalPrice=0;
    $today = new \DateTime();
    foreach($commande->getTickets() as $ticket){
      
      //on transforme la date en objet pour pouvoir la manipuler 

      $birthday = ( is_string($ticket->getOwnerBirthday()) ) 
        ? DateTime::createFromFormat("d-m-Y", $ticket->getOwnerBirthday() ) 
        : $ticket->getOwnerBirthday();
      $dateInterval = $today->diff($birthday);

      if ($dateInterval->y < 4) {
          $price=0;
      } elseif ($dateInterval->y < 12 ) {
          $price=8;
      } elseif ($dateInterval->y >60) {
          $price=12;
      } else{
        $price=16;
      } 

      if($ticket->getReduced()){
        $price=10;
      }
      if($ticket->getHalfday()){
        $price=$price/2;
      }

      $ticket->setPrice($price);
      $totalPrice += $price;
    }
    
    $commande->setPrice($totalPrice);
  }

  public function SetToDate(Commande $commande)
  {
    foreach($commande->getTickets() as $ticket){
      $birthday = ( is_string($ticket->getOwnerBirthday()) ) 
        ? DateTime::createFromFormat("d-m-Y", $ticket->getOwnerBirthday() ) 
        : $ticket->getOwnerBirthday();
      $ticket->setOwnerBirthday($birthday);
    
      $bookdate = ( is_string($ticket->getBookdate()) ) 
        ? DateTime::createFromFormat("d-m-Y", $ticket->getBookdate() ) 
        : $ticket->getBookdate();
      $ticket->setBookdate($bookdate);
      }



  }
} 