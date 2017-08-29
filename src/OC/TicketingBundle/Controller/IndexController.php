<?php

namespace OC\TicketingBundle\Controller;

use OC\TicketingBundle\Entity\Ticket;
use OC\TicketingBundle\Entity\Commande;
use  \DateTime;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

use OC\TicketingBundle\Form\CommandeType;
use OC\TicketingBundle\Form\TicketType;
// Import Non-Namespaced Stripe Library
use Stripe;
use \Swift_Message;
use \Swift_Attachment;

class IndexController extends Controller
{
    public function indexAction ( Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        //on crée un objet Commande
        $commande = new Commande();

        $form = $this->get('form.factory')->create(CommandeType::class, $commande);

         if($request->isMethod('POST')){
            $form->handleRequest($request);
            // On vérifie que les valeurs entrées sont correctes
            if ($form->isValid()) {
                //gestion des informations eronnées 
                $today = new DateTime();
                 foreach ($commande->getTickets() as $ticket){
                    $bookdate = DateTime::createFromFormat("d-m-Y", $ticket->getBookdate());
                    $birthday = DateTime::createFromFormat("d-m-Y", $ticket->getOwnerBirthday());
                    
                    if ($today > $bookdate){
                        $this->get('session')->getFlashBag()->set('error', 'Vous ne pouvez reserver dans le passé');
                        return $this->redirectToRoute('oc_ticketing_error');
                    }

                    if ($today < $birthday){
                        $this->get('session')->getFlashBag()->set('error', 'Vous ne pouvez être né dans le futur');
                        return $this->redirectToRoute('oc_ticketing_error');
                    }
                 }

                $commande->setOrderDate(new \DateTime());
                $request->getSession()->set("commande", $commande);
                return $this->redirectToRoute('oc_ticketing_check');
            }    
        }
            return $this->render('OCTicketingBundle:Tunnel:index.html.twig', array(
        'form' => $form->createView(),
        ));

    }

    public function checkAction(Request $request)
    {
        $commande = $request->getSession()->get("commande");

        // On récupère le service de calcul de prix
        $PriceCalculator = $this->container->get('oc_ticketing.pricecalculator');
        $PriceCalculator->calculate($commande);
        $PriceCalculator->SetToDate($commande);

        $repository = $this
        ->getDoctrine()
        ->getManager()
        ->getRepository('OCTicketingBundle:Ticket');
        
        $tickets = $commande->getTickets();

        foreach ($tickets as $ticket){
            
        $result = $repository->findByBookdate($ticket->getBookdate());
         // Verification d'un trop de commande 
        if (count($result) >1000){
            $this->get('session')->getFlashBag()->set('error', 'Vous ne pouvez pas reserver, trop de tickets ont été vendu ce jour. ');
            return $this->redirectToRoute('oc_ticketing_error');
            }
        }

            return $this->render('OCTicketingBundle:Tunnel:check.html.twig', array(
        'commande' => $commande));
    }


    public function ValidAction(Request $request)
    {
        $commande = $request->getSession()->get("commande");
        
        foreach($commande->getTickets() as $ticket){
            $ticket->setCommandeId($commande);
        }
        // Set your API key
        \Stripe\Stripe::setApiKey("sk_test_r8dPHfTJDMI5duQunjSxvqng");
        try {
            \Stripe\Charge::create([
                'amount' => $commande->getPrice() * 100,
                'currency' => 'eur',
                'card' => $_POST['stripeToken'],
                'description' => 'blabla'
            ]);
        } catch (\Stripe\CardError $e) {
           var_dump("error");
        }
         // On récupère l'EntityManager
        $em = $this->getDoctrine()->getManager();

        // Étape 1 : On « persiste » l'entité
        $em->persist($commande);

        // Étape 2 : On « flush » tout ce qui a été persisté avant
        $em->flush();

        foreach($commande->getTickets() as $ticket){
            $ticket->setReservationNumber(substr( sha1('cdg18jg65324gjfhn'.$ticket->getId()),0,16)); //génération et troncage du code avec sel,
        }

        $Mailer = $this->container->get('oc_ticketing.mailer');
        $Mailer->sendMail($commande, $this);
        
         return $this->render('OCTicketingBundle:Tunnel:valid.html.twig', array(
        'commande' => $commande));
    }

    
    public function errorAction(Request $request){
            return $this->render('OCTicketingBundle:Tunnel:error.html.twig');
    }

}