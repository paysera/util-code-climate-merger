<?php
declare(strict_types=1);

namespace Paysera\Component\CodeClimateMerger\Command;

use Paysera\Component\CodeClimateMerger\Service\InputHandler;
use Paysera\Component\CodeClimateMerger\Service\ReportHandler;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class MergeCommand extends Command
{
    private $reportHandler;
    private $inputHandler;

    public function __construct(
        ReportHandler $reportHandler,
        InputHandler $inputHandler
    ) {
        parent::__construct();
        $this->reportHandler = $reportHandler;
        $this->inputHandler = $inputHandler;
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
        $files = $this->inputHandler->handle($input->getOptions());

        $result = $this->reportHandler->handle($files);

        $file = file_put_contents($input->getArgument('target-file'), $result);
        if ($file) {
            $output->writeln('success');
        }
    }
}
