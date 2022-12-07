<?php

namespace AdventOfCode\Year2022\Day07;

class Model
{
    private array $structure = [];
    private string $name = '';
    private int $size = 0;

    public function add(Model $model)
    {
        $this->structure[$model->getName()] = $model;
    }

    public function getNodeByName(string $name): Model
    {
        return $this->structure[$name];
    }
    /**
     * @return Model[]
     */
    public function getStructure(): array
    {
        return $this->structure;
    }

    /**
     * @param array $structure
     */
    public function setStructure(array $structure): void
    {
        $this->structure = $structure;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return int
     */
    public function getSize(): int
    {
        return $this->size;
    }

    /**
     * @param int $size
     */
    public function setSize(int $size): void
    {
        $this->size = $size;
    }
}
