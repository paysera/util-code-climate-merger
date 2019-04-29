<?php
declare(strict_types=1);

namespace Paysera\Component\CodeClimateMerger\Entity;

use Doctrine\Common\Collections\ArrayCollection;

class Report
{
    /**
     * @var string
     */
    private $filename;

    /**
     * @var ArrayCollection|Error[]
     */
    private $errors;

    public function __construct()
    {
        $this->errors = new ArrayCollection();
    }

    /**
     * @return string
     */
    public function getFilename()
    {
        return $this->filename;
    }

    /**
     * @param string $filename
     * @return $this
     */
    public function setFilename(string $filename)
    {
        $this->filename = $filename;
        return $this;
    }

    /**
     * @return ArrayCollection|Error[]
     */
    public function getErrors()
    {
        return $this->errors;
    }

    /**
     * @param ArrayCollection|Error[] $errors
     * @return $this
     */
    public function setErrors(ArrayCollection $errors)
    {
        $this->errors = $errors;
        return $this;
    }

    /**
     * @param Error $error
     * @return $this
     */
    public function addError(Error $error)
    {
        $this->errors->add($error);
        return $this;
    }
}
