<?php

namespace SlackNotifier\Handler;

class Field
{
    /**
     * @var string
     */
    private $title;

    /**
     * @var string|null
     */
    private $value;

    /**
     * @var bool
     */
    private $short;

    public function __construct(string $title, ?string $value, bool $short = false)
    {
        $this->title = $title;
        $this->value = $value;
        $this->short = $short;
    }

    /**
     * @return string
     */
    public function getTitle() : string
    {
        return $this->title;
    }

    /**
     * @return string|null
     */
    public function getValue() : ?string
    {
        return $this->value;
    }

    /**
     * @return bool
     */
    public function isShort() : bool
    {
        return $this->short;
    }
}
