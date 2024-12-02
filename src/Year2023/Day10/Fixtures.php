<?php

namespace AdventOfCode\Year2023\Day10;

use AdventOfCode\Year2023\Fixture;
use AdventOfCode\Year2023\TestCase;

class Fixtures implements Fixture
{
    public function getCases(): \Generator
    {
        //case X
        $case = new TestCase();
        $case->setVariation(TestCase::VARIATION_SILVER);
        $case->setInputFileName('Fixture01.txt');
        $case->setExpected(8);
        yield $case;

        //case X
        $case = new TestCase();
        $case->setVariation(TestCase::VARIATION_GOLD);
        $case->setInputFileName('Fixture02.txt');
        $case->setExpected(8);
        yield $case;

        //case X
        $case = new TestCase();
        $case->setVariation(TestCase::VARIATION_GOLD);
        $case->setInputFileName('Fixture03.txt');
        $case->setExpected(10);
        yield $case;
    }
}
