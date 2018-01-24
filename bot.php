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
echo array_keys($json['results'][0][0]);

if (!is_null($events['events'])) {
	// Loop through each event
	foreach ($events['events'] as $event) {
		// Reply only when message sent is in 'text' format


		if ($event['type'] == 'message' && $event['message']['type'] == 'text') {
			// Get text sent
			$text = $event['message']['text'];
			// Get replyToken
			$replyToken = $event['replyToken'];


			if(preg_match('/^-help/', $event['message']['text'])){
				$tt = '-help : เพื่อแสดงคำสั่ง'."\n".'-stat <ชื่อหน่วนงาน> : แสดง status link'."\n".'-ld /-lastd <ชื่อหน่วนงาน> : แสดง LastDownTimes'."\n".'-down / -dt <ชื่อหน่วนงาน> : แสดง DowntimeDurations';
			}

			else{
				foreach ($json['results'] as $key=>$value) {
						//if($event['message']['text'] == 'status'){

						if(stripos($json['results'][$key]['Customer_Name'],$event['message']['text']) !== false){
							$tt = $json['results'][$key]['Customer_Name']."\n".'Status: '.$json['status']."\n".'DowntimeDuration: '.$json['results'][$key]['DowntimeDorations']."\n".'LastDownTimes: '.$json['results'][$key]['LastDownTimes']."\n".'Customer_SLA: '.$json['results'][$key]['Customer_SLA'];
							$findPlace = true;
							break;						
						}

						elseif(preg_match('/^-stat/', $event['message']['text'])){
							$data = $event['message']['text'];    
							$whatIWant = substr($data, strpos($data, ' ') + 1);
							if(stripos($json['results'][$key]['Customer_Name'],$whatIWant) !== false){
								$tt = $json['results'][$key]['Customer_Name']."\n".'Status: '.$json['status'];
								$findPlace = true;
								break;						
							}
							else $tt = 'ไม่พบข้อมูล';	
						}

						elseif(preg_match('/^-dt/', $event['message']['text']) || preg_match('/^-down/', $event['message']['text'])){
							$data = $event['message']['text'];    
							$whatIWant = substr($data, strpos($data, ' ') + 1);
							if(stripos($json['results'][$key]['Customer_Name'],$whatIWant) !== false){
								$tt = $json['results'][$key]['Customer_Name']."\n".'DowntimeDuration: '.$json['results'][$key]['DowntimeDorations'];
								$findPlace = true;
								break;						
							}
							else $tt = 'ไม่พบข้อมูล';	
						}

						elseif(preg_match('/^-ltd/', $event['message']['text']) || preg_match('/^-lastd/', $event['message']['text'])){
							$data = $event['message']['text'];    
							$whatIWant = substr($data, strpos($data, ' ') + 1);
							if(stripos($json['results'][$key]['Customer_Name'],$whatIWant) !== false){
								$tt = $json['results'][$key]['Customer_Name']."\n".'LastDownTimes: '.$json['results'][$key]['LastDownTimes'];
								$findPlace = true;
								break;						
							}
							else $tt = 'ไม่พบข้อมูล';	
						}

						else $tt = '-help เพื่อแสดงคำสั่ง';					
					
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
							elseif(preg_match('/^-stat/', $event['message']['text'])){
								$data = $event['message']['text'];    
								$whatIWant = substr($data, strpos($data, ' ') + 1);
								if(stripos($json['results'][$key]['Customer_Name'],$whatIWant) !== false){
									$tt = $json['results'][$key]['Customer_Name']."\n".'Status: '.$json['status'];
									$findPlace = true;
									break;						
								}
								else $tt = 'ไม่พบข้อมูล';	
						}
						else $tt = '-help เพื่อแสดงคำสั่ง';		

						$command = strtok($text, ' ');
									
						
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
