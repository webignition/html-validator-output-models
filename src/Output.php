<?php

namespace webignition\HtmlValidatorOutput\Models;

use webignition\ValidatorMessage\MessageList;

class Output
{
    const VALIDATOR_INTERNAL_SERVER_ERROR_MESSAGE_ID = 'validator-internal-server-error';

    /**
     * @var bool
     */
    private $wasAborted = false;

    private $messages;

    public function __construct(MessageList $messages)
    {
        $this->messages = $messages;
    }

    public function setWasAborted(bool $wasAborted)
    {
        $this->wasAborted = $wasAborted;
    }

    public function getMessages(): MessageList
    {
        return $this->messages;
    }

    public function isValid(): bool
    {
        return 0 === $this->getErrorCount();
    }

    public function wasAborted(): bool
    {
        return $this->wasAborted;
    }

    public function getErrorCount(): int
    {
        return $this->messages->getErrorCount();
    }
}
