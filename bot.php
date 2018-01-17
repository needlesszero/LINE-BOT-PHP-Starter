<?php
$access_token = 'KygJBTnV/xAS9QNhJgQymbEZFw92G8Mj0RjrD3ycZEYbO9+I1a4e4dUqbvIo9Rv+OROLnYrlXO5peau/5MeriEs/kUu4iu0WojXBWLqXqj60DFs60UEbMhmV1fc5mEFF+GXDdqzqmAs+50FUkrVwCwdB04t89/1O/w1cDnyilFU=';
$channel_token = 'a3b96dc8527339872f5efc35f9c3083c';


// Get POST body content
$httpClient = new \LINE\LINEBot\HTTPClient\CurlHTTPClient($access_token);
$bot = new \LINE\LINEBot($httpClient, ['channelSecret' => $channel_token]);

$textMessageBuilder = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder('hello');
$response = $bot->replyMessage('<reply token>', $textMessageBuilder);
if ($response->isSucceeded()) {
    echo 'Succeeded!';
    return;
}

// Failed
echo $response->getHTTPStatus() . ' ' . $response->getRawBody();