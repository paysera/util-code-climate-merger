<?php
declare(strict_types=1);

namespace Paysera\Component\CodeClimateMerger\Test;

use Paysera\Component\CodeClimateMerger\Parser\CheckstyleParser;
use Paysera\Component\CodeClimateMerger\Service\CodeClimateConverter;
use Paysera\Component\CodeClimateMerger\Service\FingerprintGenerator;
use Paysera\Component\CodeClimateMerger\Service\ReportHandler;
use Paysera\Component\CodeClimateMerger\Service\ReportMerger;
use PHPUnit\Framework\TestCase;

class ReportHandlerTest extends TestCase
{
    /**
     * @var ReportHandler
     */
    private $handler;

    public function setUp()
    {
        $this->handler = new ReportHandler(
            new CheckstyleParser(),
            new ReportMerger(),
            new CodeClimateConverter(new FingerprintGenerator())
        );
    }

    public function testHandleReportMerge()
    {
        $actual = $this->handler->handle(
            file_get_contents(__DIR__ . '/Fixtures/checkstyle_fixer.xml'),
            file_get_contents(__DIR__ . '/Fixtures/checkstyle_eslint.xml')
        );

        $this->assertJsonStringEqualsJsonFile(__DIR__ . '/Fixtures/codeclimate_json.json', $actual);
    }
}
