<?php

namespace SlackNotifier\Entry;

use SlackNotifier\Config;

class DefaultEntry extends AbstractEntry
{
    public function getHookUrl() : string
    {
        return Config::getDefaultHookUrl();
    }

    public function getTitle() : string
    {
        return 'A loggable action';
    }

    public function getColor() : string
    {
        return 'default';
    }

    public function getIcon() : string
    {
        return ':book:';
    }
}
