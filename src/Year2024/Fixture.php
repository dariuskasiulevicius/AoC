<?php

namespace AdventOfCode\Year2024;

interface Fixture
{
    /**
     * @return TestCase[]
     */
    public function getCases(): \Generator;
}
