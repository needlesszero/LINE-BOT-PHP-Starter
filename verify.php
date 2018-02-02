<?php
$access_token = 'KygJBTnV/xAS9QNhJgQymbEZFw92G8Mj0RjrD3ycZEYbO9+I1a4e4dUqbvIo9Rv+OROLnYrlXO5peau/5MeriEs/kUu4iu0WojXBWLqXqj60DFs60UEbMhmV1fc5mEFF+GXDdqzqmAs+50FUkrVwCwdB04t89/1O/w1cDnyilFU=';

$messages = [
				['type' => 'text',
				'text' => 'asdsad']
			];
// Parse JSON
$post = json_decode($messages, true);

$url = 'https://api.line.me/v1/oauth/verify';

$headers = array('Authorization: Bearer ' . $access_token);

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
$result = curl_exec($ch);
echo $result;

$hc = curl_init($url);
curl_setopt($hc, CURLOPT_RETURNTRANSFER, true);
curl_setopt($hc, CURLOPT_HTTPHEADER, $headers);
curl_setopt($hc, CURLOPT_FOLLOWLOCATION, 1);
$resultz = curl_exec($hc);

?>