<?php

namespace SlackNotifier\Entry;

interface EntryInterface
{
    public function getHookUrl() : string;

    public function getTitle() : string;

    public function getColor() : string;

    public function getIcon() : string;

    public function getMessage() : array;
}
