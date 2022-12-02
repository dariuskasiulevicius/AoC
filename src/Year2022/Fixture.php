<?php

namespace AdventOfCode\Year2022;

interface Fixture
{
    /**
     * @return TestCase[]
     */
    public function getCases(): \Generator;
}
