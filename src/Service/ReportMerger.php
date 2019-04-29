<?php
declare(strict_types=1);

namespace Paysera\Component\CodeClimateMerger\Service;

use Doctrine\Common\Collections\ArrayCollection;

class ReportMerger
{
    public function merge(ArrayCollection $phpCsFixerResults, ArrayCollection $eslintResults)
    {
        foreach ($eslintResults as $eslintResult) {
            $phpCsFixerResults->add($eslintResult);
        }

        return $phpCsFixerResults;
    }
}
