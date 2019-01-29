<?php

namespace webignition\HtmlValidatorOutput\Models\Tests;

use webignition\HtmlValidatorOutput\Models\ErrorMessage;

class ErrorMessageTest extends \PHPUnit\Framework\TestCase
{
    public function testCreate()
    {
        $message = 'message content';
        $messageId = 'html5';
        $explanation = 'explanation content';
        $lineNumber = 1;
        $columnNumber = 2;

        $errorMessage = new ErrorMessage($message, $messageId, $explanation, $lineNumber, $columnNumber);

        $this->assertEquals($message, $errorMessage->getMessage());
        $this->assertEquals($messageId, $errorMessage->getMessageId());
        $this->assertEquals($explanation, $errorMessage->getExplanation());
        $this->assertEquals($lineNumber, $errorMessage->getLineNumber());
        $this->assertEquals($columnNumber, $errorMessage->getColumnNumber());
        $this->assertEquals(
            [
                'type' => 'error',
                'message' => $message,
                'messageid' => $messageId,
                'explanation' => $explanation,
                'lastLine' => $lineNumber,
                'lastColumn' => $columnNumber,
            ],
            $errorMessage->jsonSerialize()
        );
    }
}
