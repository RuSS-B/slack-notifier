<?php

namespace SlackNotifier\Entry;

use SlackNotifier\Handler\Attachment;
use SlackNotifier\Handler\Field;
use SlackNotifier\Record;

abstract class AbstractEntry implements EntryInterface, \JsonSerializable
{
    /**
     * @var Record
     */
    private $record;

    /**
     * @var Attachment[]
     */
    private $attachments = [];

    private $message;

    public function __construct(Record $record)
    {
        $this->record = $record;
        $this->beforeBuildMessage();
        $this->buildMessage();
    }

    /**
     * @param Attachment $attachment
     *
     * @return $this
     */
    public function addAttachment(Attachment $attachment)
    {
        $this->attachments[] = $attachment;

        return $this;
    }

    protected function beforeBuildMessage()
    {
        $this->addRequestData();
        $this->handleAttachments();
        $this->handleException();
    }

    protected function buildMessage() : void
    {
        $data = [
            'text'       => $this->getTitle(),
            'color'      => $this->getColor(),
            'icon_emoji' => $this->getIcon(),
        ];

        foreach ($this->attachments as $attachment) {
            $fields = [];

            foreach ($attachment->getFields() as $field) {
                $fields[] = [
                    'title' => $field->getTitle(),
                    'value' => $field->getValue(),
                    'short' => $field->isShort(),
                ];
            }

            $data['attachments'][] = [
                'color'  => $this->getColor(),
                'fields' => $fields
            ];
        }

        $this->message = $data;
    }

    public function getMessage() : array
    {
        return $this->message;
    }

    public function jsonSerialize()
    {
        return $this->getMessage();
    }

    protected function handleAttachments()
    {
        foreach ($this->record->getAttachments() as $attachment) {
            $this->addAttachment($attachment);
        }
    }

    protected function addRequestData()
    {
        $attachment = new Attachment($this->getColor());

        if (!$this->record->isConsole()) {
            $attachment->addField(new Field('Message', $this->record->getMessage()));
            $attachment->addField(new Field('Request URL', $this->record->getRequestUrl(), true));
            $attachment->addField(new Field('Request Method', $this->record->getRequestMethod(), true));

            if ($this->record->getBodyContent()) {
                $attachment->addField(new Field('Body', $this->record->getBodyContent()));
            }

            if ($this->record->getRequestParams()) {
                $attachment->addField(new Field('Params', json_encode($this->record->getRequestParams())));
            }

        } else {
            $command = $this->record->getFromContext('command');
            $errMsg  = $this->record->getFromContext('message');
            $message = str_replace(['{command}', '{message}'], [$command, $errMsg], $this->record->getMessage());

            $attachment->addField(new Field('Message', $message));
        }

        $this->addAttachment($attachment);
    }

    protected function handleException()
    {
        if ($this->record->hasException()) {
            $e = $this->record->getException();

            $attachment = new Attachment($this->getColor());
            $attachment
                ->addField(new Field('Exception', $e->getMessage()))
                ->addField(new Field('Line', $e->getLine(), true))
                ->addField(new Field('File', $e->getFile(), true));

            $this->addAttachment($attachment);
        }
    }
}
