Feature: HandEvaluator
    I have some poker cards and I want to know if I have a valid poker hand
    If I have one, I need to know it's name and it's rank. I also need to get
    the cards that constitue the hand back.

    Scenario: Find a Royal Flush
        Given I have the following cards:
            | AS | KS | QS | JS | 10S | 9S | 8S |
        Then I should get a "Royal Flush" with a rank "13" with the following cards:
            | AS | KS | QS | JS | 10S |

    Scenario: Find a Straight Flush
        Given I have the following cards:
            |QS| JS | 10S | 9S | 8S | 7C | 2C |
        Then I should get a "Straight Flush" with a rank "11" with the following cards:
            |QS| JS | 10S | 9S | 8S |
