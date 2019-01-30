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

    /**
     * @var bool
     */
    private $isValid = true;

    private $messages;

    public function __construct(MessageList $messages)
    {
        $this->messages = $messages;
    }

    public function setWasAborted(bool $wasAborted)
    {
        $this->wasAborted = $wasAborted;
    }

    public function setIsValid(bool $isValid)
    {
        $this->isValid = $isValid;
    }

    public function getMessages(): MessageList
    {
        return $this->messages;
    }

    public function isValid(): bool
    {
        if (false === $this->isValid) {
            return false;
        }

        return 0 === $this->getErrorCount();
    }

    public function wasAborted(): bool
    {
        return $this->wasAborted;
    }

    public function getErrorCount(): int
    {
        if (0 === $this->messages->getMessageCount()) {
            return 0;
        }

        $messages = array_values($this->messages->getMessages());
        $firstMessage = $messages[0];

        if ($firstMessage instanceof ValidatorErrorMessage &&
            self::VALIDATOR_INTERNAL_SERVER_ERROR_MESSAGE_ID === $firstMessage->getMessageId()) {
            return 0;
        }

        return $this->messages->getErrorCount();
    }
}
