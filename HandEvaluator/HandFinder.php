<?php

namespace Bourdeau\Bundle\HandEvaluatorBundle\HandEvaluator;

use Bourdeau\Bundle\HandEvaluatorBundle\HandEvaluator\CardValidator;

/**
 * Hand Evaluator for Poker
 *
 * @author Pierre-Henri Bourdeau <phbasic@gmail.com>
 */
class HandFinder
{
    private $cardValidator;

    /**
     * Constructor
     *
     * @param CardValidator $cardValidator [description]
     */
    public function __construct(CardValidator $cardValidator)
    {
        $this->cardValidator = $cardValidator;
    }

    /**
     *
     * Will return the best hand with the given cards.
     *
     * IMPORTANT: the oder in wich the methods are called is critical.
     * Changing it will break the code, as a Three of a Kind will always
     * be found in a Full House for instance.
     *
     * @param array $cards
     *
     * @return string
     */
    public function findHand(array $cards)
    {
        if (!$this->cardValidator->areValid($cards)) {
            throw new \Exception('Your cards are not valid');
        }

        if ($res = $this->isRoyalFlush($cards)) {
            return $res;
        }
        if ($res = $this->isStraightFlush($cards)) {
            return $res;
        }
        if ($res = $this->isFourOfAKind($cards)) {
            return $res;
        }
        if ($res = $this->isFullHouse($cards)) {
            return $res;
        }
        if ($res = $this->isFlush($cards)) {
            return $res;
        }
        if ($res = $this->isStraight($cards)) {
            return $res;
        }
        if ($res = $this->isTreeOfAKind($cards)) {
            return $res;
        }
        if ($res = $this->isTwoPairs($cards)) {
            return $res;
        }
        if ($res = $this->isOnePair($cards)) {
            return $res;
        }
        if ($res = $this->isHighCard($cards)) {
            return $res;
        }

        throw new \Exception("Couldn't find a Hand!");
    }

    /**
     * Sort cards
     *
     * @param  array  $cards
     *
     * @return array
     */
    private function sortCards(array $cards)
    {
        $data = [];
        $cardOrder = [
            'A'  => 1,
            'K'  => 2,
            'Q'  => 3,
            'J'  => 4,
            '10' => 5,
            '9'  => 6,
            '8'  => 7,
            '7'  => 8,
            '6'  => 9,
            '5'  => 10,
            '4'  => 11,
            '3'  => 12,
            '2'  => 13,
        ];

        foreach ($cards as $card) {
            $cardKey = substr($card, 0, -1);
            if (array_key_exists($cardKey, $cardOrder)) {
                $data[$cardOrder[$cardKey]] = $card;
            }
        }

        ksort($data);

        return $data;
    }

    /**
     * Get rank of a card
     *
     * @param  array  $cards
     *
     * @return int
     */
    private function getRank(array $cards)
    {
        $cardRank = [
            'A'  => 13,
            'K'  => 12,
            'Q'  => 11,
            'J'  => 10,
            '10' => 9,
            '9'  => 8,
            '8'  => 7,
            '7'  => 6,
            '6'  => 5,
            '5'  => 4,
            '4'  => 3,
            '3'  => 2,
            '2'  => 1,
        ];

        $card = current($cards);

        $cardFace = substr($card, 0, -1);

        if (array_key_exists($cardFace, $cardRank)) {
            return $cardRank[$cardFace];
        }

        throw new \Exception(sprintf('No rank found for card %s'), $card);
    }

    /**
     * Return a formated response.
     *
     * @param string $handName
     * @param int    $handRank
     * @param int    $cardRank
     * @param array  $response
     *
     * @return array
     */
    private function getResponse($handName, $handRank, $cardRank, array $response)
    {
        return [
            'hand_name' => $handName,
            'hand_rank' => (int) $handRank,
            'card_rank' => (int) $cardRank,
            'cards'     => $response,
        ];
    }

