<?php

namespace AdventOfCode\Year2015\Day03;

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
        $case->setExpected('2');
        $cases[] = $case;

        //case X
        $case = new TestCase();
        $case->setVariation(TestCase::VARIATION_SILVER);
        $case->setInputFileName('Fixture02.txt');
        $case->setExpected('4');
        $cases[] = $case;

        //case X
        $case = new TestCase();
        $case->setVariation(TestCase::VARIATION_SILVER);
        $case->setInputFileName('Fixture03.txt');
        $case->setExpected('2');
        $cases[] = $case;

        //case X
        $case = new TestCase();
        $case->setVariation(TestCase::VARIATION_GOLD);
        $case->setInputFileName('Fixture04.txt');
        $case->setExpected('3');
        $cases[] = $case;

        //case X
        $case = new TestCase();
        $case->setVariation(TestCase::VARIATION_GOLD);
        $case->setInputFileName('Fixture02.txt');
        $case->setExpected('3');
        $cases[] = $case;

        //case X
        $case = new TestCase();
        $case->setVariation(TestCase::VARIATION_GOLD);
        $case->setInputFileName('Fixture03.txt');
        $case->setExpected('11');
        $cases[] = $case;

        return $cases;
    }
}
