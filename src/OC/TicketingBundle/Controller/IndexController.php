<?php

namespace OC\TicketingBundle\Controller;

use OC\TicketingBundle\Entity\Ticket;
use OC\TicketingBundle\Entity\Commande;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

use OC\TicketingBundle\Form\CommandeType;
use OC\TicketingBundle\Form\TicketType;

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
        $nouvelle_commande = $request->getSession()->get("commande");

        var_dump($nouvelle_commande);
        if($request->isMethod('POST')){
            $form->handleRequest($request);
            // On vérifie que les valeurs entrées sont correctes
            if ($form->isValid()) {
                $request->getSession()->set("commande", $commande);
                return $this->redirectToRoute('oc_ticketing_payment');
            }    
        }

            return $this->render('OCTicketingBundle:Tunnel:check.html.twig', array(
        'commande' => $nouvelle_commande));
    }

    public function paymentAction()
    {
         return $this->render('OCTicketingBundle:Tunnel:payment.html.twig');
    }

    public function ValidAction()
    {
         return $this->render('OCTicketingBundle:Tunnel:valid.html.twig');
    }
}