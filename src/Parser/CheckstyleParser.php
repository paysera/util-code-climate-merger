<?php
declare(strict_types=1);

namespace Paysera\Component\CodeClimateMerger\Parser;

use Doctrine\Common\Collections\ArrayCollection;
use Paysera\Component\CodeClimateMerger\Entity\Error;
use Paysera\Component\CodeClimateMerger\Entity\Report;
use SimpleXMLElement;

class CheckstyleParser implements ParserInterface
{
    public function parse(string $file)
    {
        $contents = new SimpleXMLElement(file_get_contents($file));
        $reportCollection = new ArrayCollection();

        foreach ($contents as $element) {
            $report = new Report();
            $report->setFilename((string)$element['name']);
            foreach ($element->children() as $child) {
                $error = new Error();
                $error
                    ->setLine((string)$child['line'])
                    ->setColumn((string)$child['column'])
                    ->setMessage((string)$child['message'])
                    ->setSource((string)$child['source'])
                ;
                $report->addError($error);
            }
            $reportCollection->add($report);
        }

        return $reportCollection;
    }
}
