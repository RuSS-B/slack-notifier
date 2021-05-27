<?php

namespace SlackNotifier\Handler;

use Monolog\Handler\AbstractHandler;

use Monolog\Logger;
use SlackNotifier\Entry\CriticalEntry;
use SlackNotifier\Entry\DefaultEntry;
use SlackNotifier\Entry\EntryInterface;
use SlackNotifier\Entry\ErrorEntry;
use SlackNotifier\Entry\InfoEntry;
use SlackNotifier\Entry\WarningEntry;
use SlackNotifier\Record;
use SlackNotifier\Transport;

class Handler extends AbstractHandler
{
    /**
     * @var Transport
     */
    private $transport;

    private $config;

    public function __construct($level = Logger::DEBUG, bool $bubble = true)
    {
        parent::__construct($level, $bubble);

        $this->config = $config;
        $this->transport = new Transport();
    }

    public function handle(array $record): bool
    {
        $record = new Record($record);

        if (isset($this->config['skipHttpCodes']) && is_array($this->config['skipHttpCodes'])) {
            $statusCode = $record->getHttpStatusCode();

            if (in_array($statusCode, $this->config['skipHttpCodes'])) {
                return false;
            }
        }

        if (!$record->isDefaultEntry()) {
            $instance = $record->getEntryType();
            $entry = new $instance($record);
        } else {
            $entry = $this->createDefaultEntry($record);
        }

        $this->transport->addEntry($entry);
    }

    /**
     * @param Record $record
     *
     * @return EntryInterface
     */
    private function createDefaultEntry(Record $record) : EntryInterface
    {
        switch ($record->getLevel()) {
            case Logger::CRITICAL :
                $entry = new CriticalEntry($record);
                break;
            case Logger::ERROR :
                $entry = new ErrorEntry($record);
                break;
            case Logger::WARNING :
                $entry = new WarningEntry($record);
                break;
            case Logger::INFO :
                $entry = new InfoEntry($record);
                break;
            default :
                $entry = new DefaultEntry($record);
        }

        return $entry;
    }

    public function close(): void
    {
        parent::close();
        $this->transport->send();
    }
}
