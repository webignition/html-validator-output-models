<?php
/** @noinspection PhpDocSignatureInspection */

namespace webignition\HtmlValidatorOutput\Models\Tests;

use webignition\HtmlValidatorOutput\Models\InfoMessage;

class InfoMessageTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @dataProvider createDataProvider
     */
    public function testCreate(string $message, string $messageId, ?string $explanation)
    {
        $infoMessage = new InfoMessage($message, $messageId, $explanation);

        $this->assertEquals($message, $infoMessage->getMessage());
        $this->assertEquals($messageId, $infoMessage->getMessageId());
        $this->assertEquals($explanation, $infoMessage->getExplanation());
        $this->assertEquals(
            [
                'type' => 'info',
                'message' => $message,
                'messageId' => $messageId,
                'explanation' => $explanation,
            ],
            $infoMessage->jsonSerialize()
        );
    }

    public function createDataProvider()
    {
        return [
            'with explanation' => [
                'message' => 'message content',
                'messageId' => 'html5',
                'explanation' => 'explanation content',
            ],
            'without explanation' => [
                'message' => 'message content',
                'messageId' => 'html5',
                'explanation' => null,
            ],
        ];
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
