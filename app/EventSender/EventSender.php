<?php

namespace App\EventSender;

use App\Telegram\TelegramApi;
use App\Queue\Queue;
use App\Queue\Queueable;

class EventSender implements Queueable {

    private TelegramApi $telegram;
    private Queue $queue;
    private string $receiver;
    private string $message;


    public function __construct(TelegramApi $telegram, Queue $queue) {
        $this->telegram = $telegram;
        $this->queue = $queue;
    }

    public function handle(): void {
       $this->telegram->sendMessage($this->receiver, $this->message);
    }

    public function toQueue(...$args): void {
        $this->receiver = $args[0];
        $this->message = $args[1];
        $this->queue->sendMessage(serialize($this));
    }

}