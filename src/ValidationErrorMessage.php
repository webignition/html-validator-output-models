<?php

namespace webignition\HtmlValidatorOutput\Models;

use webignition\ValidatorMessage\MessageInterface;

class ValidationErrorMessage extends AbstractIssueMessage
{
    const KEY_LINE_NUMBER = 'lastLine';
    const KEY_COLUMN_NUMBER = 'lastColumn';

    private $lineNumber;
    private $columnNumber;

    public function __construct(
        string $message,
        string $messageId,
        string $explanation,
        int $lineNumber,
        int $columnNumber
    ) {
        parent::__construct(MessageInterface::TYPE_ERROR, $message, $messageId, $explanation);

        $this->lineNumber = $lineNumber;
        $this->columnNumber = $columnNumber;
    }

    public function getLineNumber(): int
    {
        return $this->lineNumber;
    }

    public function getColumnNumber(): int
    {
        return $this->columnNumber;
    }

    public function jsonSerialize(): array
    {
        return array_merge(parent::jsonSerialize(), [
            self::KEY_LINE_NUMBER => $this->lineNumber,
            self::KEY_COLUMN_NUMBER => $this->columnNumber,
        ]);
    }
}