    private function findMultipleFaceCards(array $cards)
    {
        $faces = [
            'A' => [],
            'K' => [],
            'Q' => [],
            'J' => [],
            '10' => [],
            '9' => [],
            '8' => [],
            '7' => [],
            '6' => [],
            '5' => [],
            '4' => [],
            '3' => [],
            '2' => [],
        ];

        foreach ($cards as $card) {
            $cardFace = substr($card, 0, 1);

            if (substr($card, 0, 2) == 10) {
                $cardFace = substr($card, 0, 2);
            }

            switch ($cardFace) {
                case 'A':
                    $faces['A'][] = $card;
                    break;
                case 'K':
                    $faces['K'][] = $card;
                    break;
                case 'Q':
                    $faces['Q'][] = $card;
                    break;
                case 'J':
                    $faces['J'][] = $card;
                    break;
                case '10':
                    $faces['10'][] = $card;
                    break;
                case '9':
                    $faces['9'][] = $card;
                    break;
                case '8':
                    $faces['8'][] = $card;
                    break;
                case '7':
                    $faces['7'][] = $card;
                    break;
                case '6':
                    $faces['6'][] = $card;
                    break;
                case '5':
                    $faces['5'][] = $card;
                    break;
                case '4':
                    $faces['4'][] = $card;
                    break;
                case '3':
                    $faces['3'][] = $card;
                    break;
                case '2':
                    $faces['2'][] = $card;
                    break;
                default:
                    throw new \Exception(sprintf("The face %s doesn't exist!", $color));
            }
        }

        return $faces;
    }
    /**
     * Return true if the cards are a Royal Flush.
     *
     * @param array $cards
     *
     * @return bool
     */
    private function isRoyalFlush(array $cards)
    {
        $hearts = [
            ['AH', 'KH', 'QH', 'JH', '10H'],
            ['AD', 'KD', 'QD', 'JD', '10D'],
            ['AS', 'KS', 'QS', 'JS', '10S'],
            ['AC', 'KC', 'QC', 'JC', '10C'],
        ];

        foreach ($hearts as $value) {
            if (count(array_intersect($value, $cards)) === 5) {
                return $this->getResponse('Royal Flush', 10, $this->getRank($value), $value);
            }
        }

        return false;
    }

    /**
     * Return an array if the cards are a Straight Flush
     * otherwise return false.
     *
     * @param array $cards
     *
     * @return array|bool
     */
    private function isStraightFlush(array $cards)
    {
        // Check if Flush first, because isStraight() remove duplicate cards
        if ($straightFlushCards = $this->isFlush($cards)) {
            if ($straightCards = $this->isStraight($straightFlushCards['cards'])) {
                return $this->getResponse('Straight Flush', 9, $straightCards['card_rank'], $straightCards['cards']);
            }
        }

        return false;
    }

    /**
     * Return an array if the cards are a Four of a Kind
     * otherwise return false.
     *
     * @example AC AD AS AH 2D 7D 10S
     *
     * @param array $cards
     *
     * @return array|bool
     */
    private function isFourOfAKind(array $cards)
    {
        $faces = $this->findMultipleFaceCards($cards);

        foreach ($faces as $face => $groupedFaces) {
            if (count($groupedFaces) == 4) {
                return $this->getResponse('Four of a kind', 8, $this->getRank($groupedFaces), $groupedFaces);
            }
        }

        return false;
    }

    /**
     * Return an array if the cards are a Full House
     * otherwise return false.
     *
     * @param array $cards
     *
     * @return array|bool
     */
    private function isFullHouse(array $cards)
    {
        $faces = $this->findMultipleFaceCards($cards);
        $res = [];

        foreach ($faces as $face => $groupedFaces) {
            $nbCards = count($groupedFaces);

            if ($nbCards == 3) {
                foreach ($groupedFaces as $value) {
                    $res[] = $value;
                }
                unset($faces[$face]);
                break;
            }
        }

        foreach ($faces as $face => $groupedFaces) {
            $nbCards = count($groupedFaces);

            if ($nbCards >= 2) {
                foreach ($groupedFaces as $key => $value) {
                    $res[] = $value;
                    //We just pick up just 2 cards if there is more
                    if ($nbCards > 2 && $key == 1) {
                        break;
                    }
                }
                unset($faces[$face]);
                break;
            }
        }

        if (count($res) == 5) {
            return $this->getResponse('Full House', 7, $this->getRank($res), $res);
        }

        return false;
    }

