<?php

namespace AdventOfCode\Year2023;

interface Fixture
{
    /**
     * @return TestCase[]
     */
    public function getCases(): \Generator;
}
