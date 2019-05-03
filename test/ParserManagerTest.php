<?php
declare(strict_types=1);

namespace Paysera\Component\CodeClimateMerger\Test;

use Doctrine\Common\Collections\ArrayCollection;
use Paysera\Component\CodeClimateMerger\Entity\Error;
use Paysera\Component\CodeClimateMerger\Entity\Report;
use Paysera\Component\CodeClimateMerger\Parser\CheckstyleParser;
use Paysera\Component\CodeClimateMerger\Parser\ParserRegistry;
use PHPUnit\Framework\TestCase;

class ParserManagerTest extends TestCase
{
    /**
     * @var ParserRegistry
     */
    private $parserManager;

    public function setUp()
    {
        $this->parserManager = new ParserRegistry();
        $this->parserManager->addParser(new CheckstyleParser(), 'checkstyle');
    }

    public function testChecksyleParser()
    {
        $actual = $this->parserManager->parse($this->getCheckstyleFile());
        $expected = $this->getExpectedCheckstyle();

        $this->assertEquals($expected, $actual[0]);
    }

    private function getExpectedCheckstyle()
    {
        $expected = new ArrayCollection();

        $expected->add(
            (new Report())
                ->setFilename('/var/lib/jenkins/workspace/Releases/eslint Release/eslint/fullOfProblems.js')
                ->setErrors(
                    new ArrayCollection(
                        [
                            (new Error())
                                ->setMessage('Missing semicolon. (semi)')
                                ->setSource('eslint.rules.semi')
                                ->setLine(5)
                                ->setColumn('13'),
                            (new Error())
                                ->setMessage('Unnecessary semicolon. (no-extra-semi)')
                                ->setSource('eslint.rules.no-extra-semi')
                                ->setLine(7)
                                ->setColumn('2'),
                        ]
                    )
                )
        );
        $expected->add(
            (new Report())
                ->setFilename('/src/Bundle/index.js')
                ->setErrors(
                    new ArrayCollection(
                        [
                            (new Error())
                                ->setMessage('Violations found: violation')
                                ->setSource('eslint.rules.violation')
                                ->setLine(45)
                                ->setColumn('13'),
                            (new Error())
                                ->setMessage('Unnecessary semicolon. (no-extra-semi)')
                                ->setSource('eslint.rules.no-extra-semi')
                                ->setLine(777)
                                ->setColumn('2'),
                        ]
                    )
                )
        );
        $expected->add(
            (new Report())
                ->setFilename('src/Entity/Email.php')
                ->setErrors(
                    new ArrayCollection(
                        [
                            (new Error())
                                ->setMessage('Found violation(s) of type: php_basic_comment_php_doc_on_properties')
                                ->setSource('PHP-CS-Fixer.php_basic_comment_php_doc_on_properties')
                                ->setLine(0)
                                ->setColumn(''),
                            (new Error())
                                ->setMessage('Found violation(s) of type: php_basic_code_style_directory_and_namespace')
                                ->setSource('PHP-CS-Fixer.php_basic_code_style_directory_and_namespace')
                                ->setLine(0)
                                ->setColumn(''),
                        ]
                    )
                )
        );

        return $expected;
    }

    private function getCheckstyleFile()
    {
        return new ArrayCollection([
            'checkstyle' =>  [
                __DIR__ . '/Fixtures/checkstyle_fixer.xml'
            ]
        ]);
    }
}
