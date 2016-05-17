<?php

namespace Bourdeau\Bundle\HandEvaluatorBundle\Services;

/**
 * Hand Evaluator.
 */
class HandEvaluator
{
    private $cardValidator;

    public function __construct($cardValidator)
    {
        $this->cardValidator = $cardValidator;
    }

    /**
     * The main class method.
     *
     * @param array $cards
     *
     * @return string
     */
    public function findHands(array $cards)
    {
        if (!$this->cardValidator->areValid($cards)) {
            throw new \Exception('Your cards are not valid');
        }

        return $this->findSuite($cards);
    }

    /**
     * Will return the best card conbinaison with the given cards.
     *
     * @param array $cards
     *
     * @return string
     */
    private function findSuite(array $cards)
    {

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
        if ($res = $this->isTwoPair($cards)) {
            return $res;
        }
        if ($res = $this->isOnePair($cards)) {
            return $res;
        }
        if ($res = $this->isHighCard($cards)) {
            return $res;
        }

        throw new \Exception("Couldn't find a suite!");
    }

    private function sortCards(array $cards)
    {
        $data = [];

        foreach ($cards as $card) {
            if (substr($card, 0, -1) == 'A') {
                $data[1] = $card;
            }
            if (substr($card, 0, -1) == 'K') {
                $data[2] = $card;
            }
            if (substr($card, 0, -1) == 'Q') {
                $data[3] = $card;
            }
            if (substr($card, 0, -1) == 'J') {
                $data[4] = $card;
            }
            if (substr($card, 0, 2) == '10') {
                $data[5] = $card;
            }
            if (substr($card, 0, -1) == '9') {
                $data[6] = $card;
            }
            if (substr($card, 0, -1) == '8') {
                $data[7] = $card;
            }
            if (substr($card, 0, -1) == '7') {
                $data[8] = $card;
            }
            if (substr($card, 0, -1) == '6') {
                $data[9] = $card;
            }
            if (substr($card, 0, -1) == '5') {
                $data[10] = $card;
            }
            if (substr($card, 0, -1) == '4') {
                $data[11] = $card;
            }
            if (substr($card, 0, -1) == '3') {
                $data[12] = $card;
            }
            if (substr($card, 0, -1) == '2') {
                $data[13] = $card;
            }
        }

        ksort($data);

        return $data;
    }

    private function getRank(array $cards)
    {
        $card = current($cards);

        if (substr($card, 0, -1) == 'A') {
            return 13;
        }
        if (substr($card, 0, -1) == 'K') {
            return 12;
        }
        if (substr($card, 0, -1) == 'Q') {
            return 11;
        }
        if (substr($card, 0, -1) == 'J') {
            return 10;
        }
        if (substr($card, 0, 2) == '10') {
            return 9;
        }
        if (substr($card, 0, -1) == '9') {
            return 8;
        }
        if (substr($card, 0, -1) == '8') {
            return 7;
        }
        if (substr($card, 0, -1) == '7') {
            return 6;
        }
        if (substr($card, 0, -1) == '6') {
            return 5;
        }
        if (substr($card, 0, -1) == '5') {
            return 4;
        }
        if (substr($card, 0, -1) == '4') {
            return 3;
        }
        if (substr($card, 0, -1) == '3') {
            return 2;
        }
        if (substr($card, 0, -1) == '2') {
            return 1;
        }

        throw new \Exception(sprintf('No rank found for card %s'), $card);
    }

    private function getResponse($figureName, $rank, array $response)
    {
        return [
            'figure' => $figureName,
            'rank'   => (int) $rank,
            'cards'  => $response,
        ];
    }

    /**
     * Return cards figures.
     *
     * @param array $cards
     *
     * @return array
     */
    private function getFigures(array $cards)
    {
        $figures = [];

        foreach ($cards as $card) {
            $figures[] = substr($card, 0, -1);
        }

        return $figures;
    }

    /**
     * Return the cards colors.
     *
     * @param array $cards
     *
     * @return array
     */
    private function getColors(array $cards)
    {
        $colors = [];

        foreach ($cards as $card) {
            $colors[] = substr($card, -1);
        }

        return $colors;
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
                    break;
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
                return $this->getResponse("Royal Flush", $this->getRank($value), $value);
            }
        }

        return false;
    }

    /**
     * Return an array if the cards are a Straight Flush
     * otherwise return false
     *
     * @param array $cards
     *
     * @return array|bool
     */
    private function isStraightFlush(array $cards)
    {
        if ($straightCards = $this->isStraight($cards)) {
            if ($straightFlushCards = $this->isFlush($straightCards['cards'])) {
                return $this->getResponse("Straight Flush", $straightFlushCards['rank'], $straightFlushCards['cards']);
            }
        }

        return false;
    }

    /**
     * Return an array if the cards are a Four of a Kind
     * otherwise return false
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
                return $this->getResponse("Four of a kind", $this->getRank($groupedFaces), $groupedFaces);
            }
        }

        return false;
    }

    /**
    * Return an array if the cards are a Full House
    * otherwise return false
     *
     * @param array $cards
     *
     * @return array|bool
     */
    private function isFullHouse(array $cards)
    {
        $faces = $this->findMultipleFaceCards($cards);
        dump($faces);
        $condition = 0;
        $res = [];

        foreach ($faces as $face => $groupedFaces) {
            if (count($groupedFaces) == 3 || count($groupedFaces) == 2) {
                foreach ($groupedFaces as $value) {
                    $res[] = $value;
                }
                $condition++;
            }
        }
        // Fuck! Pick up highest ranked card as you can end up having to choose
        // for a Full House (e.g. 'QD', 'QS', 'QC', 'KH', 'KS', 'JD', 'JS')
        dump($condition);
        die;
        if ($condition == 2) {
            return $this->getResponse("Full House", $this->getRank($res), $res);
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
            if ($color == 'S') {
                $colors['S'][] = $card;
            } elseif ($color == 'D') {
                $colors['D'][] = $card;
            } elseif ($color == 'C') {
                $colors['C'][] = $card;
            } elseif ($color == 'H') {
                $colors['H'][] = $card;
            } else {
                throw new \Exception(sprintf("The color %s doesn't exist!", $color));
            }
        }

        foreach ($colors as $color => $groupedCards) {
            if (count($groupedCards) == 5) {
                $flushCards = $this->sortCards($groupedCards);
                return $this->getResponse("Flush", $this->getRank($flushCards), $flushCards);
            }
        }

        return false;
    }

    /**
     * Return false if the cards are not a Straight
     * otherwise it returns an array.
     *
     * @param array $cards
     *
     * @return array|bool
     */
    private function isStraight(array $cards)
    {
        $cards = $this->sortCards($cards);

        $prev = 0;
        $response = [];

        foreach ($cards as $key => $value) {
            if (array_key_exists($key + 1, $cards) || $key == $prev + 1) {
                $response[$key] = $value;
            } else {
                $response = [];
            }

            $prev = $key;

            if (count($response) == 5) {
                return $this->getResponse("Straight", $this->getRank($response), $response);
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
        $data = array_count_values($this->getFigures($cards));

        if (in_array(3, $data)) {
            return true;
        }

        return false;
    }

    private function isTwoPair($cards)
    {
        $data = array_count_values($this->getFigures($cards));

        dump(in_array(2, $data));

        if (in_array(2, $data) && !in_array(3, $data) && !in_array(4, $data)) {
            return true;
        }

        return false;
    }

    private function isOnePair()
    {
    }
    private function isHighCard()
    {
    }
}