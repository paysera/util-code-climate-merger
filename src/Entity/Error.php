<?php
declare(strict_types=1);

namespace Paysera\Component\CodeClimateMerger\Entity;

class Error
{
    /**
     * @var int
     */
    private $line;

    /**
     * @var string
     */
    private $column;

    /**
     * @var string
     */
    private $message;

    /**
     * @var string
     */
    private $source;

    /**
     * @return string
     */
    public function getLine()
    {
        return $this->line;
    }

    /**
     * @param int $line
     * @return $this
     */
    public function setLine(int $line)
    {
        $this->line = $line;
        return $this;
    }

    /**
     * @return string
     */
    public function getColumn()
    {
        return $this->column;
    }

    /**
     * @param string $column
     * @return $this
     */
    public function setColumn(string $column)
    {
        $this->column = $column;
        return $this;
    }

    /**
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @param string $message
     * @return $this
     */
    public function setMessage(string $message)
    {
        $this->message = $message;
        return $this;
    }

    /**
     * @return string
     */
    public function getSource()
    {
        return $this->source;
    }

    /**
     * @param string $source
     * @return $this
     */
    public function setSource(string $source)
    {
        $this->source = $source;
        return $this;
    }
}
