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
        $rootElement = new SimpleXMLElement(file_get_contents($file));
        $reportCollection = new ArrayCollection();

        foreach ($rootElement->children() as $element) {
            $report = new Report();
            $report->setFilename((string)$element['name']);
            foreach ($element->children() as $child) {
                $error = new Error();
                $error
                    ->setLine((int)$child['line'])
                    ->setColumn((string)$child['column'])
                    ->setSeverity((string)$child['severity'])
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
