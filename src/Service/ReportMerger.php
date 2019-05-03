<?php
declare(strict_types=1);

namespace Paysera\Component\CodeClimateMerger\Service;

use Doctrine\Common\Collections\ArrayCollection;

class ReportMerger
{
    public function merge(ArrayCollection $results)
    {
        $mergedReports = new ArrayCollection();

        array_map(function ($result) use ($mergedReports) {
            foreach ($result as $file) {
                $mergedReports->add($file);
            }
        },
        $results->toArray()
        );

        return $mergedReports;
    }
}
