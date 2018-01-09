<?php
$ composer require linecorp/line-bot-sdk
$httpClient = new \LINE\LINEBot\HTTPClient\CurlHTTPClient('GKdpmOPnhQCXFF7HdLIgmtihy+94LubvVkl6NAo4per9P0E42jWVukl9814rdxlTOROLnYrlXO5peau/5MeriEs/kUu4iu0WojXBWLqXqj5Z8cQgh/MdtXy3pif/IEQvei6wljHXE0ukEHanDmkOuAdB04t89/1O/w1cDnyilFU=');
$bot = new \LINE\LINEBot($httpClient, ['channelSecret' => 'd95d63c9e1304eebb82af66f63a21349']);
$response = $bot->replyText('<reply token>', 'hello!');

// Failed
echo $response->getHTTPStatus() . ' ' . $response->getRawBody();
?>