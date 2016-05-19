Feature: Winner Finder
    The aim is to find a winner between poker players.

    Scenario: Find a winner
        Given John has the following cards:
            | QH | 2S | QS | JH | 5D | KH | 2H |
        And David has the following cards:
            | 9S | 2D | QS | JH | 5D | KH | 2H |
        Then John should win
