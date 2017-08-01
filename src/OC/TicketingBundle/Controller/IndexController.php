<?php

namespace OC\TicketingBundle\Controller;

use OC\TicketingBundle\Entity\Ticket;
use OC\TicketingBundle\Entity\Commande;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

use OC\TicketingBundle\Form\CommandeType;
use OC\TicketingBundle\Form\TicketType;
// Import Non-Namespaced Stripe Library
use Stripe;
use \Swift_Message;

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
        ->getRepository('OCTicketingBundle:Commande');
        
        $result = $repository->findByOrderDate($commande->getOrderDate());
        
        // Verification d'un trop de commande 
        if (count($result) >1000){
            return $this->redirectToRoute('oc_ticketing_error');
        }




        if($request->isMethod('POST')){
            $form->handleRequest($request);
            // On vérifie que les valeurs entrées sont correctes
            if ($form->isValid()) {
                $request->getSession()->set("commande", $commande);
                return $this->redirectToRoute('oc_ticketing_payment');  
            }    
        }

            return $this->render('OCTicketingBundle:Tunnel:check.html.twig', array(
        'commande' => $commande));
    }

    public function paymentAction(Request $request)
    {
        $commande = $request->getSession()->get("commande");

            return $this->render('OCTicketingBundle:Tunnel:payment.html.twig', array(
        'commande' => $commande));
    }

    public function ValidAction(Request $request)
    {
        $commande = $request->getSession()->get("commande");
        foreach($commande->getTickets() as $ticket){
            $commande->addTicket($ticket);
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



        $message = (new \Swift_Message('Hello Email'))
        ->setFrom('send@example.com')
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

    $this->get('mailer')->send($message);



         return $this->render('OCTicketingBundle:Tunnel:valid.html.twig', array(
        'commande' => $commande));
    }


    
    public function errorAction(Request $request){
            return $this->render('OCTicketingBundle:Tunnel:error.html.twig');
    }

}