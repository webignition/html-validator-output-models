<?php

namespace webignition\HtmlValidatorOutput\Models;

use webignition\ValidatorMessage\MessageInterface;

class InfoMessage extends AbstractIssueMessage
{
    public function __construct(string $message, ?string $messageId = null, ?string $explanation = null)
    {
        $messageId = $messageId ?? '';
        $explanation = $explanation ?? '';

        parent::__construct(MessageInterface::TYPE_INFO, $message, $messageId, $explanation);
    }
}
