<?php

namespace Paysera\Component\CodeClimateMerger\Parser;

use Paysera\Component\CodeClimateMerger\Entity\Report;

interface ParserInterface
{
    /**
     * @param string $file
     * @return Report
     */
    public function parse(string $file);
}
