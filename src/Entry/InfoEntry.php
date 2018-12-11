<?php


namespace SlackNotifier\Entry;

use Monolog\Logger;
use SlackNotifier\Config;

class InfoEntry extends AbstractEntry
{
    public function getHookUrl() : string
    {
        return Config::getHookUrl(Logger::INFO);
    }

    public function getTitle() : string
    {
        return 'Info log';
    }

    public function getColor() : string
    {
        return 'good';
    }

    public function getIcon() : string
    {
        return ':blush:';
    }
}
