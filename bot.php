<?php // callback.php
define("LINE_MESSAGING_API_CHANNEL_SECRET", '8a3bca6e2e763320804298a01559b90b');
define("LINE_MESSAGING_API_CHANNEL_TOKEN", 'xXHOO2/cmUFZ2DgFpz0P0beBcReaI5o25ZcFGa6VwP/miLf0Sw0XyQonjMdigSAXaq4UiDaAkgw6nhBAb8vALpu8lZstE3nmAEJm1FPO73g3uV8C3h8lyRkA0D7qQNlcmqjxeofB5+EUmwZ5voNWyQdB04t89/1O/w1cDnyilFU=');

require __DIR__."/../vendor/autoload.php";

$bot = new \LINE\LINEBot(
    new \LINE\LINEBot\HTTPClient\CurlHTTPClient(LINE_MESSAGING_API_CHANNEL_TOKEN),
    ['channelSecret' => LINE_MESSAGING_API_CHANNEL_SECRET]
);

$signature = $_SERVER["HTTP_".\LINE\LINEBot\Constant\HTTPHeader::LINE_SIGNATURE];
$body = file_get_contents("php://input");

$events = $bot->parseEventRequest($body, $signature);

foreach ($events as $event) {
    if ($event instanceof \LINE\LINEBot\Event\MessageEvent\TextMessage) {
        $reply_token = $event->getReplyToken();
        $text = $event->getText();
        $bot->replyText($reply_token, $text);
    }
}

echo "OK";