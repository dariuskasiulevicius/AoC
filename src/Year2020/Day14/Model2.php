<?php

namespace AdventOfCode\Year2020\Day14;

class Model2
{
    protected $action;
    protected $address;
    protected $value;

    public function assign(string $line)
    {
        $parts = explode('=', $line);
        if (trim($parts[0]) === 'mask') {
            $this->action = 'mask';
            $this->value = trim($parts[1]);
        } else {
            $this->action = 'mem';
            $this->address = decbin((int)substr(trim($parts[0]), 4, -1));
            $this->value = (int)$parts[1];
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
