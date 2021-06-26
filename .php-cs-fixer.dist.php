<?php

use Realodix\CsConfig\Factory;
use Realodix\CsConfig\RuleSet;

$overrideRules = [
    // ..
];

return Factory::fromRuleSet(new RuleSet\RealodixPlus, $overrideRules);
