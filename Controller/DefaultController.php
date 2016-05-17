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

        $flop = ['QD', 'QS', 'QC', 'KH', 'KS'];

        $hand = ['JD', 'JS'];

        $message = $he->findHands(array_merge($flop, $hand));

        dump($message);
        die;

        return new Response($message);
    }
}
