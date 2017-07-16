<?php

namespace OC\TicketingBundle\Controller;

use OC\TicketingBundle\Entity\Ticket;
use OC\TicketingBundle\Entity\Commande;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;


class CheckController extends Controller
{
    public function checkAction ( Request $request)
    {
           return $this->render('OCTicketingBundle:Tunnel:check.html.twig');

    }


}