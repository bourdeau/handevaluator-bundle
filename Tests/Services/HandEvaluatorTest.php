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
        $cards = ['AS', 'KS', 'QS', 'JS', '10S', '9S', '8S'];

        $test = $this->handEvaluator->findHands($cards);
        $this->assertInternalType("array", $test);
        $this->assertEquals("Royal Flush", $test["figure"]);
        $this->assertEquals(13, $test["rank"]);
        $this->assertInternalType("array", $test["cards"]);
        $this->assertEquals(5, count($test["cards"]));
    }

}
