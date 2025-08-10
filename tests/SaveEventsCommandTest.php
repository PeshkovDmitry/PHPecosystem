<?php

use App\Application;
use App\Commands\SaveEventCommand;
use PHPUnit\Framework\TestCase;

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
    public function testIsNeedHelp(array $options, bool $isNeedHelp)
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

}