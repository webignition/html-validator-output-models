<?php

namespace webignition\HtmlValidatorOutput\Models\Tests;

use webignition\HtmlValidatorOutput\Models\InfoMessage;

class InfoMessageTest extends \PHPUnit\Framework\TestCase
{
    public function testCreate()
    {
        $message = 'message content';
        $messageId = 'html5';
        $explanation = 'explanation content';

        $infoMessage = new InfoMessage($message, $messageId, $explanation);

        $this->assertEquals($message, $infoMessage->getMessage());
        $this->assertEquals($messageId, $infoMessage->getMessageId());
        $this->assertEquals($explanation, $infoMessage->getExplanation());
        $this->assertEquals(
            [
                'type' => 'info',
                'message' => $message,
                'messageid' => $messageId,
                'explanation' => $explanation,
            ],
            $infoMessage->jsonSerialize()
        );
    }
}
