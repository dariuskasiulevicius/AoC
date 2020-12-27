<?php

namespace AdventOfCode\Year2020\Day14;

class Model
{
    protected $action;
    protected $address;
    protected $value;

    public function assign(string $line)
    {
        $parts = explode('=', $line);
        if (trim($parts[0]) === 'mask') {
            $this->action = 'mask';
            $or = bindec(str_replace('X', '0', trim($parts[1])));
            $and = bindec(str_replace('X', '1', trim($parts[1])));
            $this->value = ['or' => $or, 'and'=>$and];
        } else {
            $this->action = 'mem';
            $this->address = substr(trim($parts[0]), 4, -1);
            $this->value = (int) $parts[1];
        }
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
     * @param mixed $action
     */
    public function setAction($action): void
    {
        $this->action = $action;
    }

    /**
     * @return mixed
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * @param mixed $address
     */
    public function setAddress($address): void
    {
        $this->address = $address;
    }

    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param mixed $value
     */
    public function setValue($value): void
    {
        $this->value = $value;
    }

}
