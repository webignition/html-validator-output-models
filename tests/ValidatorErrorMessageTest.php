<?php

namespace webignition\HtmlValidatorOutput\Models\Tests;

use webignition\HtmlValidatorOutput\Models\ValidatorErrorMessage;

class ValidatorErrorMessageTest extends \PHPUnit\Framework\TestCase
{
    public function testCreate()
    {
        $message = 'Sorry, this document can\'t be checked';
        $messageId = 'validator-internal-server-error';

        $errorMessage = new ValidatorErrorMessage($message, $messageId);

        $this->assertEquals($message, $errorMessage->getMessage());
        $this->assertEquals($messageId, $errorMessage->getMessageId());
        $this->assertEquals(
            [
                'type' => 'error',
                'message' => $message,
                'messageid' => $messageId,
            ],
            $errorMessage->jsonSerialize()
        );
    }
}
