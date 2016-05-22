<?php

namespace Bourdeau\Bundle\HandEvaluatorBundle\HandEvaluator;

/**
 * CardValidator
 *
 * Validate that the given cards are a valid set of cards for Texas Holdem Poker
 *
 * @author Pierre-Henri Bourdeau <phbasic@gmail.com>
 */
class CardValidator
{
    const VALID_CARDS = [
        'AD', 'KD', 'QD', 'JD', '10D', '9D', '8D', '7D', '6D', '5D', '4D', '3D', '2D',
        'AH', 'KH', 'QH', 'JH', '10H', '9H', '8H', '7H', '6H', '5H', '4H', '3H', '2H',
        'AC', 'KC', 'QC', 'JC', '10C', '9C', '8C', '7C', '6C', '5C', '4C', '3C', '2C',
        'AS', 'KS', 'QS', 'JS', '10S', '9S', '8S', '7S', '6S', '5S', '4S', '3S', '2S',
    ];

    /**
     * The main class method
     *
     * @param  array $cards
     *
     * @return boolean
     */
    public function areValid(array $cards)
    {
        if (count($cards) != 7) {
             throw new \Exception("It's Texas Holdem! You need 7 cards!");
        }

        if ($this->areCardsFormatValid($cards) && $this->hasNoCardDuplication($cards)) {
            return true;
        }
    }

    /**
     * Check if the cards are in a valid format
     *
     * @param  array  $cards
     * @return boolean
     */
    private function areCardsFormatValid(array $cards)
    {
        foreach ($cards as $card) {
            if (!in_array($card, self::VALID_CARDS)) {
                throw new \Exception(sprintf("The card %s is not in a valid format!", $card));
            }
        }

        return true;
    }

    /**
     * Look for card duplication
     *
     * @param  array  $cards
     *
     * @return boolean
     */
    private function hasNoCardDuplication(array $cards)
    {
        $values = array_count_values($cards);

        foreach ($values as $key => $value) {
            if ($value > 1) {
                throw new \Exception(sprintf("The card %s is duplicate!", $key));
            }
        }

        return true;
    }
}
