<?php

namespace SlackNotifier\Handler;

use Monolog\Handler\AbstractHandler;

use Monolog\Logger;
use SlackNotifier\Entry\CriticalEntry;
use SlackNotifier\Entry\DefaultEntry;
use SlackNotifier\Entry\EntryInterface;
use SlackNotifier\Record;
use SlackNotifier\Transport;

class Handler extends AbstractHandler
{
    /**
     * @var Transport
     */
    private $transport;

    public function __construct($level = Logger::WARNING, $bubble = true)
    {
        parent::__construct($level, $bubble);

        $this->transport = new Transport();
    }

    public function handle(array $record)
    {
        $record = new Record($record);

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
            default :
                $entry = new DefaultEntry($record);
        }

        return $entry;
    }

    public function close()
    {
        parent::close();
        $this->transport->send();
    }
}
