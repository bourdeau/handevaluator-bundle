Feature: Winner Finder
    The aim is to find a winner between poker players.

    Scenario: a dead heat
        Given the following players and cards:
            | player_name | cards                      |
            | John        | AH, 3S, QS, JH, 5D, KH, 2H |
            | David       | AS, 3D, QS, JH, 5D, KH, 2H |
            | Robert      | AD, 3C, QS, JH, 5D, KH, 2H |
        Then the players "John", "David" and "Robert" are equal with "High card"

    Scenario: Robert wins with a Three of a Kind
        Given the following players and cards:
            | player_name | cards                      |
            | John        | QH, 2S, QS, JH, 5D, KH, 2H |
            | David       | 9S, 2D, QS, JH, 5D, KH, 2H |
            | Robert      | QD, QC, QS, JH, 5D, KH, 2H |
        Then the player "Robert" should win with a "Three of a kind"

    Scenario: Robert wins with a Three of a Kind
        Given the following players and cards:
            | player_name | cards                       |
            | Martin      | JH, 10S, 5D, KH, 2H, 2C, QD |
            | Smith       | 9C, QS, 5D, KH, 2H, 2C, QD  |
        Then the player "Smith" should win with a "Two Pairs"
