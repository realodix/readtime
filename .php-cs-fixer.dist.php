<?php

use Realodix\CsConfig\Config;
use Realodix\CsConfig\Finder;
use Realodix\CsConfig\Rules\Realodix;

$localRules = [
    // Realodix
    'binary_operator_spaces' => [
        'operators' => [
            '=>' => 'align_single_space',
            '='  => 'single_space', ],
    ],
];

$finder = Finder::base(__DIR__)
    ->append(['.php-cs-fixer.dist.php']);

return Config::create(new Realodix($localRules))
    ->setFinder($finder);
