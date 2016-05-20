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

    /**
     * [findAWinner description]
     * @param  array  $players A simple array with key as Player Name and value
     * as the cards.
     *
     * @return array
     */
    public function findAWinner(array $players)
    {
        $playerRanks = [
            'winners'        => [],
            'other_players' => [],
        ];

        foreach ($players as $playerName => $cards) {
            //@todo should one care about the given card? I remove them for now
             $players[$playerName] = $this->handFinder->findhand($cards);

             // We do not have a winner yet
             if (count($playerRanks['winners']) == 0) {
                 $playerRanks['winners'] = [$playerName => $players[$playerName]];
             }

             // If we already have a winner it must be challenged with other players
             if (count($playerRanks['winners']) > 0 && key($playerRanks['winners']) !== $playerName) {
                 if ($newWinner = $this->challengeTheWinner($playerRanks['winners'], [$playerName => $players[$playerName]])) {
                     $playerRanks['winners'] = $newWinner;
                 }
             }
        }

        foreach ($playerRanks['winners'] as $winner => $data) {
            unset($players[$winner]);
        }

        $playerRanks['other_players'] = $players;

        return $playerRanks;
    }

    /**
     * Return the new winner if it beats the current one
     *
     * @param  array  $currentWinners
     * @param  array  $challenger
     *
     * @return array|bool
     */
    private function challengeTheWinner(array $currentWinners, array $challenger)
    {
        $currentChallenger = current($challenger);

        foreach ($currentWinners as $currentWinnerName => $currentWinner) {
            // Current player hand rank is higher than current winner
            if ($currentWinner['hand_rank'] < $currentChallenger['hand_rank']) {
                return $challenger;
            }

            // Current player hand rank is equal to current winner but it's card ranks is higher
            if ($currentWinner['hand_rank'] == $currentChallenger['hand_rank'] && $currentWinner['card_rank'] < $currentChallenger['card_rank']) {
                return $challenger;
            }

            // Players are equaly ranked, it's a dead heat. We return both players
            if ($currentWinner['hand_rank'] == $currentChallenger['hand_rank'] && $currentWinner['card_rank'] == $currentChallenger['card_rank']) {

                return array_merge($currentWinners, $challenger);
            }
        }

        return false;
    }

}
