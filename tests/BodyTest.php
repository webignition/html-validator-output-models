<?php

namespace webignition\HtmlValidatorOutput\Models\Tests;

use webignition\HtmlValidatorOutput\Models\Body;

class BodyTest extends \PHPUnit\Framework\TestCase
{
    public function testHasContentNoContent()
    {
        $body = new Body();
        $this->assertFalse($body->hasContent());
    }

    public function testHasContentWithContent()
    {
        $body = new Body();
        $body->setContent(new \stdClass());
        $this->assertTrue($body->hasContent());
    }

    public function testGetContentNoContent()
    {
        $body = new Body();
        $this->assertNull($body->getContent());
    }

    public function testGetContentWithContent()
    {
        $content = new \stdClass();

        $body = new Body();
        $body->setContent($content);
        $this->assertSame($content, $body->getContent());
    }

    public function testGetMessagesNoContent()
    {
        $body = new Body();
        $this->assertEquals([], $body->getMessages());
    }

    public function testGetMessagesHasContent()
    {
        $messages = [];

        $content = (object)[
            'messages' => $messages,
        ];

        $body = new Body();
        $body->setContent($content);
        $this->assertEquals($messages, $body->getMessages());
    }
}
