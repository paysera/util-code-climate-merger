<?php
declare(strict_types=1);

namespace Paysera\Component\CodeClimateMerger\Service;

use Doctrine\Common\Collections\ArrayCollection;
use Paysera\Component\CodeClimateMerger\Entity\Report;

class CodeClimateConverter
{
    private $fingerprintGenerator;

    public function __construct(FingerprintGenerator $fingerprintGenerator)
    {
        $this->fingerprintGenerator = $fingerprintGenerator;
    }

    public function convert(ArrayCollection $mergedCheckstyleReport)
    {
        $codeClimateReport = [];
        /** @var Report $report */
        foreach ($mergedCheckstyleReport as $report) {
            foreach ($report->getErrors() as $error) {
                $issue = [
                    'description' => $error->getMessage(),
                    'fingerprint' => $this->fingerprintGenerator->generate($report->getFilename(), $error),
                    'location' => [
                        'path' => $report->getFilename(),
                        'lines' => [
                            'begin' => $error->getLine(),
                        ],
                    ],
                ];
                if ($error->getSeverity() !== null) {
                    $issue['severity'] = $error->getSeverity();
                }

                $codeClimateReport[] = $issue;
            }

        }

        return json_encode($codeClimateReport, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
    }
}
