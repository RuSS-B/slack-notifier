<?php


namespace SlackNotifier\Entry;

use Monolog\Logger;
use SlackNotifier\Config;

class WarningEntry extends AbstractEntry
{
    public function getHookUrl() : string
    {
        return Config::getHookUrl(Logger::WARNING);
    }

    public function getTitle() : string
    {
        return 'Warning!';
    }

    public function getColor() : string
    {
        return 'warning';
    }

    public function getIcon() : string
    {
        return ':open_mouth:';
    }
}
