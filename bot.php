<?php
$access_token = 'uqhIt5rrQz+lIsYeKXJj1vN0uN/iGOI82cpggWhyLW/0xqEAudj9NCX+YgM9HA+lOROLnYrlXO5peau/5MeriEs/kUu4iu0WojXBWLqXqj7QDByc60mpmBvWUGg/gfSoxyRNlv4BwVwdD+wsgmpzDgdB04t89/1O/w1cDnyilFU=';

// Get POST body content
$content = file_get_contents('php://input');
// Parse JSON
$events = json_decode($content, true);

$url = 'https://raw.githubusercontent.com/needlesszero/LINE-BOT-PHP-Starter/master/im.json';
$content = file_get_contents($url);
$json = json_decode($content, true);

echo $json;
echo $json['results']['address_components'][1]['long_name'];

if (!is_null($events['events'])) {
	// Loop through each event
	foreach ($events['events'] as $event) {
		// Reply only when message sent is in 'text' format


		if ($event['type'] == 'message' && $event['message']['type'] == 'text') {
			// Get text sent
			$text = $event['message']['text'];
			// Get replyToken
			$replyToken = $event['replyToken'];



			foreach ($json['results'] as $js) {
				// Reply only when message sent is in 'text' format
				if ($js['type'] == 'message' && $js['message']['type'] == 'text') {
					// Get text sent
					$tt = $js['message']['id'];
				}

				else 

					foreach ($js['address_components'] as $key=>$value) {
						//if($event['message']['text'] == 'status'){
						if(strpos($js['address_components'][$key]['long_name'],$event['message']['text']) !== false){
							$tt = $js['address_components'][$key]['short_name'];
							break;						
						}
						else $tt = 'failsddd';
					}
					
			}

			// Build message to reply back
			$messages = [
				'type' => 'text',
				'text' => $tt
			];

			// Make a POST Request to Messaging API to reply to sender
			$url = 'https://api.line.me/v2/bot/message/reply';
			$data = [
				'replyToken' => $replyToken,
				'messages' => [$messages],
			];
			$post = json_encode($data);
			$headers = array('Content-Type: application/json', 'Authorization: Bearer ' . $access_token);

			$ch = curl_init($url);
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
			curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
			curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
			$result = curl_exec($ch);
			curl_close($ch);

			echo $result . "\r\n";
		}

		//if sent by sticker
		if ($event['type'] == 'message' && $event['message']['type'] == 'sticker') {

			


			// Get text sent
			$text = $event['message']['text'];
			// Get replyToken
			$replyToken = $event['replyToken'];



			foreach ($json['results'] as $js) {
			$json = json_decode($content, true);

			foreach ($js['address_components'] as $key=>$value) {
						//if($event['message']['text'] == 'status'){
			$tt = $js['address_components'][$key]['short_name'];			
					


			// Build message to reply back
			$messages = [
				'type' => 'text',
				'text' => $tt
			];

			// Make a POST Request to Messaging API to reply to sender
			$url = 'https://api.line.me/v2/bot/message/reply';
			$data = [
				'replyToken' => $replyToken,
				'messages' => [$messages],
			];
			$post = json_encode($data);
			$headers = array('Content-Type: application/json', 'Authorization: Bearer ' . $access_token);

			$ch = curl_init($url);
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
			curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
			curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
			$result = curl_exec($ch);
			//curl_close($ch);

			echo $result . "\r\n";
						}
		}
	}
	}
}
echo "OK";