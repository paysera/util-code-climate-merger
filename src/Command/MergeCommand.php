<?php
declare(strict_types=1);

namespace Paysera\Component\CodeClimateMerger\Command;

use Exception;
use Paysera\Component\CodeClimateMerger\Service\ReportHandler;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class MergeCommand extends Command
{
    private $reportHandler;

    public function __construct(ReportHandler $reportHandler)
    {
        parent::__construct();
        $this->reportHandler = $reportHandler;
    }

    protected function configure()
    {
        $this
            ->setName('merge')
            ->addArgument('target-file', InputArgument::REQUIRED, 'path to gitlab codeclimat format')
            ->addOption('checkstyle', null, InputOption::VALUE_OPTIONAL | InputOption::VALUE_IS_ARRAY, 'path to file in checkstyle format')
            ->setDescription('Merges checkstyle formats to gitlab supported codeclimate format.');

    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $checkstyle = $input->getOption('checkstyle');
        if (count($checkstyle) !== 2) {
            throw new Exception('must provide two files to merge');
        }
        $fileContents = [];
        for ($i = 0; $i < count($checkstyle); $i++) {
            if (!file_exists($checkstyle[$i])) {
                throw new Exception(sprintf('cannot locate file: %s', $checkstyle[$i]));
            }

            $fileContents[$i] = file_get_contents($checkstyle[$i]);
        }

        $result = $this->reportHandler->handle($fileContents[0], $fileContents[1]);

        $file = file_put_contents($input->getArgument('target-file'), $result);
        if ($file) {
            $output->writeln('success');
        }
    }
}
