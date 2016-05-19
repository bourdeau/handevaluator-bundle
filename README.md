
[![Build Status](https://travis-ci.org/bourdeau/handevaluator-bundle.svg?branch=master)](https://travis-ci.org/bourdeau/handevaluator-bundle) [![Dependency Status](https://www.versioneye.com/user/projects/573d8c62ce8d0e004130bde4/badge.svg?style=flat)](https://www.versioneye.com/user/projects/573d8c62ce8d0e004130bde4) [![Code Climate](https://codeclimate.com/github/bourdeau/handevaluator-bundle/badges/gpa.svg)](https://codeclimate.com/github/bourdeau/handevaluator-bundle) [![Test Coverage](https://codeclimate.com/github/bourdeau/handevaluator-bundle/badges/coverage.svg)](https://codeclimate.com/github/bourdeau/handevaluator-bundle/coverage) [![Issue Count](https://codeclimate.com/github/bourdeau/handevaluator-bundle/badges/issue_count.svg)](https://codeclimate.com/github/bourdeau/handevaluator-bundle)


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
$handFinder = $this->container->get('bourdeau_bundle_hand_evaluator.handfinder');
$cards = ['AC', '2D', '3H', '4H', '5S', 'KS', '10D'];

$result = $handFinder->findHand($cards);

// $result will output:
[
  ["hand_name"]=> "Straight"
  ["rank"]=> 6
  ["cards"]=> [
      "AC",
      "5S",
      "4H",
      "3H",
      "2D"
  ]
]
```
