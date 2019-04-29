<?php
declare(strict_types=1);

namespace Paysera\Component\CodeClimateMerger\Service;

use Paysera\Component\CodeClimateMerger\Entity\Error;

class FingerprintGenerator
{
    public function generate(string $filename, Error $error)
    {
        return md5(sprintf('%s%s%s', $filename, $error->getSource(), $error->getLine()));
    }
}
