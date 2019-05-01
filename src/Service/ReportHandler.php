<?php
declare(strict_types=1);

namespace Paysera\Component\CodeClimateMerger\Service;

use Doctrine\Common\Collections\ArrayCollection;
use Paysera\Component\CodeClimateMerger\Parser\ParserManager;

class ReportHandler
{
    private $reportMerger;
    private $codeClimateConverter;
    private $parserManager;

    public function __construct(
        ReportMerger $reportMerger,
        CodeClimateConverter $codeClimateConverter,
        ParserManager $parserManager
    ) {
        $this->reportMerger = $reportMerger;
        $this->codeClimateConverter = $codeClimateConverter;
        $this->parserManager = $parserManager;
    }

    public function handle(ArrayCollection $files)
    {
        $reports = $this->parserManager->manageParsing($files);

        $codeClimateReport = $this->codeClimateConverter->convert(
            $this->reportMerger->merge($reports)
        );

        return $codeClimateReport;
    }
}
