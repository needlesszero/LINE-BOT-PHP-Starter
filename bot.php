<?php
$access_token = 'am1ve2WFidjcmj3wS/c+QqoulSxJ4UKI0iwjrdoN5/HOcuFiORAgVGSQ/g3kqRZS5LxyKOklfZo+oQ+HWnn++keNv9IjRjZk2rA7GM1X9AKeYUui1G/XFcOXcD05EqDUkgsomTrvvui2K4hGb9DuzgdB04t89/1O/w1cDnyilFU=';
// Get POST body content
$content = file_get_contents('php://input');
// Parse JSON
$events = json_decode($content, true);
$text = file_get_contents('https://line.gin.totisp.net/test.txt')
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
					  //'-f <คำค้นหา> : เพื่อค้นหาสถานที่ประกอบคำที่ต้องการค้นหา'."\n".
					  '-stat <ชื่อหน่วยงาน> : แสดง status link'."\n".
					  '-ltd /-lastd <ชื่อหน่วยงาน> : แสดง LastDownTimes'."\n".
					  '-down / -dt <ชื่อหน่วยงาน> : แสดง DowntimeDurations'."\n".
					  '-ltu /-lastu <ชื่อหน่วยงาน> : แสดง LastUpTimes'."\n".
					  '-up / -ut <ชื่อหน่วยงาน> : แสดง UptimeDurations';
					  
			}
			
			else{
			foreach ($json['feed']['entry'] as $key=>$value) {
						//if($event['message']['text'] == 'status'){
					

						if(stripos($json['feed']['entry'][$key]['gsx$customername']['$t'],$event['message']['text']) !== false){
								$tt = 'ชื่อ: '."\n".$json['feed']['entry'][$key]['gsx$customername']['$t']."\n".'จังหวัด: '.$json['feed']['entry'][$key]['gsx$province']['$t']."\n".'Status: Down'."\n".'DowntimeDuration: '.$json['feed']['entry'][$key]['gsx$downtimedorations']['$t']."\n".'LastDownTimes: '.$json['feed']['entry'][$key]['gsx$lastdowntimes']['$t']."\n".'Customer_SLA: '.$json['feed']['entry'][$key]['gsx$customersla']['$t'];
							$findPlace = true;
							}

						if(stripos($json['feed']['entry'][$key]['gsx$curcuitid']['$t'],$event['message']['text']) !== false){
								$tt = 'ชื่อ: '."\n".$json['feed']['entry'][$key]['gsx$customername']['$t']."\n".'จังหวัด: '.$json['feed']['entry'][$key]['gsx$province']['$t']."\n".'Status: Down'."\n".'DowntimeDuration: '.$json['feed']['entry'][$key]['gsx$downtimedorations']['$t']."\n".'LastDownTimes: '.$json['feed']['entry'][$key]['gsx$lastdowntimes']['$t']."\n".'Customer_SLA: '.$json['feed']['entry'][$key]['gsx$customersla']['$t'];
							$findPlace = true;
							}
													
						if($json['feed']['entry'][$key]['gsx$customername']['$t'] === $event['message']['text']){
							$tt = 'ชื่อ: '."\n".$json['feed']['entry'][$key]['gsx$customername']['$t']."\n".'จังหวัด: '.$json['feed']['entry'][$key]['gsx$province']['$t']."\n".'Status: Down'.$json['status']['$t']."\n".'DowntimeDuration: '.$json['feed']['entry'][$key]['gsx$downtimedorations']['$t']."\n".'LastDownTimes: '.$json['feed']['entry'][$key]['gsx$lastdowntimes']['$t']."\n".'Customer_SLA: '.$json['feed']['entry'][$key]['gsx$customersla']['$t'];
							$findPlace = true;
						}

						elseif(preg_match('/^-stat/', $event['message']['text'])){
							$data = $event['message']['text'];    
							$whatIWant = substr($data, strpos($data, ' ') + 1);
							if(stripos($json['feed']['entry'][$key]['gsx$customername']['$t'],$whatIWant) !== false){
								$tt = $json['feed']['entry'][$key]['gsx$customername']['$t']."\n".'Status: Down'.$json['status'];
								$findPlace = true;
								break;		
							}
							else $tt = 'ไม่พบข้อมูล';	
						}

						elseif(preg_match('/^-dt/', $event['message']['text']) || preg_match('/^-down/', $event['message']['text'])){
							$data = $event['message']['text'];    
							$whatIWant = substr($data, strpos($data, ' ') + 1);
							if(stripos($json['feed']['entry'][$key]['gsx$customername']['$t'],$whatIWant) !== false){
								$tt = $json['feed']['entry'][$key]['gsx$customername']['$t']."\n".'DowntimeDuration: '.$json['feed']['entry'][$key]['gsx$downtimedorations']['$t'];
								$findPlace = true;
								break;						
							}
							else $tt = 'ไม่พบข้อมูล';	
						}

						elseif(preg_match('/^-ltd/', $event['message']['text']) || preg_match('/^-lastd/', $event['message']['text'])){
							$data = $event['message']['text'];    
							$whatIWant = substr($data, strpos($data, ' ') + 1);
							if(stripos($json['feed']['entry'][$key]['gsx$customername']['$t'],$whatIWant) !== false){
								$tt = $json['feed']['entry'][$key]['gsx$customername']['$t']."\n".'LastDownTimes: '.$json['feed']['entry'][$key]['gsx$lastdowntimes']['$t'];
								$findPlace = true;
								break;						
							}
							else $tt = 'ไม่พบข้อมูล';	
						}

						else {
							if($findPlace==false){
								$tt = '-help เพื่อแสดงคำสั่ง';	
								}	
						}				
					
				}
				
					if($findPlace==false){				
						$url = 'https://spreadsheets.google.com/feeds/list/1frT-QCU8A5Egh1XV3nW-8miICBvA6xTTSRHWG26lyqE/2/public/values?alt=json';
					$content = file_get_contents($url);
					$json = json_decode($content, true);

					foreach ($json['results'] as $key=>$value) {
							//if($event['message']['text'] == 'status'){
							if(stripos($json['feed']['entry'][$key]['gsx$customername']['$t'],$event['message']['text']) !== false){
								$tt = 'ชื่อ: '."\n".$json['feed']['entry'][$key]['gsx$customername']['$t']."\n".'จังหวัด: '.$json['feed']['entry'][$key]['gsx$province']['$t']."\n".'Status: Up'."\n".'UptimeDurations: '.$json['feed']['entry'][$key]['gsx$uptimedurations']['$t']."\n".'LastUpTimes: '.$json['feed']['entry'][$key]['gsx$lastuptimes']['$t']."\n".'Customer_SLA: '.$json['feed']['entry'][$key]['gsx$customersla']['$t'];
								$findPlace = true;
								break;						
							}
							elseif(stripos($json['feed']['entry'][$key]['gsx$curcuitid']['$t'],$event['message']['text']) !== false){
								$tt = 'ชื่อ: '."\n".$json['feed']['entry'][$key]['gsx$customername']['$t']."\n".'จังหวัด: '.$json['feed']['entry'][$key]['gsx$province']['$t']."\n".'Status: Up'."\n".'UptimeDurations: '.$json['feed']['entry'][$key]['gsx$uptimedurations']['$t']."\n".'LastUpTimes: '.$json['feed']['entry'][$key]['gsx$lastuptimes']['$t']."\n".'Customer_SLA: '.$json['feed']['entry'][$key]['gsx$customersla']['$t'];
								$findPlace = true;
								break;						
							}
							elseif(preg_match('/^-stat/', $event['message']['text'])){
								$data = $event['message']['text'];    
								$whatIWant = substr($data, strpos($data, ' ') + 1);
								if(stripos($json['feed']['entry'][$key]['gsx$customername']['$t'],$whatIWant) !== false){
									$tt = $json['feed']['entry'][$key]['gsx$customername']['$t']."\n".'Status: Up'.$json['status'];
									$findPlace = true;
									break;						
								}
								else $tt = 'ไม่พบข้อมูล';	
						}
						elseif(preg_match('/^-ut/', $event['message']['text']) || preg_match('/^-up/', $event['message']['text'])){
							$data = $event['message']['text'];    
							$whatIWant = substr($data, strpos($data, ' ') + 1);
							if(stripos($json['feed']['entry'][$key]['gsx$customername']['$t'],$whatIWant) !== false){
								$tt = $json['feed']['entry'][$key]['gsx$customername']['$t']."\n".'UptimeDurations: '.$json['feed']['entry'][$key]['gsx$uptimedurations']['$t'];
								$findPlace = true;
								break;						
							}
							else $tt = 'ไม่พบข้อมูล';	
						}

						elseif(preg_match('/^-ltu/', $event['message']['text']) || preg_match('/^-lastu/', $event['message']['text'])){
							$data = $event['message']['text'];    
							$whatIWant = substr($data, strpos($data, ' ') + 1);
							if(stripos($json['feed']['entry'][$key]['gsx$customername']['$t'],$whatIWant) !== false){
								$tt = $json['feed']['entry'][$key]['gsx$customername']['$t']."\n".'LastUpTimes: '.$json['feed']['entry'][$key]['gsx$lastuptimes']['$t'];
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
			}
		}
		else{
			$tt = 'ท่านไม่ได้รับสิทธิ์ในการเข้าใช้ระบบ'."\n".'กรุณาพิมพ์คำสั่ง -help : เพื่อแสดงคำสั่ง';
			$authen = false;
			$replyToken = $event['replyToken'];
			if(preg_match('/^-help/', $event['message']['text'])||preg_match('/^-h/', $event['message']['text'])){
				$tt = '-help : เพื่อแสดงคำสั่ง'."\n"."-uid : เพื่อแสดง UserID" ;
			}
		}
		if(preg_match('/^-uid/', $event['message']['text'])){
			$tt = $uid;
			$replyToken = $event['replyToken'];
					  
		}
			// Build message to reply back
			$messages = [
				['type' => 'text',
				'text' => $text],
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
