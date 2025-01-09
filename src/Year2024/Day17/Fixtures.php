<?php

namespace AdventOfCode\Year2024\Day17;

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
        $case->setExpected('a:0, b:0, c:0, r: 4,6,3,5,6,3,5,2,1,0');
        yield $case;

        //case X
        $case = new TestCase();
        $case->setVariation(TestCase::VARIATION_SILVER);
        $case->setInputFileName('Fixture02.txt');
        $case->setExpected('a:0, b:1, c:9, r: ');
        yield $case;

        //case X
        $case = new TestCase();
        $case->setVariation(TestCase::VARIATION_SILVER);
        $case->setInputFileName('Fixture03.txt');
        $case->setExpected('a:10, b:0, c:0, r: 0,1,2');
        yield $case;

        //case X
        $case = new TestCase();
        $case->setVariation(TestCase::VARIATION_SILVER);
        $case->setInputFileName('Fixture04.txt');
        $case->setExpected('a:0, b:0, c:0, r: 4,2,5,6,7,7,7,7,3,1,0');
        yield $case;

        //case X
        $case = new TestCase();
        $case->setVariation(TestCase::VARIATION_SILVER);
        $case->setInputFileName('Fixture05.txt');
        $case->setExpected('a:0, b:26, c:0, r: ');
        yield $case;

        //case X
        $case = new TestCase();
        $case->setVariation(TestCase::VARIATION_SILVER);
        $case->setInputFileName('Fixture06.txt');
        $case->setExpected('a:0, b:44354, c:43690, r: ');
        yield $case;

        //case X
        $case = new TestCase();
        $case->setVariation(TestCase::VARIATION_GOLD);
        $case->setInputFileName('Fixture01.txt');
        $case->setExpected('');
        yield $case;
    }
}
