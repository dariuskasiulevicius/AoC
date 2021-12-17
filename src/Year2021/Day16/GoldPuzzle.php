<?php

namespace AdventOfCode\Year2021\Day16;

use AdventOfCode\Year2021\DataInput;
use AdventOfCode\Year2021\PuzzleResolver;

class GoldPuzzle implements PuzzleResolver
{
    private $actions;

    private $versionSum = 0;

    /**
     * @return mixed
     */
    public function resolve(DataInput $inputData)
    {
        $result = 0;
        $buffer = '';
        foreach ($inputData as $item) {
            //your custom code goes here
            foreach (str_split($item) as $hex) {
                $buffer .= str_pad(decbin(hexdec($hex)), 4, '0', STR_PAD_LEFT);
            }
        }

        [$packets, $tmp] = $this->getPackets($buffer);

        $line = $this->buildLine($packets[0]);

        echo $line . PHP_EOL;
        echo $this->versionSum . PHP_EOL;

        eval('$result=' . $line . ';');

        return $result;
    }

    private function buildLine($actions)
    {
        $line = '';
        while (!empty($actions)) {
            $action = array_shift($actions);
            if (!is_array($action) && isset($actions[0]) && is_array($actions[0])) {
                $sign = $action;
                if ($sign === 'min' || $sign === 'max') {
                    $line .= $sign;
                    $sign = ',';
                }
                $values = [];
                $iterate = array_shift($actions);
                foreach ($iterate as $item) {
                    if (is_array($item)) {
                        $values[] = $this->buildLine($item);
                    } else {
                        $values[] = $item;
                    }
                }
                $line .= '(';
                if ($sign === ',' && count($values) === 1) {
                    $line .= '[' . $values[0] . ']';
                } else {
                    $line .= implode($sign, $values);
                }
                $line .= ')';
            } else {
                $line .= $action;
            }
        }

        return $line;
    }

    /**
     * @param array  $packets
     * @param array  $actions
     * @param string $action
     * @return array
     */
    private function getPackets(string $packet, $count = -1): array
    {
        $from = 0;
        $actions = [];
        while ($from < strlen($packet)
            && ($count === -1 || $count > 0)) {
            if ($count > 0) {
                $count--;
            }
            $version = bindec(substr($packet, $from, 3));
            $this->versionSum += $version;
            $from += 3;
            $typeId = bindec(substr($packet, $from, 3));
            switch ($typeId) {
                case 0:
                    $action = '+';
                    break;
                case 1:
                    $action = '*';
                    break;
                case 2:
                    $action = 'min';
                    break;
                case 3:
                    $action = 'max';
                    break;
                case 5:
                    $action = '>';
                    break;
                case 6:
                    $action = '<';
                    break;
                case 7:
                    $action = '===';
                    break;
            }
            $from += 3;
            if ($typeId === 4) {
                $value = '';
                do {
                    $last = substr($packet, $from, 1);
                    $from += 1;
                    $value .= substr($packet, $from, 4);
                    $from += 4;
                } while ($last);
                $actions[] = bindec($value);
            } else {
                $length = bindec(substr($packet, $from, 1));
                $from += 1;
                if ($length === 0) {
                    $fullAction = bindec(substr($packet, $from, 15));
                    $from += 15;
                    [$inner, $innerFrom] = $this->getPackets(substr($packet, $from, $fullAction));
                    $actions[] = [$action, $inner];
                    $from += $fullAction;
                } else {
                    $packetCount = bindec(substr($packet, $from, 11));
                    $from += 11;
                    [$inner, $innerFrom] = $this->getPackets(substr($packet, $from), $packetCount);
                    $actions[] = [$action, $inner];
                    $from += $innerFrom;
                }
            }
        }

        return [$actions, $from];
    }
}
