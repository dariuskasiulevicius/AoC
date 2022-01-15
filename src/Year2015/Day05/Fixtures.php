<?php

namespace AdventOfCode\Year2015\Day05;

use AdventOfCode\Year2015\Fixture;
use AdventOfCode\Year2015\TestCase;

class Fixtures implements Fixture
{
    public function getCases(): array
    {
        return [
            [
                TestCase::VARIATION_SILVER,
                'Fixture01.txt',
                '1',
            ],
            [
                TestCase::VARIATION_SILVER,
                'Fixture02.txt',
                '1',
            ],
            [
                TestCase::VARIATION_SILVER,
                'Fixture03.txt',
                '0',
            ],
            [
                TestCase::VARIATION_SILVER,
                'Fixture04.txt',
                '0',
            ],
            [
                TestCase::VARIATION_SILVER,
                'Fixture05.txt',
                '0',
            ],
            [
                TestCase::VARIATION_GOLD,
                'Fixture06.txt',
                '1',
            ],
            [
                TestCase::VARIATION_GOLD,
                'Fixture07.txt',
                '1',
            ],
            [
                TestCase::VARIATION_GOLD,
                'Fixture08.txt',
                '0',
            ],
            [
                TestCase::VARIATION_GOLD,
                'Fixture09.txt',
                '0',
            ],
        ];
    }
}
