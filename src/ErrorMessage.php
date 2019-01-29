<?php

namespace webignition\HtmlValidatorOutput\Models;

use webignition\ValidatorMessage\MessageInterface;

class ErrorMessage extends AbstractMessage
{
    public function __construct(string $message, string $messageId, string $explanation)
    {
        parent::__construct(MessageInterface::TYPE_ERROR, $message, $messageId, $explanation);
    }
}
