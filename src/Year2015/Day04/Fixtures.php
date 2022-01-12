<?php

namespace AdventOfCode\Year2015\Day04;

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
        $case->setExpected('609043');
        $cases[] = $case;

        //case X
        $case = new TestCase();
        $case->setVariation(TestCase::VARIATION_SILVER);
        $case->setInputFileName('Fixture02.txt');
        $case->setExpected('1048970');
        $cases[] = $case;

        return $cases;
    }
}
