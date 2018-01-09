<?php
$access_token = 'BzkGADGi+Cxxqos+aQZornbJuzvRZwcbEeyVmz5cNkKkjOqgN7h7HwhtLWpy55gTOROLnYrlXO5peau/5MeriEs/kUu4iu0WojXBWLqXqj4Jby+oGllRd3oKACAun1ofoTDf7JYz/mpDN+xDmhsHGgdB04t89/1O/w1cDnyilFU=';

$url = 'https://api.line.me/v1/oauth/verify';

$headers = array('Authorization: Bearer ' . $access_token);

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
$result = curl_exec($ch);
curl_close($ch);

echo $result;
?>