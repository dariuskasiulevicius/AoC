<?php

namespace AdventOfCode\Year2021\Day23;

use AdventOfCode\Year2021\DataInput;
use AdventOfCode\Year2021\PuzzleResolver;

class GoldPuzzle implements PuzzleResolver
{
    /** @var MazeCell[] */
    private $mazeNodes = [];

    /**
     * @return mixed
     */
    public function resolve(DataInput $inputData)
    {
        $result = 0;

        #123#######11#
        #...........#
        ###C#C#A#B### 12#16#20#24
        ###D#C#B#A### 13#17#21#25
        ###D#B#A#C### 14#18#22#26
        ###D#D#B#A### 15#19#23#27
        #############

        $this->mazeNodes = [];
        $maze = $this->buildMaze();

//Real
        $start = [
            [Model::Model_C, 12],
            [Model::Model_D, 13],
            [Model::Model_D, 14],
            [Model::Model_D, 15],
            [Model::Model_C, 16],
            [Model::Model_C, 17],
            [Model::Model_B, 18],
            [Model::Model_D, 19],
            [Model::Model_A, 20],
            [Model::Model_B, 21],
            [Model::Model_A, 22],
            [Model::Model_B, 23],
            [Model::Model_B, 24],
            [Model::Model_A, 25],
            [Model::Model_C, 26],
            [Model::Model_A, 27],
        ];

        $goal = [
            [Model::Model_A, 12],
            [Model::Model_A, 13],
            [Model::Model_A, 14],
            [Model::Model_A, 15],
            [Model::Model_B, 16],
            [Model::Model_B, 17],
            [Model::Model_B, 18],
            [Model::Model_B, 19],
            [Model::Model_C, 20],
            [Model::Model_C, 21],
            [Model::Model_C, 22],
            [Model::Model_C, 23],
            [Model::Model_D, 24],
            [Model::Model_D, 25],
            [Model::Model_D, 26],
            [Model::Model_D, 27],
        ];

        sort($start);
        $startKey = json_encode($start);

        sort($goal);
        $goalKey = json_encode($goal);

        $cameFrom = $this->aStar($startKey, $goalKey);

        return $result;
    }

    private function buildMaze()
    {
        $hall = [null, null, 'a', null, 'b', null, 'c', null, 'd', null, null];
        $rooms = [
            'a' => [MazeCell::A_ROOM, MazeCell::A_ROOM, MazeCell::A_ROOM, MazeCell::A_ROOM],
            'b' => [MazeCell::B_ROOM, MazeCell::B_ROOM, MazeCell::B_ROOM, MazeCell::B_ROOM],
            'c' => [MazeCell::C_ROOM, MazeCell::C_ROOM, MazeCell::C_ROOM, MazeCell::C_ROOM],
            'd' => [MazeCell::D_ROOM, MazeCell::D_ROOM, MazeCell::D_ROOM, MazeCell::D_ROOM],
        ];
        $id = count($hall) + 1;
        foreach ($rooms as $key => $room) {
            $prev = null;
            foreach ($room as $number => $cell) {
                $node = new MazeCell();
                $node->setId($id);
                $this->mazeNodes[$id] = $node;
                $id++;
                $node->setCanStop(true);
                $node->setType($cell);
                if ($prev instanceof MazeCell) {
                    $node->addSibling($prev);
                    $prev->addSibling($node);
                } else {
                    $rooms[$key] = $node;
                }
                $prev = $node;
            }
        }

        $start = null;
        $prev = null;
        $id = 1;
        foreach ($hall as $item) {
            $node = new MazeCell();
            $node->setId($id);
            $this->mazeNodes[$id] = $node;
            $id++;
            $node->setCanStop($item === null);
            $node->setType(MazeCell::HALLWAY);
            if ($prev instanceof MazeCell) {
                $node->addSibling($prev);
                $prev->addSibling($node);
            }
            $prev = $node;
            if (isset($rooms[$item])) {
                $node->addSibling($rooms[$item]);
                $rooms[$item]->addSibling($node);
            }
            if ($start === null) {
                $start = $node;
            }
        }
        ksort($this->mazeNodes);

        return $start;
    }

