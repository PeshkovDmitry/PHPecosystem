<?php

use App\Application;
use App\Commands\SaveEventCommand;
use App\Models\Event;
use PHPUnit\Framework\TestCase;

/**
 * @covers SaveEventCommand
 */
class SaveEventsCommandTest extends TestCase
{
    /**
     * @dataProvider testGetCronValuesProvider
     */
    public function testGetCronValues(string $cronString, array $cronValues): void
    {
        $saveEventsCommand = new SaveEventCommand(new Application(dirname(__DIR__)));
        $result = $saveEventsCommand->getCronValues($cronString);
        self::assertEquals($result, $cronValues);
    }

    private static function testGetCronValuesProvider(): array
    {
        return [
            [
                '* * * * *',
                [null, null, null, null, null]
            ],
            [
                '1 2 3 4 5',
                [1, 2, 3, 4, 5]
            ]
        ];
    }

    /**
     * @dataProvider testIsNeedHelpProvider
     */
    public function testIsNeedHelp(array $options, bool $isNeedHelp): void
    {
        $saveEventsCommand = new SaveEventCommand(new Application(dirname(__DIR__)));
        $result = $saveEventsCommand->isNeedHelp($options);
        self::assertEquals($result, $isNeedHelp);
    }

    private static function testIsNeedHelpProvider(): array
    {
        return [
            [
                [
                    'name' => '',
                    'text' => '',
                    'receiver' => '',
                    'cron' => ''
                ],
                false
            ],
            [
                [
                    'name' => '',
                    'text' => '',
                    'receiver' => ''
                ],
                true
            ],
            [
                [
                    'help' => ''
                ],
                true
            ],
            [
                [
                    'h' => ''
                ],
                true
            ]
        ];
    }

    /**
     * @dataProvider testSaveEventCommandProvider
     */
    public function testSaveEventCommand(array $options, array $expectedArray): void
    {
        $mock = $this->getMockBuilder(Event::class)
            ->setMethods(['insert'])
            ->disableOriginalConstructor()
            ->getMock();
        $mock->expects($this->once())
            ->method('insert')
            ->with(
                implode(', ', array_keys($expectedArray)),
                array_values($expectedArray)
            );
        $saveEventsCommand = new SaveEventCommand(new Application(dirname(__DIR__)));
        $saveEventsCommand->runForEvent($options, $mock);
    }

    private static function testSaveEventCommandProvider(): array
    {
        return [
            [
                [
                    'name' => 'testName',
                    'text' => 'testText',
                    'receiver' => 'testReceiver',
                    'cron' => '1 2 3 4 5'
                ],
                [
                    'name' => 'testName',
                    'text' => 'testText',
                    'receiver_id' => 'testReceiver',
                    'minute' => '1',
                    'hour' => '2',
                    'day' => '3',
                    'month' => '4',
                    'day_of_week' => '5'
                ]
            ]
        ];
    }


}