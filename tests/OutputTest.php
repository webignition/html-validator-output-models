<?php
/** @noinspection PhpDocSignatureInspection */

namespace webignition\HtmlValidatorOutput\Models\Tests;

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
    public function testIsValid(Output $output, bool $expectedIsValid)
    {
        $this->assertEquals($expectedIsValid, $output->isValid());
    }

    public function isValidDataProvider(): array
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
                'expectedIsValid' => true,
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
                'expectedIsValid' => true,
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
                'expectedIsValid' => false,
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
                'expectedIsValid' => false,
            ],
        ];
    }

    public function testWasAborted()
    {
        $output = new Output(new Header(), new Body());

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
