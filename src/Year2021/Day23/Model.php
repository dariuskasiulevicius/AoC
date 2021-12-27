<?php

namespace AdventOfCode\Year2021\Day23;

class Model
{
    const Model_A = 'A';
    const Model_B = 'B';
    const Model_C = 'C';
    const Model_D = 'D';

    private string $type;
    private MazeCell $inCell;

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @param string $type
     */
    public function setType(string $type): void
    {
        $this->type = $type;
    }

    /**
     * @return MazeCell
     */
    public function getInCell(): MazeCell
    {
        return $this->inCell;
    }

    /**
     * @param MazeCell $inCell
     */
    public function setInCell(MazeCell $inCell): void
    {
        $this->inCell = $inCell;
    }

    /**
     * @return int
     */
    public function getMoveScore(): int
    {
        $scores = [
            Model::Model_A => 1,
            Model::Model_B => 10,
            Model::Model_C => 100,
            Model::Model_D => 1000,
        ];

        return $scores[$this->type];
    }
}
