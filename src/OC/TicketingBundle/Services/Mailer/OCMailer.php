<?php

namespace OC\TicketingBundle\Services\Mailer;

use \Swift_Message;
use \Swift_Attachment;

require('code39.php');

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
            $pdf = new \PDF_Code39();
            $pdf->AddPage();
            $pdf->SetFont('Arial','B',16);
            // Logo
            $pdf->Image('https://upload.wikimedia.org/wikipedia/fr/9/9f/Musee_du_Louvre_1992_logo.png',10,6,30);
            // Décalage à droite
            $pdf->Cell(80);
            // Titre
            $pdf->Cell(60,10,utf8_decode ('Musée du Louvre'),0,0,'c');
            // Saut de ligne
            $pdf->Ln(20);
            // Nom du possesseur
            $pdf->Cell(60,10,utf8_decode ('Billet de '. $ticket->getOwner().' pour le '. $ticket->getBookdate()->format('d-m-Y')) ,0,0,'c');
            // Saut de ligne
            $pdf->Ln(20);
            $pdf->Code39(10,40,$ticket->getReservationNumber(),1,10); //Code39(float xpos, float ypos, string code [, float baseline [, float height]])
            // Saut de ligne
            $pdf->Ln(10);
             // Tarif
            $pdf->Cell(60,10,utf8_decode ('Tarif : '. $ticket->getPrice().'euros'),0,0,'c');

            $attachment = new Swift_Attachment($pdf->Output('S'), 'ticket.pdf', 'application/pdf');
            $message->attach($attachment);
        }
        
    $this->mailer->send($message);

    }
}
