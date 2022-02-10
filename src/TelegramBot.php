<?php

namespace raph6\TelegramBot;

class TelegramBot {
    private $_ch;
    private $bot_token;

    public function __construct($bot_token = null)
    {
        if ($bot_token == null) {
            throw new Exception("Please provide a bot token.");
        }
        $this->bot_token = $bot_token;

        // curl init
        $this->_ch = curl_init();
        curl_setopt($this->_ch, CURLOPT_RETURNTRANSFER, true);
    }

    public function getChannelsId() {
        $url = "https://api.telegram.org/bot" . $this->bot_token . "/getUpdates";

        curl_setopt($this->_ch, CURLOPT_HTTPGET, true);
        curl_setopt($this->_ch, CURLOPT_URL, $url);
     
        $output = curl_exec($this->_ch);
        curl_close($this->_ch); 
        
        $output = json_decode($output);

        $channels = [];
        foreach ($output->result as $result) {
            $chat_title = $result->my_chat_member->chat->title;
            $chat_id = $result->my_chat_member->chat->id;
    
            $channels[$chat_title] = $chat_id;
        }

        return $channels;
    }

    public function sendMessage($chat_id, $text) {
        $url = "https://api.telegram.org/bot" . $this->bot_token . "/sendMessage";

        $data = [
            'chat_id' => $chat_id,
            'text' => $text,
        ];

        curl_setopt($this->_ch, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($this->_ch, CURLOPT_POST, true);
        curl_setopt($this->_ch, CURLOPT_URL, $url);
        $output = curl_exec($this->_ch);
        $output = json_decode($output);
        curl_close($this->_ch);

        return $output->ok;
    }
}