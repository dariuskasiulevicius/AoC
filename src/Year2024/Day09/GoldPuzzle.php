<?php

namespace AdventOfCode\Year2024\Day09;

use AdventOfCode\Year2024\DataInput;
use AdventOfCode\Year2024\PuzzleResolver;

class GoldPuzzle implements PuzzleResolver
{
    private array $disk = [];

    /**
     * @return mixed
     */
    public function resolve(DataInput $inputData)
    {
        $result = 0;
        $start = null;
        $last = null;
        foreach ($inputData as $item) {
            $file = true;
            $count = 0;
            foreach (str_split($item) as $char) {
                if ($file) {
                    $file = false;
                    $newElement = new DiskElement($count, (int)$char);
                    $count++;
                } else {
                    $newElement = new DiskElement(null, (int)$char);
                    $file = true;
                }
                if ($start === null) {
                    $start = $newElement;
                    $lastFile = $newElement;
                } else {
                    $lastFile->setNext($newElement);
                    $newElement->setPrev($lastFile);
                    $lastFile = $newElement;
                }
            }
        }
        $cur = $lastFile;
        while ($cur->getId() !== 0) {
//            echo $cur->getId() . PHP_EOL;
            $oldPrev = $cur->getPrev();
            $empty = $this->findEmpty($start, $cur);
            if ($empty !== null) {
                $oldNext = $cur->getNext();
                $newEmpty = new DiskElement(null, $cur->getCount());
                $newEmpty->setNext($oldNext);
                $newEmpty->setPrev($oldPrev);
                $oldPrev?->setNext($newEmpty);

                $empty->setCount($empty->getCount() - $cur->getCount());
                $empty->getPrev()?->setNext($cur);
                $cur->setNext($empty);
                $cur->setPrev($empty->getPrev());
                $cur->setMoved(true);
                $empty->setPrev($cur);

                if ($oldPrev !== null && $oldPrev->getId() === null) {
                    $this->mergeEmpty($oldPrev);
                }
            }
            while ($oldPrev?->getId() === null || $oldPrev?->isMoved()) {
                $oldPrev = $oldPrev->getPrev();
            }
            $cur = $oldPrev;
        }

        $cur = $start;
        $position = 0;
        while($cur) {
            if($cur->getId() !== null) {
                for ($i = 0; $i < $cur->getCount(); $i++) {
                    $result += $position * $cur->getId();
                    $position++;
                }
            } else {
                $position += $cur->getCount();
            }
            $cur = $cur->getNext();
        }

        return $result;
    }

    private function findEmpty(DiskElement $cur, DiskElement $file)
    {
        $empty = null;
        while ($empty === null) {
            if ($cur->getId() === $file->getId()) {
                return null;
            }
            if ($cur->getId() === null && $file->getCount() <= $cur->getCount()) {
                $empty = $cur;
            } else {
                $cur = $cur->getNext();
            }
        }

        return $cur;
    }

    private function mergeEmpty(DiskElement $empty)
    {
        $size = 0;
        $cur = $empty;
        while ($cur !== null && $cur->getId() === null) {
            $size += $cur->getCount();
            $cur = $cur->getNext();
        }
        $empty->setCount($size);
        $empty->setNext($cur);
        $cur?->setPrev($empty);
    }
}
