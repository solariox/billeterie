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
        $this->get('session')->clear();

        //on crée un objet Commande
        $commande = new Commande();

        //on crée un objet Ticket
        $ticket = new Ticket();

        $form = $this->get('form.factory')->create(TicketType::class, $ticket);

         if($request->isMethod('POST')){
            // On vérifie que les valeurs entrées sont correctes
            if ($form->isValid()) {
                
            // On enregistre notre objet $ticket dans la base de données, par exemple

                $request->getSession()->getFlashBag()->add('notice', 'Annonce bien enregistrée.');
                // On redirige vers la page de visualisation de l'annonce nouvellement créée
                return $this->redirectToRoute('oc_ticketing_check', array('id' => $commande->getId()));
            }
        }

            return $this->render('OCTicketingBundle:Tunnel:index.html.twig', array(
        'form' => $form->createView(),
        ));

    }

    public function checkAction()
    {
        
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