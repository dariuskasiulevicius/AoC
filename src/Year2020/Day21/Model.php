<?php

namespace AdventOfCode\Year2020\Day21;

class Model
{
    protected $list;
    protected $ingridients;

    public function assign(string $line)
    {
        $parts = explode('(', $line);
        $this->list = explode(' ', trim($parts[0]));
        $aa = str_replace(['contains ', ')'], ['', ''],$parts[1]);
        $this->ingridients = explode(', ', $aa);
    }

    public function valid()
    {
        $result = false;


        return $result;
    }

    /**
     * @return mixed
     */
    public function getList()
    {
        return $this->list;
    }

    /**
     * @param mixed $list
     */
    public function setList($list): void
    {
        $this->list = $list;
    }

    /**
     * @return mixed
     */
    public function getIngridients()
    {
        return $this->ingridients;
    }

    /**
     * @param mixed $ingridients
     */
    public function setIngridients($ingridients): void
    {
        $this->ingridients = $ingridients;
    }
}
