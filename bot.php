<?php
$access_token = 'BzkGADGi+Cxxqos+aQZornbJuzvRZwcbEeyVmz5cNkKkjOqgN7h7HwhtLWpy55gTOROLnYrlXO5peau/5MeriEs/kUu4iu0WojXBWLqXqj4Jby+oGllRd3oKACAun1ofoTDf7JYz/mpDN+xDmhsHGgdB04t89/1O/w1cDnyilFU=';

// Get POST body content
$content = file_get_contents('php://input');
// Parse JSON
$events = json_decode($content, true);
// Validate parsed JSON data
if (!is_null($events['events'])) {
	// Loop through each event
	foreach ($events['events'] as $event) {
		// Reply only when message sent is in 'text' format
		if ($event['type'] == 'message' && $event['message']['type'] == 'text') {
			// Get text sent
			$text = $event['message']['type'];
			// Get replyToken
			$replyToken = $event['replyToken'];

			if (strpos($text,'A') !== false) {
			    $text = 'ข้อ A';
			}

			else if (strpos($text,'B') !== false) {
			    $text = 'ข้อ B';
			}

			else if (strpos($text,'C') !== false) {
			    $text = 'ข้อ C';
			}

			else {
				$text = 'ไม่รู้โว้ยยยยยยย';
			}
			// Build message to reply back
			$messages = [
				'type' => 'text',
				'text' => $text
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
	}
}
echo "OK";