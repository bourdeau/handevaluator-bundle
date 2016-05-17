<?php
namespace Bourdeau\Bundle\HandEvaluatorBundle\Test\Services;

use Bourdeau\Bundle\HandEvaluatorBundle\Services\HandEvaluator;

/**
 * Class HandEvaluatorTest
 */
class HandEvaluatorTest extends \PHPUnit_Framework_TestCase
{
    private $handEvaluator;

    /**
     * {@inheritDoc}
     */
    protected function setUp()
    {
        $cardValidator = $this->getMock('Bourdeau\Bundle\HandEvaluatorBundle\Services\CardValidator');

        $cardValidator->expects($this->any())
                      ->method('areValid')
                      ->willReturn(true);

        $this->handEvaluator = new HandEvaluator($cardValidator);
    }

    public function testFindHands()
    {
        // Test Royal Flush
        $validRoyalFlush = [
            '13' => ['AS', 'KS', 'QS', 'JS', '10S', '9S', '8S'],
            '13' => ['AD', 'KD', 'QD', 'JD', '10D', '9D', '8D'],
            '13' => ['AC', 'KC', 'QC', 'JC', '10C', '9C', '8C'],
            '13' => ['AH', 'KH', 'QH', 'JH', '10H', '9H', '8H'],
        ];
        $this->runValidTest("Royal Flush", 5, $validRoyalFlush);

        // Test Royal Flush
        $validStraightFlush = [
            '12' => ['KS', 'QS', 'JS', '10S', '9S', '8S', '7D'],
            '11' => ['QS', 'JS', '10S', '9S', '8S', '7S', '2C'],
        ];
        $this->runValidTest("Straight Flush", 5, $validStraightFlush);

        // Test Royal Flush
        $validFourOfAKind = [
            '12' => ['KS', 'KD', 'KC', 'KH', '9S', '8S', '7D'],
        ];
        $this->runValidTest("Four of a kind", 4, $validFourOfAKind);

        // Test Full House
        $validFullHouse = [
            '12' => ['KS', 'KD', 'KC', 'QD', 'QC', '8S', '7D'],
        ];
        $this->runValidTest("Full House", 5, $validFullHouse);

        // Test Flush
        $validFlush = [
            '12' => ['10H', '8H', '7H', '3H', '5H', '8C', '7D'],
            '8' => ['9D', '8D', '4D', '3D', '5D', '8C', '2H'],
        ];
        $this->runValidTest("Flush", 9, $validFlush);

    }

    private function runValidTest($handName, $nbCard, array $arrayCards)
    {
        foreach ($arrayCards as $rank => $cards) {
            shuffle($cards);

            $test = $this->handEvaluator->findHands($cards);

            $this->assertInternalType("array", $test);
            $this->assertEquals($handName, $test["hand_name"]);
            $this->assertEquals($rank, $test["rank"]);
            $this->assertInternalType("array", $test["cards"]);
            $this->assertEquals($nbCard, count($test["cards"]));
        }
    }
}
