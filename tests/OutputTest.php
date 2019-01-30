<?php
/** @noinspection PhpDocSignatureInspection */

namespace webignition\HtmlValidatorOutput\Models\Tests;

use webignition\HtmlValidatorOutput\Models\InfoMessage;
use webignition\HtmlValidatorOutput\Models\Output;
use webignition\HtmlValidatorOutput\Models\ValidationErrorMessage;
use webignition\HtmlValidatorOutput\Models\ValidatorErrorMessage;
use webignition\ValidatorMessage\MessageList;

class OutputTest extends \PHPUnit\Framework\TestCase
{
    public function testGetMessages()
    {
        $messageList = new MessageList();

        $output = new Output($messageList);
        $this->assertSame($messageList, $output->getMessages());
    }

    /**
     * @dataProvider isValidByErrorCountDataProvider
     */
    public function testIsValidByErrorCount(Output $output, bool $expectedIsValid)
    {
        $this->assertEquals($expectedIsValid, $output->isValid());
    }

    public function isValidByErrorCountDataProvider(): array
    {
        return [
            'validator internal server error' => [
                'output' => new Output(new MessageList([
                    new ValidatorErrorMessage(
                        'Sorry, this document can\'t be checked',
                        'validator-internal-server-error'
                    )
                ])),
                'expectedIsValid' => true,
            ],
            'info messages only' => [
                'output' => new Output(new MessageList([
                    new InfoMessage('info message 1', 'html5', 'explanation'),
                    new InfoMessage('info message 2', 'html5', 'explanation'),
                ])),
                'expectedIsValid' => true,
            ],
            'error messages only' => [
                'output' => new Output(new MessageList([
                    new ValidationErrorMessage('error message 1', 'html5', 'explanation', 1, 2),
                    new ValidationErrorMessage('error message 2', 'html5', 'explanation', 3, 4),
                ])),
                'expectedIsValid' => false,
            ],
            'info messages and error messages' => [
                'output' => new Output(new MessageList([
                    new ValidationErrorMessage('error message 1', 'html5', 'explanation', 1, 2),
                    new ValidationErrorMessage('error message 2', 'html5', 'explanation', 3, 4),
                    new InfoMessage('info message 1', 'html5', 'explanation'),
                ])),
                'expectedIsValid' => false,
            ],
        ];
    }

    public function testIsValidByValidity()
    {
        $output = new Output(new MessageList());

        $this->assertTrue($output->isValid());

        $output->setIsValid(false);
        $this->assertFalse($output->isValid());

        $output->setIsValid(true);
        $this->assertTrue($output->isValid());
    }

    public function testWasAborted()
    {
        $output = new Output(new MessageList());

        $this->assertFalse($output->wasAborted());

        $output->setWasAborted(true);
        $this->assertTrue($output->wasAborted());

        $output->setWasAborted(false);
        $this->assertFalse($output->wasAborted());
    }

    /**
     * @dataProvider getErrorCountDataProvider
     */
    public function testGetErrorCount(Output $output, int $expectedErrorCount)
    {
        $this->assertEquals($expectedErrorCount, $output->getErrorCount());
    }

    public function getErrorCountDataProvider(): array
    {
        return [
            'no messages' => [
                'output' => new Output(new MessageList()),
                'expectedErrorCount' => 0,
            ],
            'validator internal server error' => [
                'output' => new Output(new MessageList([
                    new ValidatorErrorMessage(
                        'Sorry, this document can\'t be checked',
                        'validator-internal-server-error'
                    )
                ])),
                'expectedErrorCount' => 0,
            ],
            'info messages only' => [
                'output' => new Output(new MessageList([
                    new InfoMessage('info message 1', 'html5', 'explanation'),
                    new InfoMessage('info message 2', 'html5', 'explanation'),
                ])),
                'expectedErrorCount' => 0,
            ],
            'error messages only' => [
                'output' => new Output(new MessageList([
                    new ValidationErrorMessage('error message 1', 'html5', 'explanation', 1, 2),
                    new ValidationErrorMessage('error message 2', 'html5', 'explanation', 3, 4),
                ])),
                'expectedErrorCount' => 2,
            ],
            'info messages and error messages' => [
                'output' => new Output(new MessageList([
                    new ValidationErrorMessage('error message 1', 'html5', 'explanation', 1, 2),
                    new ValidationErrorMessage('error message 2', 'html5', 'explanation', 3, 4),
                    new InfoMessage('info message 1', 'html5', 'explanation'),
                ])),
                'expectedErrorCount' => 2,
            ],
        ];
    }
}
