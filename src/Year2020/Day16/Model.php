<?php

namespace AdventOfCode\Year2020\Day16;

class Model
{
    protected  string $type;
    protected array $values;

    public function assign(string $line)
    {
        $pattern = "/^([^:]+): (\d+)-(\d+) or (\d+)-(\d+)$/";
        if(preg_match($pattern,$line,$matches)) {
            $this->type = $matches[1];
            $this->values = [[$matches[2],$matches[3]],[$matches[4], $matches[5]]];
        }
    }

    public function valid()
    {
        $result = false;


        return $result;
    }

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
     * @return array
     */
    public function getValues(): array
    {
        return $this->values;
    }

    /**
     * @param array $values
     */
    public function setValues(array $values): void
    {
        $this->values = $values;
    }
}
