<?php

namespace Bourdeau\Bundle\HandEvaluatorBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{
    /**
     * @Route("/")
     */
    public function indexAction()
    {
        $he = $this->get('bourdeau_bundle_hand_evaluator.handevaluator');
        $cards = ['10S', '9C', '8H', '7D', '6S', 'QC', '2D'];
        $message = $he->findHands($cards);

        $response = new Response(json_encode($message));
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }
}
