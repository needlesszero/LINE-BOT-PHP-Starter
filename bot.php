<?php

/**
 * Copyright 2016 LINE Corporation
 *
 * LINE Corporation licenses this file to you under the Apache License,
 * version 2.0 (the "License"); you may not use this file except in compliance
 * with the License. You may obtain a copy of the License at:
 *
 *   https://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS, WITHOUT
 * WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied. See the
 * License for the specific language governing permissions and limitations
 * under the License.
 */

require_once('./LINEBotTiny.php');

$channelAccessToken = '<your channel access token>';
$channelSecret = '<your channel secret>';

$client = new LINEBotTiny($channelAccessToken, $channelSecret);
foreach ($client->parseEvents() as $event) {
    switch ($event['type']) {
        case 'message':
            $message = $event['message'];
            switch ($message['type']) {
                case 'text':
                    $client->replyMessage(array(
                        'replyToken' => $event['replyToken'],
                        'messages' => array(
                            array(
                                'type' => 'text',
                                'text' => $message['text']
                            )
                        )
                    ));
                    break;
                default:
                    error_log("Unsupporeted message type: " . $message['type']);
                    break;
            }
            break;
        default:
            error_log("Unsupporeted event type: " . $event['type']);
            break;
    }
};
=======
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
	// Loop through each event
	foreach ($events['events'] as $event) {
		// Reply only when message sent is in 'text' format


		if ($event['type'] == 'message' && $event['message']['type'] == 'text') {
			// Get text sent
			$text = $event['message']['text'];
			// Get replyToken
			$replyToken = $event['replyToken'];



			foreach ($json['results'] as $key=>$value) {
						//if($event['message']['text'] == 'status'){
						if(stripos($json['results'][$key]['Customer_Name'],$event['message']['text']) !== false){
							$tt = $json['results'][$key]['Customer_Name']."\n".'Status: '.$json['status']."\n".'IP Address: '.$json['results'][$key]['IP_Address']."\n".'DowntimeDuration: '.$json['results'][$key]['DowntimeDorations']."\n".'LastDownTimes: '.$json['results'][$key]['LastDownTimes']."\n".'Customer_SLA: '.$json['results'][$key]['Customer_SLA'];
							$findPlace = true;
							break;						
						}
						else $tt = 'ไม่พบข้อมูล';					
					
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
						else $tt = 'ไม่พบข้อมูล';					
					
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
			//curl_close($ch);

			echo $result . "\r\n";
		}

	}
}
echo "OK";
