<?php

namespace Paysera\Component\CodeClimateMerger\Service;

use Doctrine\Common\Collections\ArrayCollection;
use Exception;

class InputHandler
{
    private $supportedFormats;

    public function __construct(array $supportedFormats)
    {
        $this->supportedFormats = $supportedFormats;
    }

    public function handle(array $options)
    {
        $array = array_filter($options, function ($option) {
            return in_array($option, $this->supportedFormats, true);
        },
        ARRAY_FILTER_USE_KEY
        );

        $collection = new ArrayCollection($array);

        return $this->checkFiles($collection);
    }

    private function checkFiles(ArrayCollection $supportedFormats)
    {
        foreach ($supportedFormats as $supportedFormat) {
            foreach ($supportedFormat as $file) {
                if (!file_exists($file)) {
                    throw new Exception(sprintf('cannot locate file: %s', $file));
                }
            }
        }

        return $supportedFormats;
    }
}
