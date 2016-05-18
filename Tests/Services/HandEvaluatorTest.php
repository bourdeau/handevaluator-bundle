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
        $cards = [
            '13' => ['AS', 'KS', 'QS', 'JS', '10S', '9S', '8S'],
            '13' => ['AD', 'KD', 'QD', 'JD', '10D', '9D', '8D'],
            '13' => ['AC', 'KC', 'QC', 'JC', '10C', '9C', '8C'],
            '13' => ['AH', 'KH', 'QH', 'JH', '10H', '9H', '8H'],
        ];
        $this->runValidTest("Royal Flush", 5, $cards);

        // Test Straight Flush
        $cards = [
            '12' => ['KS', 'QS', 'JS', '10S', '9S', '8H', '7D'],
            '11' => ['QS', 'JS', '10S', '9S', '8S', '7C', '2C'],
        ];
        $this->runValidTest("Straight Flush", 5, $cards);

        // Test Four of a kind
        $cards = [
            '12' => ['KS', 'KD', 'KC', 'KH', '9S', '8S', '7D'],
        ];
        $this->runValidTest("Four of a kind", 4, $cards);

        // Test Full House
        $cards = [
            '12' => ['KS', 'KD', 'KC', 'QD', 'QC', '8S', '7D'],
            '13' => ['AD', 'AC', 'AH', '9D', '9H', '9C', 'JS'],
        ];
        $this->runValidTest("Full House", 5, $cards);

        // Test Flush
        $cards = [
            '9' => ['10H', '8H', '7H', '3H', '5H', '8C', '7D'],
            '8' => ['9D', '8D', '4D', '3D', '5D', '8C', '2H'],
        ];
        $this->runValidTest("Flush", 5, $cards);

        // Test Straight
        $cards = [
            '6'  => ['7H', '6S', '5H', '4C', '3H', 'JC', 'AD'],
            '9'  => ['10S', '9C', '8H', '7D', '6S', 'QC', '2D'],
            '10' => ['JC', '10H', '9D', '8C', '7S', '5H', '3H'],
            '12' => ['KD', 'QC', 'JS', '10S', '9S', '6H', '3D'],
            '7'  => ['8S', '7C', '6C', '5H', '4H', 'JC', '10H'],
            '6'  => ['AC', '2D', '3H', '4H', '5S', 'KS', '10D'], // straight from bottom
        ];
        $this->runValidTest("Straight", 5, $cards);

        // Test Three of a kind
        $cards = [
            '11'  => ['QS', 'QC', 'QD', 'JS', '6S', '7D', '9S'],
        ];
        $this->runValidTest("Three of a kind", 3, $cards);

        // Test Three of a kind
        $cards = [
            '9'  => ['10C', '10H', '2H', '2S', 'JC', '6C', '9D'],
        ];
        $this->runValidTest("Two Pairs", 4, $cards);

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
