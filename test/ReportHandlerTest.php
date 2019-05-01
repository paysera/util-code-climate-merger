<?php
declare(strict_types=1);

namespace Paysera\Component\CodeClimateMerger\Test;

use Doctrine\Common\Collections\ArrayCollection;
use Paysera\Component\CodeClimateMerger\Parser\CheckstyleParser;
use Paysera\Component\CodeClimateMerger\Parser\ParserManager;
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
        $parserManager = new ParserManager();
        $parserManager->addParser(new CheckstyleParser(), 'checkstyle');
        $this->handler = new ReportHandler(
            new ReportMerger(),
            new CodeClimateConverter(new FingerprintGenerator()),
            $parserManager
        );
    }

    public function testHandleReportMerge()
    {
        $actual = $this->handler->handle(
            new ArrayCollection([
                'checkstyle' => [
                    __DIR__ . '/Fixtures/checkstyle_fixer.xml',
                    __DIR__ . '/Fixtures/checkstyle_eslint.xml',
                ]
            ])
        );

        $this->assertJsonStringEqualsJsonFile(__DIR__ . '/Fixtures/codeclimate_json.json', $actual);
    }
}
