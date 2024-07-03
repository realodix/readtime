<?php

use Realodix\Relax\Config;
use Realodix\Relax\Finder;

$localRules = [
    //
];

$finder = Finder::base()
    ->append(['.php-cs-fixer.dist.php']);

return Config::create('realodix')
    // ->setRules($localRules)
    ->setFinder($finder);
