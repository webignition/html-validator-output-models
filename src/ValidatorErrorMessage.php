<?php

namespace webignition\HtmlValidatorOutput\Models;

use webignition\ValidatorMessage\MessageInterface;

class ValidatorErrorMessage extends AbstractMessage
{
    public function __construct(string $message, string $messageId)
    {
        parent::__construct(MessageInterface::TYPE_ERROR, $message, $messageId);
    }
}
