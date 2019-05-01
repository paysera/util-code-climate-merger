<?php

namespace Paysera\Component\CodeClimateMerger\Parser;

use Doctrine\Common\Collections\ArrayCollection;
use Exception;

class ParserManager
{
    /**
     * @var ParserInterface[]
     */
    private $parsers;

    public function __construct()
    {
        $this->parsers = [];
    }

    public function addParser(ParserInterface $parser, string $format)
    {
        $this->parsers[$format] = $parser;
    }

    public function manageParsing(ArrayCollection $filesCollection)
    {
        $collection = new ArrayCollection();
        foreach($filesCollection as $format => $files) {
            if (!$this->parsers[$format]) {
                throw new Exception('No parser found for %s', $format);
            }
            foreach ($files as $file) {
                $collection->add($this->parsers[$format]->parse($file));
            }
        }

        return $collection;
    }
}
