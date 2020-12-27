<?php

namespace AdventOfCode\Year2020\Day04;

class Model
{

    protected $byr; //(Birth Year)
    protected $iyr; //(Issue Year)
    protected $eyr; //(Expiration Year)
    protected $hgt; //(Height )
    protected $hgtMes;
    protected $hcl; //(Hair Color)
    protected $ecl; //(Eye Color)
    protected $pid; //(Passport ID)
    protected $cid; //(Country ID)

    public function assign(string $line)
    {
        $items = explode(' ', $line);
        foreach ($items as $item) {
            $parts = explode(':', $item);
            $key = $parts[0];
            if ($key === 'hgt') {
                if (false !== strpos($parts[1], 'in')) {
                    $this->hgtMes = 'in';
                } elseif (false !== strpos($parts[1], 'cm')) {
                    $this->hgtMes = 'cm';
                }
                $parts[1] = substr($parts[1],0, -2);
            }
            $this->$key = $parts[1];
        }
    }

    public function isValid()
    {
        return
            null !== $this->byr
        && null !== $this->iyr
        && null !== $this->eyr
        && null !== $this->hgt
        && null !== $this->hcl
        && null !== $this->ecl
        && null !== $this->pid;
}

    public function isGoldValid()
    {
        return
            null !== $this->byr
            && null !== $this->iyr
            && null !== $this->eyr
            && null !== $this->hgt
            && null !== $this->hcl
            && null !== $this->ecl
            && null !== $this->pid
            && $this->byr >= 1920 && $this->byr <= 2002
            && $this->iyr >= 2010 && $this->iyr <= 2020
            && $this->eyr >= 2020 && $this->eyr <= 2030
            && (($this->hgtMes === 'in' && $this->hgt >= 59 && $this->hgt <= 76)
                || ($this->hgtMes === 'cm' && $this->hgt >= 150 && $this->hgt <= 193))
            && preg_match('/^#[0-9a-f]{6}$/', $this->hcl) === 1
            && in_array($this->ecl, ['amb', 'blu', 'brn', 'gry', 'grn', 'hzl', 'oth'])
            && preg_match('/^[0-9]{9}$/', $this->pid) === 1
            ;
    }
}
