<?php
declare(strict_types=1);

namespace Paysera\Component\CodeClimateMerger\Test;

use Doctrine\Common\Collections\ArrayCollection;
use Paysera\Component\CodeClimateMerger\Entity\Error;
use Paysera\Component\CodeClimateMerger\Entity\Report;
use Paysera\Component\CodeClimateMerger\Service\CodeClimateConverter;
use Paysera\Component\CodeClimateMerger\Service\FingerprintGenerator;
use PHPUnit\Framework\TestCase;

class CodeClimateConverterTest extends TestCase
{
    /**
     * @var CodeClimateConverter
     */
    private $codeClimateConverter;

    public function setUp()
    {
        $this->codeClimateConverter = new CodeClimateConverter(new FingerprintGenerator());
    }

    /**
     * @dataProvider dataProviderForConversion
     * @param ArrayCollection $actual
     * @param string $expected
     */
    public function testConvertToCodeClimate(ArrayCollection $actual, string $expected)
    {
        $actual = $this->codeClimateConverter->convert($actual);

        $this->assertEquals($expected, $actual);
    }

    public function dataProviderForConversion()
    {
        return [
            'successful conversion no. 1' => [
                (new ArrayCollection(
                    [
                        (new Report())
                            ->setFilename('/var/lib/jenkins/workspace/Releases/eslint Release/eslint/fullOfProblems.js')
                            ->setErrors(
                                new ArrayCollection(
                                    [
                                        (new Error())
                                            ->setMessage('Missing semicolon. (semi)')
                                            ->setSource('eslint.rules.semi')
                                            ->setLine('5')
                                    ]
                                )
                            ),
                        (new Report())
                            ->setFilename('/var/lib/jenkins/workspace/Releases/eslint Release/eslint/fullOfProblems.js')
                            ->setErrors(
                                new ArrayCollection(
                                    [
                                        (new Error())
                                            ->setMessage('Unnecessary semicolon. (no-extra-semi)')
                                            ->setSource('eslint.rules.no-extra-semi')
                                            ->setLine('7'),
                                        (new Error())
                                            ->setMessage('Violations found')
                                            ->setSource('some.source')
                                            ->setLine('33'),

                                    ]
                                )
                            ),
                    ]
                )
                ),
'[
    {
        "description": "Missing semicolon. (semi)",
        "fingerprint": "6872fbb71adfdbd6bb68e7959a9a6201",
        "location": {
            "path": "/var/lib/jenkins/workspace/Releases/eslint Release/eslint/fullOfProblems.js",
            "lines": {
                "begin": "5"
            }
        }
    },
    {
        "description": "Unnecessary semicolon. (no-extra-semi)",
        "fingerprint": "8894d83c04b4b75cff0357517ffd0f05",
        "location": {
            "path": "/var/lib/jenkins/workspace/Releases/eslint Release/eslint/fullOfProblems.js",
            "lines": {
                "begin": "7"
            }
        }
    },
    {
        "description": "Violations found",
        "fingerprint": "935dba533d94d0230f7fe3b439e1a645",
        "location": {
            "path": "/var/lib/jenkins/workspace/Releases/eslint Release/eslint/fullOfProblems.js",
            "lines": {
                "begin": "33"
            }
        }
    }
]'
            ]
        ];
    }
}
