<?php

namespace AdventOfCode\Year2024\Day11;

use AdventOfCode\Year2024\Fixture;
use AdventOfCode\Year2024\TestCase;

class Fixtures implements Fixture
{
    public function getCases(): \Generator
    {
        //case X
        $case = new TestCase();
        $case->setVariation(TestCase::VARIATION_SILVER);
        $case->setInputFileName('Fixture01.txt');
        $case->setExpected('55312');
        yield $case;

        //case X
        $case = new TestCase();
        $case->setVariation(TestCase::VARIATION_GOLD);
        $case->setInputFileName('Fixture01.txt');
        $case->setExpected('');
        yield $case;
    }
}
