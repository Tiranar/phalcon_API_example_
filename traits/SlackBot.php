<?php

namespace App\Traits;

trait SlackBot {
    use CURL;
    
    /**
     * Notify Received Developer Token by SlackBot
     * 
     * @param string $email
     *
     * @return void
     */
    public function notifyReceivedDeveloperTokenSlack(string $email)
    {
        $message = "{$email} has just received developer token.";
        $botUrl = $this->config->get('slack_bot')['post_message_url'];
        
        $header = [
            "Authorization: Bearer " . $this->config->get('slack_bot')['token_key'],
            "Content-Type: application/json"
        ];

        $data_string = [
            "text" => $message,
            "channel" => $this->config->get('slack_bot')['channel_key']
        ];

        $data_string = json_encode($data_string);
        
        $this->postDataHeaderJson($botUrl, $header, $data_string);
    }
}