<?php

namespace AdventOfCode\Year2015;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class TestCommand extends Base
{
    protected static $defaultName = 'AoC-2015:test';
    protected Fixture $testObj;

    protected function configure(): void
    {
        $this
            ->setDescription('Command that runs code for selected day and validates answer')
            ->addArgument('day', InputArgument::REQUIRED, 'Day number. Examples: <5>, <27>.');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $day = $input->getArgument('day');
        $this->initDayDir($day);
        $this->initObjects();

        $table = new Table($output);
        $testCases = $this->testObj->getCases();
        foreach ($testCases as $testCase) {
            $dataInput = new DataInput($this->getDataFileName($testCase->getInputFileName()));
            $variation = $this->goldObj;
            if ($testCase->getVariation() === TestCase::VARIATION_SILVER) {
                $variation = $this->silverObj;
            }
            $startTime = microtime(true);
            $actual = $variation->resolve($dataInput);
            $executeTime = microtime(true) - $startTime;
            $correct = (string)$testCase->getExpected() === (string)$actual ? 'v' : 'X';
            $table->addRow([$testCase->getVariation(), $actual, $testCase->getExpected(), $correct, $executeTime]);
        }


        $table
            ->setHeaders(['Star type', 'Result value', 'Expected value', 'Is correct', 'Execution time (s)'])
            ->setHeaderTitle('Day ' . $day)
            ->setStyle('box-double')
            ->render();

        return 0;
    }

    protected function initObjects(): void
    {
        parent::initObjects();

        $testClassName = 'AdventOfCode\\Year2015\\' . $this->dayDir . '\\Fixtures';
        $this->testObj = new $testClassName();
    }
}
