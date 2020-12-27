<?php

namespace AdventOfCode\Year2020\Day23;

class Model
{
    /** @var int */
    public $number;

    /** @var Model */
    public $next;

    public function print($int, $iter)
    {
        if ($int !== $this->number || $iter === 0) {
            $iter++;
            return $this->number . $this->next->print($int, $iter);
        }
    }
}
