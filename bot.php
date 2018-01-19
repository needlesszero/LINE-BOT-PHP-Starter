<?php


$access_token = 'KygJBTnV/xAS9QNhJgQymbEZFw92G8Mj0RjrD3ycZEYbO9+I1a4e4dUqbvIo9Rv+OROLnYrlXO5peau/5MeriEs/kUu4iu0WojXBWLqXqj60DFs60UEbMhmV1fc5mEFF+GXDdqzqmAs+50FUkrVwCwdB04t89/1O/w1cDnyilFU=';

// Get POST body content
$content = file_get_contents('php://input');
// Parse JSON
$events = json_decode($content, true);

$url = 'https://powerful-badlands-66623.herokuapp.com/im.json';
$content = file_get_contents($url);
$json = json_decode($content, true);
$findPlace = false;

echo $json;
echo $json['results'][0]['Customer_Name'];

if (!is_null($events['events'])) {

	$defaultCommand = 'คำสั่ง /help : เพื่อแสดงคำสั่งต่างๆ'."\n".'<ชื่อหน่วยงาน> : แสดงข้อมูลทั้งหมดของหน่วยงาน'."\n".'/status <ชื่อหน่วยงาน> : เพื่อแสดง status link ของหน่วยงาน'."\n".'/Ldown <ชื่อหน่วยงาน> : เพื่อแสดง LastDownTimes';
	// Loop through each event
	foreach ($events['events'] as $event) {
		// Reply only when message sent is in 'text' format


		if ($event['type'] == 'message' && $event['message']['type'] == 'text') {
			// Get text sent
			$text = $event['message']['text'];
			// Get replyToken
			$replyToken = $event['replyToken'];

			if(stripos('/help',$event['message']['text'])!== false){
				$tt = $defaultCommand ;
			}

			else {
				foreach ($json['results'] as $key=>$value) {
						//if($event['message']['text'] == 'status'){
						if(stripos($json['results'][$key]['Customer_Name'],$event['message']['text']) !== false){
							$tt = $json['results'][$key]['Customer_Name']."\n".'Status: '.$json['status']."\n".'IP Address: '.$json['results'][$key]['IP_Address']."\n".'DowntimeDuration: '.$json['results'][$key]['DowntimeDorations']."\n".'LastDownTimes: '.$json['results'][$key]['LastDownTimes']."\n".'Customer_SLA: '.$json['results'][$key]['Customer_SLA'];
							$findPlace = true;
							break;						
						}
						else $tt = '/help เพื่อแสดงคำสั่งต่างๆ';					
					
			}

			if($findPlace==false){				
				$url = 'https://powerful-badlands-66623.herokuapp.com/im2.json';
				$content = file_get_contents($url);
				$json = json_decode($content, true);

				foreach ($json['results'] as $key=>$value) {
						//if($event['message']['text'] == 'status'){
						if(stripos($json['results'][$key]['Customer_Name'],$event['message']['text']) !== false){
							$tt = $json['results'][$key]['Customer_Name']."\n".'Status: '.$json['status']."\n".'IP Address: '.$json['results'][$key]['IP_Address']."\n".'UptimeDurations: '.$json['results'][$key]['UptimeDurations']."\n".'LastUpTimes: '.$json['results'][$key]['LastUpTimes']."\n".'Customer_SLA: '.$json['results'][$key]['Customer_SLA'];
							$findPlace = true;
							break;						
						}
						else $tt = '/help เพื่อแสดงคำสั่งต่างๆ';					
					
			}

			}

			}


			

			// Build message to reply back
			$messages = [
				['type' => 'text',
				'text' => $tt],
				['type' => 'text',
				'text' => $tt]
			];

			// Make a POST Request to Messaging API to reply to sender
			$url = 'https://api.line.me/v2/bot/message/reply';
			$data = [
				'replyToken' => $replyToken,
				'messages' => [$messages[0]],
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
