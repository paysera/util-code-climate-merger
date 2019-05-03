<?php
declare(strict_types=1);

namespace Paysera\Component\CodeClimateMerger\Service;

use Doctrine\Common\Collections\ArrayCollection;
use Paysera\Component\CodeClimateMerger\Parser\ParserRegistry;

class ReportHandler
{
    private $reportMerger;
    private $codeClimateConverter;
    private $parserRegistry;

    public function __construct(
        ReportMerger $reportMerger,
        CodeClimateConverter $codeClimateConverter,
        ParserRegistry $parserRegistry
    ) {
        $this->reportMerger = $reportMerger;
        $this->codeClimateConverter = $codeClimateConverter;
        $this->parserRegistry = $parserRegistry;
    }

    public function handle(ArrayCollection $files)
    {
        $reports = $this->parserRegistry->parse($files);

        $codeClimateReport = $this->codeClimateConverter->convert(
            $this->reportMerger->merge($reports)
        );

        return $codeClimateReport;
    }
}
