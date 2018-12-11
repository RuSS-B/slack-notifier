<?php

namespace SlackNotifier;

use SlackNotifier\Entry\EntryInterface;

use GuzzleHttp\Client;

class Transport
{
    /**
     * @var EntryInterface[] $entries
     */
    private $entries = [];

    private $guzzle;

    public function __construct()
    {
        $this->guzzle = new Client();
    }

    public function addEntry(EntryInterface $entry)
    {
        $this->entries[] = $entry;
    }

    public function send() : void
    {
        if (!count($this->entries)) {
            return;
        }

        foreach ($this->entries as $entry) {
            $this->doRequest($entry->getHookUrl(), $entry);
        }
    }

    private function doRequest(string $url, EntryInterface $entry)
    {
        $this->guzzle->request('POST', $url, [
            'body' => json_encode($entry)
        ]);
    }
}
