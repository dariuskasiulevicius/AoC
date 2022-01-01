<?php

namespace AdventOfCode\Year2015;

interface Fixture
{
    /**
     * @return TestCase[]
     */
    public function getCases(): array;
}
