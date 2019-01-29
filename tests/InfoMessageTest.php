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

    public function testWithMessageId()
    {
        $message = 'message';
        $explanation = 'explanation';

        $originalMessageId = 'original-message-id';
        $updatedMessageId = 'updated-message-id';

        $infoMessage = new InfoMessage($message, $originalMessageId, $explanation);
        $mutatedInfoMessage = $infoMessage->withMessageId($updatedMessageId);

        $this->assertNotSame($infoMessage, $mutatedInfoMessage);
        $this->assertInstanceOf(InfoMessage::class, $mutatedInfoMessage);
        $this->assertEquals($message, $mutatedInfoMessage->getMessage());
        $this->assertEquals($updatedMessageId, $mutatedInfoMessage->getMessageId());

        if ($mutatedInfoMessage instanceof InfoMessage) {
            $this->assertEquals($explanation, $mutatedInfoMessage->getExplanation());
        }
    }
}
