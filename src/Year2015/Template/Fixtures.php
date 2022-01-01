<?php

namespace {{{namespace}}};

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
        $case->setExpected();
        $cases[] = $case;

        return $cases;
    }
}
