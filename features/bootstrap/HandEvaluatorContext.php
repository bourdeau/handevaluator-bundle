<?php

use Behat\Behat\Tester\Exception\PendingException;
use Behat\Behat\Context\Context;
use Behat\Behat\Context\SnippetAcceptingContext;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;

use Bourdeau\Bundle\HandEvaluatorBundle\HandEvaluator\HandFinder;
use Bourdeau\Bundle\HandEvaluatorBundle\HandEvaluator\CardValidator;
use Bourdeau\Bundle\HandEvaluatorBundle\HandEvaluator\WinnerFinder;

/**
 * Defines application features from the specific context.
 */
class HandEvaluatorContext implements Context, SnippetAcceptingContext
{
    private $winnerFinder;
    private $handFinder;
    private $cards;
    private $players;

    /**
     * Initializes context.
     *
     * Every scenario gets its own context instance.
     * You can also pass arbitrary arguments to the
     * context constructor through behat.yml.
     */
    public function __construct()
    {
        $this->handFinder = new HandFinder(new CardValidator());
        $this->winnerFinder = new WinnerFinder($this->handFinder);
    }

    /**
     * @Given I have the following cards:
     */
    public function iHaveTheFollowingCards(TableNode $table)
    {
        $this->cards = [];
        $this->cards = $table->getRow(0);
    }

    /**
     * @Then I should get a :arg1 with a rank :arg2 with the following cards:
     */
    public function iShouldGetAWithARankWithTheFollowingCards($arg1, $arg2, TableNode $table)
    {
        $expectedCards = $table->getRow(0);
        $result = $this->handFinder->findHand($this->cards);
        PHPUnit_Framework_Assert::assertContains($arg1, $result);
        PHPUnit_Framework_Assert::assertContains($arg2, $result);

        foreach ($expectedCards as $expectedCard) {
                PHPUnit_Framework_Assert::assertContains($expectedCard, $result['cards']);
        }
    }

    /**
     * @Then I should get an error
     */
    public function iShouldGetAnError()
    {
        try {
            $this->handFinder->findHand($this->cards);
        } catch(\Exception $e) {
            PHPUnit_Framework_Assert::assertEquals("The card AX is not in a valid format!", $e->getMessage());
        }
    }

    /**
     * @Given the following players and cards:
     */
    public function theFollowingPlayersAndCards(TableNode $table)
    {
        $this->players = [];

        foreach ($table as $key => $value) {
            $this->players[$value['player_name']] = explode(", ", $value['cards']);;
        }
    }

    /**
     * @Then the player :arg1 should win with a :arg2
     */
    public function thePlayerShouldWinWithA($arg1, $arg2)
    {
        $winners =$this->winnerFinder->findAWinner($this->players);
        PHPUnit_Framework_Assert::assertEquals($arg1, key($winners['winners']));
        PHPUnit_Framework_Assert::assertEquals($arg2, current($winners['winners'])['hand_name']);
    }

    /**
     * @Then the players :arg1, :arg2 and :arg3 are equal with :arg4
     */
    public function thePlayersAndAreEqualWith($arg1, $arg2, $arg3, $arg4)
    {
        $winners =$this->winnerFinder->findAWinner($this->players);
        PHPUnit_Framework_Assert::assertArrayHasKey($arg1, $winners['winners']);
        PHPUnit_Framework_Assert::assertEquals($arg4, $winners['winners'][$arg1]['hand_name']);
        PHPUnit_Framework_Assert::assertArrayHasKey($arg2, $winners['winners']);
        PHPUnit_Framework_Assert::assertEquals($arg4, $winners['winners'][$arg2]['hand_name']);
        PHPUnit_Framework_Assert::assertArrayHasKey($arg3, $winners['winners']);
        PHPUnit_Framework_Assert::assertEquals($arg4, $winners['winners'][$arg3]['hand_name']);
    }
}
