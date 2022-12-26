<?php

namespace AdventOfCode\Year2022\Day19;

ini_set('memory_limit', '200G');

use AdventOfCode\Year2022\DataInput;
use AdventOfCode\Year2022\PuzzleResolver;

//(You guessed 4374.) That's not the right answer; your answer is too low. If you're stuck, make sure you're using the full input data; there are also some general tips on the about page, or you can ask for hints on the subreddit. Please wait one minute before trying again. (You guessed 4374.)
//6804 = 9 * 27 * 28
class GoldPuzzle implements PuzzleResolver
{
    /**
     * @return mixed
     */
    public function resolve(DataInput $inputData)
    {
        $result = 0;
        $bluePrints = [];
        foreach ($inputData as $item) {
            //your custom code goes here
            preg_match_all('/\d+/', $item, $matches);
            $bp = new Model();
            $data = $matches[0];
            $bp->setNumber((int)$data[0]);
            $prices = [
                [(int)$data[1], 0, 0, 0],
                [(int)$data[2], 0, 0, 0],
                [(int)$data[3], (int)$data[4], 0, 0],
                [(int)$data[5], 0, (int)$data[6], 0],
            ];
            $bp->setPrices($prices);
            $bluePrints[] = $bp;
        }

        $count = 3;
        $result = 1;
        foreach ($bluePrints as $bluePrint) {
            $startTime = microtime(true);
            $cases = $this->playBlueprint($bluePrint);
            $case = $this->getBestCase($cases);
            $time = microtime(true) - $startTime;
            echo 'Geodes ' . $case->getGeodes() . ' number ' . $case->getNumber() . ' ' . $case->getKey() . ' time: ' . $time . PHP_EOL;
            $result *= $case->getGeodes();
            $count--;
            if ($count <= 0) {
                break;
            }
        }


        return $result;
    }

    /**
     * @param Model[] $cases
     * @return Model
     */
    private function getBestCase(array $cases)
    {
        $best = array_key_first($cases);
        foreach ($cases as $key => $case) {
            if ($cases[$best]->getGeodes() < $case->getGeodes()) {
                $best = $key;
            }
        }

        return $cases[$best];
    }

    private function playBlueprint($bp)
    {
        $steps = 32;
        $cases = [$bp];
        for ($i = 1; $i <= $steps; $i++) {
//            echo 'Step ' . $i . ' var count ' . count($cases) . PHP_EOL;
//            echo '========Before========' . PHP_EOL;
//            echo $this->getKeys($cases);
            $nextCases = [];
            $have3Robot = 0;
            $have2Robot = 0;
            /** @var Model $case */
            foreach ($cases as $case) {
                $createdResources = $case->getRobots();
                $next = [];
                if ($i < $steps) {
                    $next = $this->getNextSteps($case);
                }
                if (empty($next)) {
                    $next[] = $case;
                }
                foreach ($next as $item) {
                    $item->addResources($createdResources);
//                    $skey = $item->getShortKey();
//                    if(!isset($nextCases[$skey])){
                    $nextCases[] = $item;
//                    }
                    if ($item->getRobots()[2] !== 0) {
                        $have2Robot = max($have2Robot, $item->getRobots()[2]);
                    }
                    if ($item->getRobots()[3] !== 0) {
                        $have3Robot = max($have3Robot, $item->getRobots()[3]);
                    }
                }
            }

            $nextCases = $this->filterNext($nextCases, $have2Robot, $have3Robot);

//            echo PHP_EOL;
//            echo '========Before========' . PHP_EOL;
//            echo $this->getKeys($nextCases);

            $cases = $nextCases;
//            echo '========After========' . PHP_EOL;
//            echo $this->getKeys($nextCases);
//            echo PHP_EOL;
        }

        return $cases;
    }

    private function filterNext($cases, $max2, $max3)
    {
        $filtered = [];
        /** @var Model $rb */
        foreach ($cases as $rb) {
            $kindCount = array_sum(array_map(fn($val): int => $val > 0 ? 1 : 0, $rb->getRobots()));
            if($kindCount < count($rb->getSkipBuild())) {
                continue;
            }
            if ($max3 !== 0 && $rb->getRobots()[3] >= ($max3 - 1)) {
                $filtered[] = $rb;
            } elseif ($max3 === 0 && $max2 !== 0 && $rb->getRobots()[2] >= ($max2 - 1)) {
                $filtered[] = $rb;
            } elseif ($max3 === 0 && $max2 === 0) {
                $filtered[] = $rb;
            }
        }

//        if ($have2Robot !== 0) {
//            $nextCases = array_filter($nextCases, fn($rb): bool => $rb->getRobots()[2] !== 0);
//        }
//        if ($have3Robot !== 0) {
//            $nextCases = array_filter($nextCases, fn($rb): bool => $rb->getRobots()[3] >= $have3Robot);
//        }
//        $nextCases = array_filter($nextCases, fn($rb): bool => array_sum(array_map(fn($val): int => $val > 0 ? 1 : 0, $rb->getRobots())) >= count($rb->getSkipBuild()));

        return $filtered;
    }

    private function getKeys($cases)
    {
        $string = '';
        /** @var Model $case */
        foreach ($cases as $case) {
            $string .= $case->getKey() . PHP_EOL;
        }

        return $string;
    }

    private function getNextSteps(Model $bp)
    {
        $steps = [];
        $prices = $bp->getPrices();
        $last = 0;
        for ($i = 3; $i >= $last; $i--) {
            $price = $prices[$i];
            $res = $bp->howManyRobotsCanBuild($price);
            if ($res >= 1 && $res < 3 && !in_array($i, $bp->getSkipBuild())) {
                $newBp = clone $bp;
                $newBp->minusResources($price);
                $newBp->addRobot($i);
                $newBp->setSkipBuild([]);
                $newBp->setParentName(spl_object_id($bp));
                $steps[] = $newBp;

                $newBp = clone $bp;
                $newBp->addSkipBuild($i);
                $newBp->setParentName(spl_object_id($bp));
                $steps[] = $newBp;
                $last = max(0, $i - 1);
//                break;
            }
        }

        return $steps;
    }
}
