<?php

namespace webignition\HtmlValidatorOutput\Models\Tests;

use webignition\HtmlValidatorOutput\Models\ValidationErrorMessage;

class ValidationErrorMessageTest extends \PHPUnit\Framework\TestCase
{
    public function testCreate()
    {
        $message = 'An img element must have an alt attribute, except under certain conditions.';
        $messageId = 'html5';
        $explanation = 'image missing alt attribute explanation';
        $lineNumber = 1;
        $columnNumber = 2;

        $errorMessage = new ValidationErrorMessage($message, $messageId, $explanation, $lineNumber, $columnNumber);

        $this->assertEquals($message, $errorMessage->getMessage());
        $this->assertEquals($messageId, $errorMessage->getMessageId());
        $this->assertEquals($explanation, $errorMessage->getExplanation());
        $this->assertEquals($lineNumber, $errorMessage->getLineNumber());
        $this->assertEquals($columnNumber, $errorMessage->getColumnNumber());
        $this->assertEquals(
            [
                'type' => 'error',
                'message' => $message,
                'messageId' => $messageId,
                'explanation' => $explanation,
                'lastLine' => $lineNumber,
                'lastColumn' => $columnNumber,
            ],
            $errorMessage->jsonSerialize()
        );
    }

    public function testWithMessageId()
    {
        $message = 'message';
        $explanation = 'explanation';
        $lineNumber = 1;
        $columnNumber = 2;

        $originalMessageId = 'original-message-id';
        $updatedMessageId = 'updated-message-id';

        $errorMessage = new ValidationErrorMessage(
            $message,
            $originalMessageId,
            $explanation,
            $lineNumber,
            $columnNumber
        );
        $mutatedErrorMessage = $errorMessage->withMessageId($updatedMessageId);

        $this->assertNotSame($errorMessage, $mutatedErrorMessage);
        $this->assertInstanceOf(ValidationErrorMessage::class, $mutatedErrorMessage);
        $this->assertEquals($message, $mutatedErrorMessage->getMessage());
        $this->assertEquals($updatedMessageId, $mutatedErrorMessage->getMessageId());

        if ($mutatedErrorMessage instanceof ValidationErrorMessage) {
            $this->assertEquals($explanation, $mutatedErrorMessage->getExplanation());
            $this->assertEquals($lineNumber, $mutatedErrorMessage->getLineNumber());
            $this->assertEquals($columnNumber, $mutatedErrorMessage->getColumnNumber());
        }
    }
}
