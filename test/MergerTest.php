<?php
declare(strict_types=1);

namespace Paysera\Component\CodeClimateMerger\Test;

use Doctrine\Common\Collections\ArrayCollection;
use Paysera\Component\CodeClimateMerger\Service\ReportMerger;
use PHPUnit\Framework\TestCase;

class MergerTest extends TestCase
{
    /**
     * @var ReportMerger
     */
    private $merger;

    public function setUp()
    {
        $this->merger = new ReportMerger();
    }

    /**
     * @dataProvider dataProviderForMerge
     * @param ArrayCollection $phpCsFixerResults
     * @param ArrayCollection $eslintResults
     * @param string $count
     */
    public function testMergeReports(ArrayCollection $phpCsFixerResults, ArrayCollection $eslintResults, string $count)
    {
        $merged = $this->merger->merge($phpCsFixerResults, $eslintResults);

        $this->assertEquals($count, $merged->count());
    }

    public function dataProviderForMerge()
    {
        return [
            'count should be the same no. 1' => [
                new ArrayCollection([1, 2, 3]),
                new ArrayCollection([4, 5]),
                '5'
            ],
            'count should be the same no. 2' => [
                new ArrayCollection([1, 2, 3, 4, 5, 6, 7]),
                new ArrayCollection([8, 9, 10, 11]),
                '11'
            ],
            'count should be the same no. 3' => [
                new ArrayCollection([1, 2, 3, '', 123, 1, '']),
                new ArrayCollection([1, 2, '']),
                '10'
            ],
            'count should be the same no. 4' => [
                new ArrayCollection([1]),
                new ArrayCollection([]),
                '1'
            ]
        ];
    }
}
