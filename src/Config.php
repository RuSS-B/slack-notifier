<?php

namespace SlackNotifier;

use Monolog\Logger;

class Config
{
    private $levels;

    public function __construct()
    {
        $levels = Logger::getLevels();

        foreach ($levels as $levelName => $level) {
            $this->levels[$level] = getenv("SLACK_NOTIFIER_{$levelName}_HOOK") ?: self::getDefaultHookUrl();
        }
    }

    /**
     * @param int $level
     *
     * @return string
     */
    public function getByLevel(int $level) : string
    {
        if (!isset($this->levels[$level])) {
            throw new \InvalidArgumentException(sprintf('Unknown level passed: %d', $level));
        }

        return $this->levels[$level];
    }

    /**
     * @param int $level
     *
     * @return string
     */
    public static function getHookUrl(int $level) : string
    {
        return (new self())->getByLevel($level);
    }

    /**
     * @return string
     */
    public static function getDefaultHookUrl() : string
    {
        return getenv('SLACK_NOTIFIER_DEFAULT_HOOK_URL');
    }
}
