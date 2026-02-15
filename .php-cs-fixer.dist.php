<?php

use Realodix\Relax\Config;
use Realodix\Relax\Finder;

$rules = [
    '@Realodix/Relax' => true,
];

return Config::this()
    ->setFinder(Finder::base()->in(__DIR__))
    ->setRules($rules)
    ->setCacheFile(__DIR__.'/.tmp/.php-cs-fixer.cache');