    /**
     * Return true if the cards are a Flush.
     *
     * @param array $cards
     *
     * @return bool
     */
    private function isFlush(array $cards)
    {
        $colors = [
            'S' => [],
            'D' => [],
            'C' => [],
            'H' => [],
        ];

        foreach ($cards as $card) {
            $color = substr($card, -1);

            if (!in_array($color, ['S', 'D', 'C', 'H'])) {
                throw new \Exception(sprintf("The color %s doesn't exist!", $color));
            }

            if ($color == 'S') {
                $colors['S'][] = $card;
            } elseif ($color == 'D') {
                $colors['D'][] = $card;
            } elseif ($color == 'C') {
                $colors['C'][] = $card;
            } elseif ($color == 'H') {
                $colors['H'][] = $card;
            }
        }

        foreach ($colors as $color => $groupedCards) {
            if (count($groupedCards) == 5) {
                $flushCards = $this->sortCards($groupedCards);

                return $this->getResponse('Flush', 6, $this->getRank($flushCards), $flushCards);
            }
        }

        return false;
    }

    /**
     * Return false if the cards are not a Straight
     * otherwise it returns an array.
     *
     * @todo Straight from bottom, i.e. AC 2D 3H 4H 5S
     *
     * @param array $cards
     *
     * @return array|bool
     */
    private function isStraight(array $cards)
    {
        $cards = $this->sortCards($cards);
        $response = [];

        // Special straight from bottom with Ace
        if (array_key_exists(1, $cards) &&
            array_key_exists(10, $cards) &&
            array_key_exists(11, $cards) &&
            array_key_exists(12, $cards) &&
            array_key_exists(13, $cards)
        ) {
            foreach ($cards as $key => $card) {
                if ($key == 1 || $key == 10 || $key == 11 || $key == 12 || $key == 13) {
                    $response[] = $card;
                }
            }

            return $this->getResponse('Straight', 5, 6, $response);
        }

        foreach ($cards as $key => $value) {
            if (array_key_exists($key + 1, $cards) || (array_key_exists($key - 1, $cards) && count($response) == 4)) {
                $response[$key] = $value;
            } else {
                $response = [];
            }

            if (count($response) == 5) {
                return $this->getResponse('Straight', 5, $this->getRank($response), $response);
            }
        }

        return false;
    }

    /**
     * Return an array if it's a Tree of a Kind or false if not.
     *
     * @param array $cards
     *
     * @return array|bool
     */
    private function isTreeOfAKind(array $cards)
    {
        $faces = $this->findMultipleFaceCards($cards);

        foreach ($faces as $face => $groupedFaces) {
            if (count($groupedFaces) == 3) {
                return $this->getResponse('Three of a kind', 4, $this->getRank($groupedFaces), $groupedFaces);
            }
        }

        return false;
    }

    /**
     * Find one or n pair
     *
     * @param  string $typeOfPair
     * @param  int $nbCards
     * @param  array  $cards
     *
     * @return array|bool
     */
    private function findPair($typeOfPair, $handRank, $nbCards, array $cards)
    {
        $faces = $this->findMultipleFaceCards($cards);
        $response = [];

        foreach ($faces as $face => $groupedFaces) {
            if (count($groupedFaces) == 2 && count($response) !== $nbCards) {
                foreach ($groupedFaces as $value) {
                    $response[] = $value;
                }
            }
        }

        if (count($response) == $nbCards) {
            return $this->getResponse($typeOfPair, $handRank, $this->getRank($response), $response);
        }

        return false;
    }

    /**
     * Return an array if it's Two Pairs or false if not.
     *
     * @param array $cards
     *
     * @return array|bool
     */
    private function isTwoPairs(array $cards)
    {
        if ($response = $this->findPair('Two Pairs', 3, 4, $cards)) {
            return $response;
        }

        return false;
    }

    /**
     * Return an array if it's One Pair or false if not.
     *
     * @param array $cards
     *
     * @return array|bool
     */
    private function isOnePair(array $cards)
    {
        if ($response = $this->findPair('One Pair', 2, 2, $cards)) {
            return $response;
        }

        return false;
    }

    /**
     * Return an array if it's High Card or false if not.
     *
     * @param array $cards
     *
     * @return array|bool
     */
    private function isHighCard(array $cards)
    {
        $response = [];
        $response[] =  current($cards);

        return $this->getResponse('High card', 1, $this->getRank($response), $response);
    }
}
