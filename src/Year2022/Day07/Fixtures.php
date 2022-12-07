<?php

namespace AdventOfCode\Year2022\Day07;

use AdventOfCode\Year2022\Fixture;
use AdventOfCode\Year2022\TestCase;

class Fixtures implements Fixture
{
    public function getCases(): \Generator
    {
        //case X
        $case = new TestCase();
        $case->setVariation(TestCase::VARIATION_SILVER);
        $case->setInputFileName('Fixture01.txt');
        $case->setExpected(95437);
        yield $case;

        //case X
        $case = new TestCase();
        $case->setVariation(TestCase::VARIATION_GOLD);
        $case->setInputFileName('Fixture01.txt');
        $case->setExpected(24933642);
        yield $case;
    }
}
