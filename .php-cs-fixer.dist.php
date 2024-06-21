<?php

use Realodix\Relax\Config;
use Realodix\Relax\Finder;
use Realodix\Relax\RuleSet\Sets\Realodix;

$localRules = [
    // Realodix
    'binary_operator_spaces' => [
        'operators' => [
            '=>' => 'align_single_space',
            '='  => 'single_space', ],
    ],
];

$finder = Finder::base()
    ->append(['.php-cs-fixer.dist.php']);

return Config::create(new Realodix, $localRules)
    ->setFinder($finder);
