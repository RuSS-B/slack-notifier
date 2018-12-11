<?php

namespace SlackNotifier;

use Symfony\Component\HttpFoundation\Request;
use Monolog\Logger;

class Record
{
    /**
     * @var array
     */
    private $record;

    /**
     * @var Request
     */
    private $request;

    public function __construct(array $record)
    {
        $this->record  = $record;
        $this->request = Request::createFromGlobals();
    }

    public function isError() : bool
    {
        return (int) $this->record['level'] === Logger::ERROR;
    }

    public function isCritical() : bool
    {
        return (int) $this->record['level'] === Logger::CRITICAL;
    }

    public function isWarning() : bool
    {
        return (int) $this->record['level'] === Logger::WARNING;
    }

    public function isInfo() : bool
    {
        return (int) $this->record['level'] === Logger::INFO;
    }

    public function isDebug() : bool
    {
        return (int) $this->record['level'] === Logger::DEBUG;
    }

    public function getLevel()
    {
        return (int) $this->record['level'];
    }

    public function getChannel()
    {
        return (int) $this->record['channel'];
    }

    public function isDefaultEntry() : bool
    {
        return true;
    }


    public function getMessage() : string
    {
        return $this->record['message'];
    }

    /**
     * @return string
     */
    public function getRequestUrl() : string
    {
        return $this->request->getRequestUri();
    }

    /**
     * @return string
     */
    public function getRequestMethod() : string
    {
        return $this->request->getMethod();
    }

    /**
     * @return string
     */
    public function getBodyContent() :? string
    {
        return $this->request->getContent();
    }

    /**
     * @return array
     */
    public function getRequestParams() : array
    {
        return $this->request->request->all();
    }

    /**
     * @return array
     */
    public function getAttachments() : array
    {
        return $this->record['context']['attachments'] ?? [];
    }

    /**
     * @return array
     */
    public function getFields() : array
    {
        return $this->record['context']['fields'] ?? [];
    }

    /**
     * @return null|string
     */
    public function getEntryType() :? string
    {
        return $this->record['context']['entryType'] ?? null;
    }

    public function getContext() : array
    {
        return $this->record['context'];
    }

    /**
     * @return bool
     */
    public function isConsole() : bool
    {
        return $this->record['channel'] === 'console';
    }

    /**
     * @return bool
     */
    public function hasException() : bool
    {
        return isset($this->record['context']['exception']) && $this->record['context']['exception'] instanceof \Exception;
    }

    /**
     * @return \Exception
     */
    public function getException() : \Exception
    {
        return $this->record['context']['exception'];
    }
}
