<?php

namespace webignition\HtmlValidatorOutput\Models;

class Output
{
    const TYPE_ERROR = 'error';

    const VALIDATOR_INTERNAL_SERVER_ERROR_MESSAGE_ID = 'validator-internal-server-error';

    /**
     * @var Header
     */
    private $header;

    /**
     * @var Body
     */
    private $body;

    /**
     * @var bool
     */
    private $wasAborted = false;

    public function __construct(Header $header, Body $body)
    {
        $this->header = $header;
        $this->body = $body;
    }

    public function setWasAborted(bool $wasAborted)
    {
        $this->wasAborted = $wasAborted;
    }

    public function getMessages(): array
    {
        return $this->body->getMessages();
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
        $errorCount = 0;

        foreach ($this->getMessages() as $message) {
            if (isset($message->messageId) && $message->messageId == self::VALIDATOR_INTERNAL_SERVER_ERROR_MESSAGE_ID) {
                return 0;
            }

            if (isset($message->type) && $message->type == self::TYPE_ERROR) {
                $errorCount++;
            }
        }

        return $errorCount;
    }
}
