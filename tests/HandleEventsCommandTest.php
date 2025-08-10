<?php 

use App\Application;
use App\Commands\HandleEventsCommand;
use PHPUnit\Framework\TestCase;

/**
 * @covers HandleEventsCommand
 */
class HandleEventsCommandTest extends TestCase
{
    /**
     * @dataProvider provider
     */
    public function testShouldEventBeRan(array $event, bool $shouldEventBeRun): void 
    {
        $handleEventsCommand = new HandleEventsCommand(new Application(dirname(__DIR__)));
        $result = $handleEventsCommand->shouldEventBeRan($event);
        self::assertEquals($result, $shouldEventBeRun);
    }

    public static function provider(): array 
    {
        return [
            [
                [
                    'minute' => date('i'),
                    'hour' => date('H'),
                    'day' => date('d'),
                    'month' => date('m'),
                    'day_of_week' => date('w')
                ],
                true
            ],
            [
                [
                    'minute' => null,
                    'hour' => date('H'),
                    'day' => date('d'),
                    'month' => date('m'),
                    'day_of_week' => date('w')
                ],
                false
            ],
        ];
    }
}