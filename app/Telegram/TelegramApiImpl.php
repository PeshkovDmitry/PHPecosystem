<?php

namespace App\Telegram;
use App\Telegram\TelegramApi;

class TelegramApiImpl implements TelegramApi {

    const ENDPOINT = 'https://api.telegram.org/bot';
    private int $offset;
    private string $token;

    public function __construct(string $token) 
    {
        $this->token = $token;
    }

    public function sendMessage(string $chatId, string $text)
    {
        $url = self::ENDPOINT.$this->token.'/sendMessage';
        $data = [
            'chat_id' => $chatId,
            'text' => $text
        ];
        $ch = curl_init($url);
        $jsonData = json_encode($data);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_exec($ch);
        curl_close($ch);
    }

    public function getMessages(int $offset): array
    {
        $url = self::ENDPOINT.$this->token.'/getUpdates?timeout=1';
        $result = [];
        while(true) {
            $currentUrl = $url.'&offset='.$offset;
            $ch = curl_init($currentUrl);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $responce = json_decode(curl_exec($ch), true);
            curl_close($ch);
            if (!$responce['ok'] || empty($responce['result'])) break;
            foreach ($responce['result'] as $data) {
                $result[$data['message']['chat']['id']] = [...$result[$data['message']['chat']['id']] ?? [], $data['message']['text']];
                $offset = $data['update_id'] + 1;
            }
            if (count($responce['result']) < 100) break;
        }
        return [
            'offset' => $offset,
            'result' => $result
        ];
    }

}