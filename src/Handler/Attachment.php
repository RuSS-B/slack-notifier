<?php

namespace SlackNotifier\Handler;

class Attachment
{
    /**
     * @var string
     */
    private $color;

    /**
     * @var array
     */
    private $fields = [];

    public function __construct(string $color)
    {
        $this->color  = $color;
    }

    /**
     * @return string
     */
    public function getColor() : string
    {
        return $this->color;
    }

    /**
     * @return Field[]
     */
    public function getFields() : array
    {
        return $this->fields;
    }

    public function addField(Field $field)
    {
        $this->fields[] = $field;

        return $this;
    }
}
