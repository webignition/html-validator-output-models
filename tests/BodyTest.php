<?php

namespace webignition\HtmlValidatorOutput\Models\Tests;

use webignition\HtmlValidatorOutput\Models\Body;

class BodyTest extends \PHPUnit\Framework\TestCase
{
    public function testGetMessagesWithNoContent()
    {
        $body = new Body();
        $this->assertEquals([], $body->getMessages());
    }
}
