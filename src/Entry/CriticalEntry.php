<?php

namespace SlackNotifier\Entry;

use Monolog\Logger;
use SlackNotifier\Config;

class CriticalEntry extends AbstractEntry
{
    public function getHookUrl() : string
    {
        return Config::getHookUrl(Logger::CRITICAL);
    }

    public function getTitle() : string
    {
        return 'A critical error on server!';
    }

    public function getColor() : string
    {
        return 'danger';
    }

    public function getIcon() : string
    {
        return ':cry:';
    }
}
