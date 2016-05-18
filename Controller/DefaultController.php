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
        $cards = ['AC', '2D', '3H', '4H', '5S', 'KS', '10D'];

        $message = $he->findHands($cards);

        $response = new Response(json_encode($message));
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }
}
