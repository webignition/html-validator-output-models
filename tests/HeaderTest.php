<?php

namespace webignition\HtmlValidatorOutput\Models\Tests;

use webignition\HtmlValidatorOutput\Models\Header;

class HeaderTest extends \PHPUnit\Framework\TestCase
{
    public function testSetGet()
    {
        $header = new Header();
        $header->set('key1', 'value1');
        $header->set('key2', 'value2');

        $this->assertEquals('value1', $header->get('key1'));
        $this->assertEquals('value2', $header->get('key2'));
    }
}
