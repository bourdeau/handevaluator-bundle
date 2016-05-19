<?php

use Behat\Behat\Tester\Exception\PendingException;
use Behat\Behat\Context\Context;
use Behat\Behat\Context\SnippetAcceptingContext;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;

use Bourdeau\Bundle\HandEvaluatorBundle\HandEvaluator\HandFinder;
use Bourdeau\Bundle\HandEvaluatorBundle\HandEvaluator\CardValidator;

/**
 * Defines application features from the specific context.
 */
class HandEvaluatorContext implements Context, SnippetAcceptingContext
{
    private $handFinder;
    private $cards;

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
}
