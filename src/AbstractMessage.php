<?php

namespace webignition\HtmlValidatorOutput\Models;

use webignition\ValidatorMessage\AbstractMessage as BaseAbstractMessage;

abstract class AbstractMessage extends BaseAbstractMessage
{
    const KEY_MESSAGE_ID = 'messageId';

    private $messageId;

    public function __construct(string $type, string $message, string $messageId)
    {
        parent::__construct($type, $message);

        $this->messageId = $messageId;
    }

    public function getMessageId(): string
    {
        return $this->messageId;
    }

    /**
     * @param string $messageId
     * @return AbstractMessage|InfoMessage|ValidationErrorMessage
     */
    public function withMessageId(string $messageId): AbstractMessage
    {
        $new = clone $this;
        $new->messageId = $messageId;

        return $new;
    }

    public function jsonSerialize(): array
    {
        return array_merge(parent::jsonSerialize(), [
            self::KEY_MESSAGE_ID => $this->messageId,
        ]);
    }
}
