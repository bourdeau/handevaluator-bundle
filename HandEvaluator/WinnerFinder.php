<?php

namespace Bourdeau\Bundle\HandEvaluatorBundle\HandEvaluator;

/**
 * Hand Evaluator for Poker
 *
 * @author Pierre-Henri Bourdeau <phbasic@gmail.com>
 */
class WinnerFinder
{
    private $handFinder;

    public function __construct($handFinder)
    {
        $this->handFinder = $handFinder;
    }

    public function findAWinner(array $playersCards)
    {
        foreach ($playersCards as $playerName => $cards) {
            $hands[] = $this->handFinder->findhand($card);
        }
    }
}
