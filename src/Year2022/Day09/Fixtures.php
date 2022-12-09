<?php

namespace AdventOfCode\Year2022\Day09;

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
        $case->setExpected(13);
        yield $case;

        //case X
        $case = new TestCase();
        $case->setVariation(TestCase::VARIATION_GOLD);
        $case->setInputFileName('Fixture01.txt');
        $case->setExpected(1);
        yield $case;

        $case = new TestCase();
        $case->setVariation(TestCase::VARIATION_GOLD);
        $case->setInputFileName('Fixture02.txt');
        $case->setExpected(36);
        yield $case;
    }
}
