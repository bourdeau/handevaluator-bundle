Feature: HandEvaluator
    I have some poker cards and I want to know if I have a valid poker hand.
    If I have one, I need to know it's name and it's rank. I also need to get
    the cards that constitue the hand back.

    Scenario: Find a Royal Flush
        Given I have the following cards:
            | AS | KS | QS | JS | 10S | 9S | 8S |
        Then I should get a "Royal Flush" with a rank "13" with the following cards:
            | AS | KS | QS | JS | 10S |

    Scenario: Find a Straight Flush
        Given I have the following cards:
            | QS | JS | 10S | 9S | 8S | 7C | 2C |
        Then I should get a "Straight Flush" with a rank "11" with the following cards:
            | QS | JS | 10S | 9S | 8S |

    Scenario: Find a Four of a kind
        Given I have the following cards:
            | 5D | 5H | 5C | 5S | 9H | KC | JD |
        Then I should get a "Four of a kind" with a rank "4" with the following cards:
            | 5D | 5H | 5C | 5S |

    Scenario: Find a Full House
        Given I have the following cards:
            | 2S | 2D | 2C | QH | QS | JD | KC |
        Then I should get a "Full House" with a rank "1" with the following cards:
            | 2S | 2D | 2C | QH | QS |

    Scenario: Find a Flush
        Given I have the following cards:
            | 9C | 8C | 7C | 5C | 4C | 9H | 5H |
        Then I should get a "Flush" with a rank "8" with the following cards:
            | 9C | 8C | 7C | 5C | 4C |
