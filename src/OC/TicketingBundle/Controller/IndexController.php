<?php

namespace OC\TicketingBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class IndexController extends Controller
{
    public function indexAction()
    {
        return $this->render('OCTicketingBundle:Advert:index.html.twig');
    }

    public function checkAction()
    {
         return $this->render('OCTicketingBundle:Advert:check.html.twig');
    }

    public function paymentAction()
    {
         return $this->render('OCTicketingBundle:Advert:payment.html.twig');
    }

    public function ValidAction()
    {
         return $this->render('OCTicketingBundle:Advert:valid.html.twig');
    }
}