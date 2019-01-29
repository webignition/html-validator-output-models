<?php

namespace webignition\HtmlValidatorOutput\Models;

abstract class AbstractIssueMessage extends AbstractMessage
{
    const KEY_EXPLANATION = 'explanation';

    private $explanation;

    public function __construct(string $type, string $message, string $messageId, string $explanation)
    {
        parent::__construct($type, $message, $messageId);

        $this->explanation = $explanation;
    }

    public function getExplanation(): string
    {
        return $this->explanation;
    }

    public function jsonSerialize(): array
    {
        return array_merge(parent::jsonSerialize(), [
            self::KEY_EXPLANATION => $this->explanation,
        ]);
    }
}
