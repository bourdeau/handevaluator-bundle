
[![Build Status](https://travis-ci.org/bourdeau/handevaluator-bundle.svg?branch=master)](https://travis-ci.org/bourdeau/handevaluator-bundle) [![Dependency Status](https://www.versioneye.com/user/projects/573d8c62ce8d0e004130bde4/badge.svg?style=flat)](https://www.versioneye.com/user/projects/573d8c62ce8d0e004130bde4) [![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/bourdeau/handevaluator-bundle/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/bourdeau/handevaluator-bundle/?branch=master) [![Code Coverage](https://scrutinizer-ci.com/g/bourdeau/handevaluator-bundle/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/bourdeau/handevaluator-bundle/?branch=master) [![Latest Stable Version](https://poser.pugx.org/bourdeau/handevaluator-bundle/v/stable)](https://packagist.org/packages/bourdeau/handevaluator-bundle) [![Total Downloads](https://poser.pugx.org/bourdeau/handevaluator-bundle/downloads)](https://packagist.org/packages/bourdeau/handevaluator-bundle) [![Latest Unstable Version](https://poser.pugx.org/bourdeau/handevaluator-bundle/v/unstable)](https://packagist.org/packages/bourdeau/handevaluator-bundle) [![License](https://poser.pugx.org/bourdeau/handevaluator-bundle/license)](https://packagist.org/packages/bourdeau/handevaluator-bundle)


Poker Hand Evaluator Bundle
========

About Poker Hand Evaluator Bundle
---------------

Hand Evaluator Bundle is a PHP 5.6+ library providing services to evaluate Texas hold'em Poker Hands.

Installation
------------

## Prerequisites

A Symfony3 project

## With composer

This bundle can be installed using [composer](http://getcomposer.org) by adding the following in the `require` section of your `composer.json` file:

``` json
    "require": {
        ...
        "bourdeau/handevaluator-bundle": "~0.1"
    },
```

## Register the bundle

You must register the bundle in your kernel:

``` php
<?php

// app/AppKernel.php

public function registerBundles()
{
    $bundles = [
        // ...
        new Bourdeau\Bundle\HandEvaluatorBundle\BourdeauBundleHandEvaluatorBundle(),
    ];
    // ...
}
```

Configuration
-------------
There is no configuration for now.


Usage Example
-------------
``` php
<?php
// Path/To/Your/Controller
$winnerFinder = $this->container->get('bourdeau_bundle_hand_evaluator.winnerfinder');
$players = [
    'John'   => [QH, 2S, QS, JH, 5D, KH, 2H],
    'David'  => [9S, 2D, QS, JH, 5D, KH, 2H],
    'Robert' => [QD, QC, QS, JH, 5D, KH, 2H],
]

$result = $handFinder->findAWinner($players);

// $result will output:
│ array(2) {
│   ["winners"]=>
│   array(1) {
│     ["Robert"]=>
│     array(4) {
│       ["hand_name"]=>
│       string(15) "Three of a kind"
│       ["hand_rank"]=>
│       int(4)
│       ["card_rank"]=>
│       int(11)
│       ["cards"]=>
│       array(3) {
│         [0]=>
│         string(2) "QD"
│         [1]=>
│         string(2) "QC"
│         [2]=>
│         string(2) "QS"
│       }
│     }
│   }
│   ["other_players"]=>
│   array(2) {
│     ["John"]=>
│     array(4) {
│       ["hand_name"]=>
│       string(9) "Two Pairs"
│       ["hand_rank"]=>
│       int(3)
│       ["card_rank"]=>
│       int(11)
│       ["cards"]=>
│       array(4) {
│         [0]=>
│         string(2) "QH"
│         [1]=>
│         string(2) "QS"
│         [2]=>
│         string(2) "2S"
│         [3]=>
│         string(2) "2H"
│       }
│     }
│     ["David"]=>
│     array(4) {
│       ["hand_name"]=>
│       string(8) "One Pair"
│       ["hand_rank"]=>
│       int(2)
│       ["card_rank"]=>
│       int(1)
│       ["cards"]=>
│       array(2) {
│         [0]=>
│         string(2) "2D"
│         [1]=>
│         string(2) "2H"
│       }
│     }
│   }
│ }

```
