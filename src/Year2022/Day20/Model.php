<?php

namespace AdventOfCode\Year2022\Day20;

class Model
{
    private Model $left;
    private Model $right;
    private int $number;

    /**
     * @return Model
     */
    public function getLeft(): Model
    {
        return $this->left;
    }

    /**
     * @param Model $left
     */
    public function setLeft(Model $left): void
    {
        $this->left = $left;
    }

    /**
     * @return Model
     */
    public function getRight(): Model
    {
        return $this->right;
    }

    /**
     * @param Model $right
     */
    public function setRight(Model $right): void
    {
        $this->right = $right;
    }

    /**
     * @return int
     */
    public function getNumber(): int
    {
        return $this->number;
    }

    /**
     * @param int $number
     */
    public function setNumber(int $number): void
    {
        $this->number = $number;
    }
}
