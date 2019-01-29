<?php
/** @noinspection PhpDocSignatureInspection */

namespace webignition\HtmlValidatorOutput\Models\Tests;

use A\B;
use webignition\HtmlValidatorOutput\Models\Body;
use webignition\HtmlValidatorOutput\Models\Header;
use webignition\HtmlValidatorOutput\Models\Output;

class OutputTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @dataProvider getMessagesDataProvider
     */
    public function testGetMessages(Body $body, array $expectedMessages)
    {
        $output = new Output(new Header(), $body);

        $this->assertEquals($expectedMessages, $output->getMessages());
    }

    public function getMessagesDataProvider(): array
    {
        return [
            'no messages' => [
                'body' => new Body(),
                'expectedMessages' => [],
            ],
            'has messages, empty' => [
                'body' => $this->createBodyWithContent((object)[
                    'messages' => [],
                ]),
                'expectedMessages' => [],
            ],
            'has messages, non-empty' => [
                'body' => $this->createBodyWithContent((object)[
                    'messages' => [
                        [
                            'lastLine' => 1,
                            'lastColumn' => 2,
                            'message' => 'foo',
                            'messageid' => 'html5',
                            'explanation' => 'foo explanation',
                            'type' => 'error',
                        ],
                    ],
                ]),
                'expectedMessages' => [
                    [
                        'lastLine' => 1,
                        'lastColumn' => 2,
                        'message' => 'foo',
                        'messageid' => 'html5',
                        'explanation' => 'foo explanation',
                        'type' => 'error',
                    ],
                ],
            ],
        ];
    }

    /**
     * @dataProvider isValidDataProvider
     */
    public function testIsValid(Header $header, bool $expectedIsValid)
    {
        $output = new Output($header, new Body());

        $this->assertEquals($expectedIsValid, $output->isValid());
    }

    public function isValidDataProvider(): array
    {
        return [
            'empty header' => [
                'header' => new Header(),
                'expectedIsValid' => false,
            ],
            'no status field' => [
                'header' => $this->createHeader([
                    'foo' => 'bar',
                ]),
                'expectedIsValid' => false,
            ],
            'null status field' => [
                'header' => $this->createHeader([
                    'status' => null,
                ]),
                'expectedIsValid' => false,
            ],
            'abort status field' => [
                'header' => $this->createHeader([
                    'status' => Output::STATUS_ABORT,
                ]),
                'expectedIsValid' => false,
            ],
            'invalid status field' => [
                'header' => $this->createHeader([
                    'status' => Output::STATUS_INVALID,
                ]),
                'expectedIsValid' => false,
            ],
            'valid status field' => [
                'header' => $this->createHeader([
                    'status' => Output::STATUS_VALID,
                ]),
                'expectedIsValid' => true,
            ],
        ];
    }

    /**
     * @dataProvider wasAbortedDataProvider
     */
    public function testWasAborted(Header $header, bool $expectedWasAborted)
    {
        $output = new Output($header, new Body());

        $this->assertEquals($expectedWasAborted, $output->wasAborted());
    }

    public function wasAbortedDataProvider(): array
    {
        return [
            'empty header' => [
                'header' => new Header(),
                'expectedWasAborted' => true,
            ],
            'no status field' => [
                'header' => $this->createHeader([
                    'foo' => 'bar',
                ]),
                'expectedWasAborted' => true,
            ],
            'null status field' => [
                'header' => $this->createHeader([
                    'status' => null,
                ]),
                'expectedWasAborted' => true,
            ],
            'abort status field' => [
                'header' => $this->createHeader([
                    'status' => Output::STATUS_ABORT,
                ]),
                'expectedWasAborted' => true,
            ],
            'invalid status field' => [
                'header' => $this->createHeader([
                    'status' => Output::STATUS_INVALID,
                ]),
                'expectedWasAborted' => false,
            ],
            'valid status field' => [
                'header' => $this->createHeader([
                    'status' => Output::STATUS_VALID,
                ]),
                'expectedWasAborted' => false,
            ],
        ];
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
            'validator internal server error' => [
                'output' => new Output(new Header(), $this->createBodyWithContent((object)[
                    'messages' => [
                        (object) [
                            'messageId' => Output::VALIDATOR_INTERNAL_SERVER_ERROR_MESSAGE_ID,
                        ],
                    ],
                ])),
                'expectedErrorCount' => 0,
            ],
            'info messages only' => [
                'output' => new Output(new Header(), $this->createBodyWithContent((object) [
                    'messages' => [
                        (object) [
                            'type' => 'info',
                        ],
                        (object) [
                            'type' => 'info',
                        ],
                        (object) [
                            'type' => 'info',
                        ],
                    ],
                ])),
                'expectedErrorCount' => 0,
            ],
            'error messages only' => [
                'output' => new Output(new Header(), $this->createBodyWithContent((object) [
                    'messages' => [
                        (object) [
                            'type' => 'error',
                        ],
                        (object) [
                            'type' => 'error',
                        ],
                        (object) [
                            'type' => 'error',
                        ],
                    ],
                ])),
                'expectedErrorCount' => 3,
            ],
            'info messages and error messages' => [
                'output' => new Output(new Header(), $this->createBodyWithContent((object) [
                    'messages' => [
                        (object) [
                            'type' => 'info',
                        ],
                        (object) [
                            'type' => 'error',
                        ],
                        (object) [
                            'type' => 'error',
                        ],
                        (object) [
                            'type' => 'info',
                        ],
                    ],
                ])),
                'expectedErrorCount' => 2,
            ],
        ];
    }

    private function createBodyWithContent(\stdClass $content): Body
    {
        $body = new Body();
        $body->setContent($content);

        return $body;
    }

    private function createHeader(array $fields): Header
    {
        $header = new Header();

        foreach ($fields as $key => $value) {
            $header->set($key, $value);
        }

        return $header;
    }
}
