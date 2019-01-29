<?php

namespace webignition\HtmlValidatorOutput\Models;

use webignition\ValidatorMessage\MessageInterface;

class InfoMessage extends AbstractMessage
{
    public function __construct(string $message, string $messageId, string $explanation)
    {
        parent::__construct(MessageInterface::TYPE_INFO, $message, $messageId, $explanation);
    }
}
