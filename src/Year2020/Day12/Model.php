<?php

namespace AdventOfCode\Year2020\Day12;

class Model
{
    protected $action;

    protected $count;

    public function assign(string $line)
    {
        $this->action = $line[0];
        $this->count = (int) substr($line, 1);
    }

    public function valid()
    {
        $result = false;


        return $result;
    }

    /**
     * @return mixed
     */
    public function getAction()
    {
        return $this->action;
    }

    /**
     * @return mixed
     */
    public function getCount()
    {
        return $this->count;
    }

}
