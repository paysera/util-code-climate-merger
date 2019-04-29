<?php
declare(strict_types=1);

namespace Paysera\Component\CodeClimateMerger\Service;

use Paysera\Component\CodeClimateMerger\Parser\CheckstyleParser;

class ReportHandler
{
    private $checkstyleParser;
    private $reportMerger;
    private $codeClimateConverter;

    public function __construct(
        CheckstyleParser $checkstyleParser,
        ReportMerger $reportMerger,
        CodeClimateConverter $codeClimateConverter
    ) {
        $this->checkstyleParser = $checkstyleParser;
        $this->reportMerger = $reportMerger;
        $this->codeClimateConverter = $codeClimateConverter;
    }

    public function handle(string $firstFileContents, string $secondFileContents)
    {
        $firstFileContents = $this->checkstyleParser->parse($firstFileContents);
        $secondFileContents = $this->checkstyleParser->parse($secondFileContents);

        $codeClimateReport = $this->codeClimateConverter->convert(
            $this->reportMerger->merge($firstFileContents, $secondFileContents)
        );

        return $codeClimateReport;
    }
}