    private function aStar($start, $goal)
    {
        $openSet[$start] = true;
        $cameFrom = [];

        $gScore = [];
        $fScore = [];
        $gScore[$start] = 0;
        $fScore[$start] = 0;

        $examinedNodes = 0;
        while (!empty($openSet)) {
            $current = $this->getBestNode($openSet, $fScore);
            if ($current === $goal) {
                echo 'Found result: ' . $gScore[$goal] . PHP_EOL;
                break;
            }

            unset($openSet[$current]);
            $neighbors = $this->getNeighbors($current);
            foreach ($neighbors as $neighborBlock) {
                $neighbor = $neighborBlock[0];
//                $this->print($neighbor);
                $tentative_gScore = $gScore[$current] + $neighborBlock[1];
                $oldScore = $gScore[$neighbor] ?? PHP_INT_MAX;
                if ($tentative_gScore <= $oldScore) {
                    $cameFrom[$neighbor] = $current;
                    $gScore[$neighbor] = $tentative_gScore;
                    $fScore[$neighbor] = $tentative_gScore + $this->calculateEstimatedCost($neighbor, $goal);
                    if (!isset($openSet[$neighbor])) {
                        $openSet[$neighbor] = true;
                    }
                }
            }
            $examinedNodes++;
            if ($examinedNodes % 10000 === 0) {
                echo $examinedNodes . ' ';
                var_export($current);
            }
        }

        echo 'Examined nodes: ' . $examinedNodes . PHP_EOL;

        return $cameFrom;
    }

    private function getNeighbors($nodeStat)
    {
        $result = [];
        $nodes = json_decode($nodeStat, true);
        $this->clearMaze();
        $models = $this->setModels($nodes);
        foreach ($models as $key => $node) {
            $prev = [];
            //do we need move node??
            if ($this->nodeIsInPlace($node)) {
                continue;
            }
            $buffer = [[$node->getInCell(), 0]];
            while (!empty($buffer)) {
                $curr = array_pop($buffer);
                /** @var MazeCell $currCell */
                $currCell = $curr[0];
                foreach ($currCell->getSiblings() as $item) {
                    if (isset($prev[$item->getId()])) {
                        continue;
                    }
                    $prev[$item->getId()] = true;
//                    if ($item->getContent() !== null) {
//                        continue;
//                    }
                    if ($this->canNodeMoveToPlace($node, $item)) {
                        $price = $curr[1] + $node->getMoveScore();
                        if ($this->canStayInPlace($node, $item)) {
                            $new = $nodes;
                            $new[$key] = [$node->getType(), $item->getId()];
                            sort($new);
                            $result[] = [json_encode($new), $price];
                        }
                        $buffer[] = [$item, $price];
                    }
                }
            }
            $a = 5;
        }

//        echo 'getNeighbors count: ' . count($result) . PHP_EOL;

        return $result;
    }

    private function canNodeMoveToPlace(Model $node, MazeCell $cell)
    {
        $canNodeMoveToPlace = true;
        if (
            $cell->getContent() !== null
            || ($cell->getType() !== MazeCell::HALLWAY && $node->getInCell()->getType() !== $cell->getType()
                && $node->getType() !== $cell->getType())
        ) {
            return false;
        }
        //Can I move to room?
        if ($cell->getType() !== MazeCell::HALLWAY && $cell->getType() !== $node->getInCell()->getType()) {
            $type = $node->getType();
            /** @var MazeCell[] $rooms */
            $rooms = $this->getAllRoomsByType($type);
            foreach ($rooms as $room) {
                if ($room->getContent() !== null && $room->getContent()->getType() !== $type) {
                    $canNodeMoveToPlace = false;
                    break;
                }
            }
        }


        return $canNodeMoveToPlace;
    }

    private function canStayInPlace(Model $node, MazeCell $cell): bool
    {
        if (!$cell->isCanStop()
            || ($cell->getType() !== $node->getType() && $cell->getType() !== MazeCell::HALLWAY)
        ) {
            return false;
        }
        $canStay = true;
        if ($cell->getType() !== MazeCell::HALLWAY) {
            $type = $node->getType();
            /** @var MazeCell[] $rooms */
            $rooms = $this->getAllRoomsByType($type);
            foreach ($rooms as $room) {
                if ($room->getId() > $cell->getId() && $room->getContent() === null) {
                    $canStay = false;
                    break;
                }
            }
        }

        return $canStay;
    }

    private function clearMaze()
    {
        foreach ($this->mazeNodes as $node) {
            $node->setContent(null);
        }
    }

    private function nodeIsInPlace(Model $node): bool
    {
        if ($node->getInCell()->getType() !== $node->getType()) {
            return false;
        }
        /** @var MazeCell[] $rooms */
        $rooms = $this->getAllRoomsByType($node->getType());
        $id = $node->getInCell()->getId();
        foreach ($rooms as $room) {
            if ($room->getId() > $id
                && (null === $room->getContent() || $room->getContent()->getType() !== $room->getType())) {
                return false;
            }
        }

        return true;
    }

    /**
     * @param $nodes
     * @return Model[]
     */
    private function setModels($nodes): array
    {
        $models = [];
        foreach ($nodes as $node) {
            $model = new Model();
            $model->setType($node[0]);
            $mazeNode = $this->mazeNodes[$node[1]];
            $model->setInCell($mazeNode);
            $mazeNode->setContent($model);
            $models[] = $model;
        }

        return $models;
    }

