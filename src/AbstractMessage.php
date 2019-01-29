<?php

namespace webignition\HtmlValidatorOutput\Models;

use webignition\ValidatorMessage\AbstractMessage as BaseAbstractMessage;

abstract class AbstractMessage extends BaseAbstractMessage
{
    const KEY_MESSAGE_ID = 'messageid';
    const KEY_EXPLANATION = 'explanation';

    private $messageId;
    private $explanation;

    public function __construct(string $type, string $message, string $messageId, string $explanation)
    {
        parent::__construct($type, $message);

        $this->messageId = $messageId;
        $this->explanation = $explanation;
    }

    public function getMessageId(): string
    {
        return $this->messageId;
    }

    public function getExplanation(): string
    {
        return $this->explanation;
    }

    public function jsonSerialize(): array
    {
        return array_merge(parent::jsonSerialize(), [
            self::KEY_MESSAGE_ID => $this->messageId,
            self::KEY_EXPLANATION => $this->explanation,
        ]);
    }
}
