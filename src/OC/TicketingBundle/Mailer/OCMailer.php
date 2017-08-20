<?php

use \Swift_Message;
use \Swift_Attachment;

class OCPMailer
{
    public function sendMail($commande)
    {
        $message = (new \Swift_Message('Transaction validée'))
        ->setFrom('contact@louvre.com')
        ->setTo($commande->getEmail())
        ->setBody(
            $this->renderView(
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
            $attachment = new Swift_Attachment($pdf->Output('S'), 'ticket.pdf', 'application/pdf');

            $pdf->AddPage();
            $pdf->SetFont('Arial','B',16);
            $pdf->Cell(40,10,'Billet de ');
            $message->attach($attachment);
        


    $this->get('mailer')->send($message);

}
