<?php

namespace AdventOfCode\Year2015\Day02;

use AdventOfCode\Year2015\Fixture;
use AdventOfCode\Year2015\TestCase;

class Fixtures implements Fixture
{
    public function getCases(): array
    {
        $cases = [];

        //case X
        $case = new TestCase();
        $case->setVariation(TestCase::VARIATION_SILVER);
        $case->setInputFileName('Fixture01.txt');
        $case->setExpected(58);
        $cases[] = $case;

        //case X
        $case = new TestCase();
        $case->setVariation(TestCase::VARIATION_SILVER);
        $case->setInputFileName('Fixture02.txt');
        $case->setExpected(43);
        $cases[] = $case;

        //case X
        $case = new TestCase();
        $case->setVariation(TestCase::VARIATION_SILVER);
        $case->setInputFileName('Fixture03.txt');
        $case->setExpected(101);
        $cases[] = $case;

        //case X
        $case = new TestCase();
        $case->setVariation(TestCase::VARIATION_GOLD);
        $case->setInputFileName('Fixture01.txt');
        $case->setExpected(34);
        $cases[] = $case;

        //case X
        $case = new TestCase();
        $case->setVariation(TestCase::VARIATION_GOLD);
        $case->setInputFileName('Fixture02.txt');
        $case->setExpected(14);
        $cases[] = $case;

        //case X
        $case = new TestCase();
        $case->setVariation(TestCase::VARIATION_GOLD);
        $case->setInputFileName('Fixture03.txt');
        $case->setExpected(48);
        $cases[] = $case;

        return $cases;
    }
}
