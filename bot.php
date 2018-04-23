<?php


$access_token = 'KygJBTnV/xAS9QNhJgQymbEZFw92G8Mj0RjrD3ycZEYbO9+I1a4e4dUqbvIo9Rv+OROLnYrlXO5peau/5MeriEs/kUu4iu0WojXBWLqXqj60DFs60UEbMhmV1fc5mEFF+GXDdqzqmAs+50FUkrVwCwdB04t89/1O/w1cDnyilFU=';

// Get POST body content
$content = file_get_contents('php://input');
// Parse JSON
$events = json_decode($content, true);

$urlAuthen = 'https://spreadsheets.google.com/feeds/list/1frT-QCU8A5Egh1XV3nW-8miICBvA6xTTSRHWG26lyqE/3/public/values?alt=json';
$contentAuthen = file_get_contents($urlAuthen);
$jsonAuthen = json_decode($contentAuthen, true);

$url = 'https://spreadsheets.google.com/feeds/list/1frT-QCU8A5Egh1XV3nW-8miICBvA6xTTSRHWG26lyqE/1/public/values?alt=json';
$content = file_get_contents($url);
$json = json_decode($content, true);
$findPlace = false;
echo strcmp("สำนักงานบังคับคดีจังหวัดบุรีรัมย์","สำนักงานบังคับคดีจังหวัดบุรีรัมย์");

$authen = false;

if (!is_null($events['events'])) {
	// Loop through each event
	foreach ($events['events'] as $event) {
		// Reply only when message sent is in 'text' format
		$uid = $event['source']['userId'];

		if(preg_match('/^-uid/', $event['message']['text'])){
			$tt = $uid;
			$replyToken = $event['replyToken'];
					  
		}


		foreach ($jsonAuthen['feed']['entry'] as $key=>$value) {					
			if(strcmp($jsonAuthen['feed']['entry'][$key]['gsx$userid']['$t'],$event['source']['userId']) == 0){
				$authen = true;
				break;
				}
			else{
				$tt = 'Authentication Failed';
				$authen = false;
				}
			}
			

			if($authen !== false) {
				if ($event['type'] == 'message' && $event['message']['type'] == 'text') {
			// Get text sent
			$text = $event['message']['text'];
			// Get replyToken
			$replyToken = $event['replyToken'];
			


			if(preg_match('/^-help/', $event['message']['text'])||preg_match('/^-h/', $event['message']['text'])){
				$tt = '-help : เพื่อแสดงคำสั่ง'."\n".
					  '-f <คำค้นหา> : เพื่อค้นหาสถานที่ประกอบคำที่ต้องการค้นหา'."\n".
					  '-stat <ชื่อหน่วยงาน> : แสดง status link'."\n".
					  '-ld /-lastd <ชื่อหน่วยงาน> : แสดง LastDownTimes'."\n".
					  '-down / -dt <ชื่อหน่วยงาน> : แสดง DowntimeDurations'."\n".
					  '-lu /-lastu <ชื่อหน่วยงาน> : แสดง LastUpTimes'."\n".
					  '-up / -ut <ชื่อหน่วยงาน> : แสดง UptimeDurations';
					  
			}

			

			else{
				

					if($findPlace==false){				
						

					}
				}
			}
		}

		else{
			$tt = 'Authentication Failed';
			$authen = false;
			$replyToken = $event['replyToken'];
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

echo "OK";
