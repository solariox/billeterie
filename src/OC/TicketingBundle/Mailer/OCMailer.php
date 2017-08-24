<?php

namespace OC\TicketingBundle\Mailer;

use \Swift_Message;
use \Swift_Attachment;

class OCMailer
{

    public function __construct($templating, $mailer)
    { 
        $this->templating = $templating;
        $this->mailer = $mailer;
    }


    public function sendMail($commande)
    {
        $message = (new \Swift_Message('Transaction validée'))

        ->setFrom('contact@louvre.com')
        ->setTo($commande->getEmail())
        ->setBody(
            $this->templating->render(
                // app/Resources/views/Emails/validation.html.twig
                'Emails\validation.html.twig',
                array('commande' => $commande)
            ),
            'text/html'
        )
    ;
/*
        // Create the attachment with your data
    $attachment = new Swift_Attachment($pdf->Output('S'), 'ticket.pdf', 'application/pdf');
    // Attach it to the message
    $message->attach($attachment); */

        foreach($commande->getTickets() as $ticket){
            $pdf = new \FPDF();
            $pdf->AddPage();
            $pdf->SetFont('Arial','B',16);
            $pdf->Cell(40,10,'Billet de '. $ticket->getOwner() );
            $attachment = new Swift_Attachment($pdf->Output('S'), 'ticket.pdf', 'application/pdf');
            $message->attach($attachment);
        }
        
    $this->mailer->send($message);

    }
}
