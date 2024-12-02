<?php

namespace AdventOfCode\Year2024;

use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class TestCommand extends Base
{
    protected static $defaultName = 'AoC-2024:test';
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
            if(is_array($testCase)) {
                $testCase = $this->buildTestCase($testCase);
            }
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

        $testClassName = 'AdventOfCode\\Year2024\\' . $this->dayDir . '\\Fixtures';
        $this->testObj = new $testClassName();
    }

    private function buildTestCase($test)
    {
        $case = new TestCase();
        $case->setVariation($test[0]);
        $case->setInputFileName($test[1]);
        $case->setExpected($test[2]);

        return $case;
    }
}