    private function getAllRoomsByType(string $type): array
    {
        $rooms = [];
        foreach ($this->mazeNodes as $mazeNode) {
            if ($mazeNode->getType() === $type) {
                $rooms[] = $mazeNode;
            }
        }

        return $rooms;
    }

    private function getBestNode($nodes, $fScore)
    {
        $best = null;
        foreach ($nodes as $node => $val) {
            $estimatedCost = PHP_INT_MAX;
            if (isset($fScore[$node])) {
                $estimatedCost = $fScore[$node];
            }
            if ($best === null || $estimatedCost < $best[1]) {
                $best = [$node, $estimatedCost];
            }
        }

        return $best[0];
    }

    private function calculateEstimatedCost($fromNode, $toNode)
    {
//        return 0;

        #123#######11#
        #...........#
        ###C#C#A#B### 12#16#20#24
        ###D#C#B#A### 13#17#21#25
        ###D#B#A#C### 14#18#22#26
        ###D#D#B#A### 15#19#23#27
        #############


        if (isset($this->cache[$fromNode])) {
            return $this->cache[$fromNode];
        }

        $map = [
            'A' => [
                1  => 6,
                2  => 5,
                3  => 4,
                4  => 5,
                5  => 6,
                6  => 7,
                7  => 8,
                8  => 9,
                9  => 10,
                10 => 11,
                11 => 12,
                12 => 3,
                13 => 2,
                14 => 1,
                15 => 0,
                16 => 7,
                17 => 8,
                18 => 9,
                19 => 10,
                20 => 9,
                21 => 10,
                22 => 11,
                23 => 12,
                24 => 11,
                25 => 12,
                26 => 13,
                27 => 14,
            ],
            'B' => [
                1  => 8,
                2  => 7,
                3  => 6,
                4  => 5,
                5  => 4,
                6  => 5,
                7  => 6,
                8  => 7,
                9  => 8,
                10 => 9,
                11 => 10,
                12 => 7,
                13 => 8,
                14 => 9,
                15 => 10,
                16 => 3,
                17 => 2,
                18 => 1,
                19 => 0,
                20 => 7,
                21 => 8,
                22 => 9,
                23 => 10,
                24 => 9,
                25 => 10,
                26 => 11,
                27 => 12,
            ],
            'C' => [
                1  => 10,
                2  => 9,
                3  => 8,
                4  => 7,
                5  => 6,
                6  => 5,
                7  => 4,
                8  => 5,
                9  => 6,
                10 => 7,
                11 => 8,
                12 => 9,
                13 => 10,
                14 => 11,
                15 => 12,
                16 => 7,
                17 => 8,
                18 => 9,
                19 => 10,
                20 => 3,
                21 => 2,
                22 => 1,
                23 => 0,
                24 => 7,
                25 => 8,
                26 => 9,
                27 => 10,
            ],
            'D' => [
                1  => 12,
                2  => 11,
                3  => 10,
                4  => 9,
                5  => 8,
                6  => 7,
                7  => 6,
                8  => 5,
                9  => 4,
                10 => 5,
                11 => 6,
                12 => 11,
                13 => 12,
                14 => 13,
                15 => 14,
                16 => 9,
                17 => 10,
                18 => 11,
                19 => 12,
                20 => 7,
                21 => 8,
                22 => 9,
                23 => 10,
                24 => 3,
                25 => 2,
                26 => 1,
                27 => 0,
            ],
        ];
        $multiplier = [
            Model::Model_A => 1,
            Model::Model_B => 10,
            Model::Model_C => 100,
            Model::Model_D => 1000,
        ];
        $from = json_decode($fromNode, true);
        sort($from);
        $count = count($from);
        $estimate = 0;

        for ($i = 0; $i < $count; $i++) {
            $estimate += ($map[$from[$i][0]][$from[$i][1]] * $multiplier[$from[$i][0]]);
        }
        $this->cache[$fromNode] = $estimate;

        return $estimate;
    }

    private function print($item)
    {
        $nodes = json_decode($item, true);
        $printItems = array_fill(1, 19, '.');
        foreach ($nodes as $nodeItem) {
            $printItems[$nodeItem[1]] = $nodeItem[0];
        }
        printf(
            '#############%s#%s%s%s%s%s%s%s%s%s%s%s#%s###%s#%s#%s#%s###%s###%s#%s#%s#%s###%s#############%s%s',
            PHP_EOL,
            $printItems[1],
            $printItems[2],
            $printItems[3],
            $printItems[4],
            $printItems[5],
            $printItems[6],
            $printItems[7],
            $printItems[8],
            $printItems[9],
            $printItems[10],
            $printItems[11],
            PHP_EOL,
            $printItems[12],
            $printItems[14],
            $printItems[16],
            $printItems[18],
            PHP_EOL,
            $printItems[13],
            $printItems[15],
            $printItems[17],
            $printItems[19],
            PHP_EOL,
            PHP_EOL,
            PHP_EOL,
        );
    }
}
