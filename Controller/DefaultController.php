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

        $message = $he->findHands(['AD', 'AC', 'AH', '9D', '9H', '9C', 'JS']);

        dump($message);
        die;

        return new Response($message);
    }
}
