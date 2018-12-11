<?php

namespace SlackNotifier\Entry;

use Monolog\Logger;
use SlackNotifier\Config;

class ErrorEntry extends AbstractEntry
{
    public function getHookUrl() : string
    {
        return Config::getHookUrl(Logger::ERROR);
    }

    public function getTitle() : string
    {
        return 'An error on the server!';
    }

    public function getColor() : string
    {
        return 'warning';
    }

    public function getIcon() : string
    {
        return ':thinking_face:';
    }
}
