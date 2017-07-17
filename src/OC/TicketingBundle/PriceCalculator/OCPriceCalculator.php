<?php 


namespace OC\TicketingBundle\PriceCalculator;


class OCPriceCalculator
{
  public function calculate($tickets)
  {
    $price=0;
    foreach($tickets as $ticket){
      $birthday = $ticket->getOwnerBirthday();
      var_dump($ticket);

      if ($birthday == '1879-03-14') {
          echo "i égal 0";
      } elseif ($birthday == '1879-03-14') {
          echo "i égal 1";
      } elseif ($birthday == '1879-03-14') {
          echo "i égal 2";
      } else{
        $price+=25;
      } 

      if($ticket->getReduced()){
        $price=$price/2;
      }
      if($ticket->getHalfday()){
        $price=$price/2;
      }
    }
  return($price);
  }
} 