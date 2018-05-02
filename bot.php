<?php
$access_token = 'am1ve2WFidjcmj3wS/c+QqoulSxJ4UKI0iwjrdoN5/HOcuFiORAgVGSQ/g3kqRZS5LxyKOklfZo+oQ+HWnn++keNv9IjRjZk2rA7GM1X9AKeYUui1G/XFcOXcD05EqDUkgsomTrvvui2K4hGb9DuzgdB04t89/1O/w1cDnyilFU=';
// Get POST body content
$content = file_get_contents('php://input');

//call_node();
// Parse JSON
$events = json_decode($content, true);
$urlAuthen = 'https://line.gin.totisp.net/user_authentication.json';
$contentAuthen = file_get_contents($urlAuthen);
$jsonAuthen = json_decode($contentAuthen, true);

$url = 'https://line.gin.totisp.net/results_nodedown.json';
$content = file_get_contents($url);
$json = json_decode($content, true);

$urlticket = 'https://line.gin.totisp.net/ginosticket_db.json';
$contentTicket = file_get_contents($urlticket);
$jsonTicket = json_decode($contentTicket, true);

$findPlace = false;
echo strcmp("สำนักงานบังคับคดีจังหวัดบุรีรัมย์","สำนักงานบังคับคดีจังหวัดบุรีรัมย์");
$authen = false;

$privilege = 0 ;

if (!is_null($events['events'])) {
	// Loop through each event
	foreach ($events['events'] as $event) {
		// Reply only when message sent is in 'text' format
		$uid = $event['source']['userId'];
		foreach($jsonAuthen as $key=>$value) {					
			if(strcmp($jsonAuthen[$key]['uid'],$event['source']['userId']) == 0){
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
					  '-up / -ut <ชื่อหน่วยงาน> : แสดง UptimeDurations'
					  '-c <ชื่อหน่วยงาน> : ตรวจสอบข้อมูลเคส';
					  
			}

			elseif(preg_match('/^-c/', $event['message']['text'])){
				$data = $event['message']['text'];    
				$whatIWant = substr($data, strpos($data, ' ') + 1);
				foreach ($jsonTicket as $key=>$value) {
					if(stripos($jsonTicket[$key]['subject'],$whatIWant) !== false){
								$tt = 	'Ticket iD: '."\n".$jsonTicket[$key]['number']."\n".
										'Customar Name: '.$jsonTicket[$key]['subject']."\n".
										'Circuit iD: '."\n".$jsonTicket[$key]['circuitid']."\n".
										'Status: '.$jsonTicket[$key]['status']."\n".
										'last-time log: '.$jsonTicket[$key]['created']['date']."\n".
										'Log: '.$jsonTicket[$key]['body'];
								$checkCase = true;
							}
					elseif(stripos($jsonTicket[$key]['circuitid'],$whatIWant) !== false){
								$tt = 	'Ticket iD: '."\n".$jsonTicket[$key]['number']."\n".
										'Customar Name: '.$jsonTicket[$key]['subject']."\n".
										'Circuit iD: '."\n".$jsonTicket[$key]['circuitid']."\n".
										'Status: '.$jsonTicket[$key]['status']."\n".
										'last-time log: '.$jsonTicket[$key]['created']['date']."\n".
										'Log: '.$jsonTicket[$key]['body'];
								$checkCase = true;
							}
						}
					else $tt = 'ไม่พบข้อมูล';	
			}			
			else{
			foreach ($json as $key=>$value) {
						//if($event['message']['text'] == 'status'){
					

						if(stripos($json[$key]['Customer_Name'],$event['message']['text']) !== false){
								$tt = 	'ชื่อ: '."\n".$json[$key]['Customer_Name']."\n".
										'จังหวัด: '.$json[$key]['Province']."\n".
										'CurcuitID: '.$json[$key]['Curcuit_ID']."\n".
										'Status: Down'."\n".
										'DowntimeDuration: '.$json[$key]['DowntimeDorations']."\n".
										'LastDownTimes: '.$json[$key]['LastDownTimes']['date']."\n".
										'LastUpTimes: '.$json[$key]['LastUptimes']['date']."\n".
										'Customer_SLA: '.$json[$key]['Customer_SLA'];
								$findPlace = true;
							}

						if(stripos($json[$key]['Curcuit_ID'],$event['message']['text']) !== false){
								$tt = 	'ชื่อ: '."\n".$json[$key]['Customer_Name']."\n".
										'จังหวัด: '.$json[$key]['Province']."\n".
										'CurcuitID: '.$json[$key]['Curcuit_ID']."\n".
										'Status: Down'."\n".
										'DowntimeDuration: '.$json[$key]['DowntimeDorations']."\n".
										'LastDownTimes: '.$json[$key]['LastDownTimes']['date']."\n".
										'LastUpTimes: '.$json[$key]['LastUptimes']['date']."\n".
										'Customer_SLA: '.$json[$key]['Customer_SLA'];
								$findPlace = true;
							}
													
						if($json[$key]['Customer_Name'] === $event['message']['text']){
								$tt = 	'ชื่อ: '."\n".$json[$key]['Customer_Name']."\n".
										'จังหวัด: '.$json[$key]['Province']."\n".
										'CurcuitID: '.$json[$key]['Curcuit_ID']."\n".
										'Status: Down'."\n".
										'DowntimeDuration: '.$json[$key]['DowntimeDorations']."\n".
										'LastDownTimes: '.$json[$key]['LastDownTimes']['date']."\n".
										'LastUpTimes: '.$json[$key]['LastUptimes']['date']."\n".
										'Customer_SLA: '.$json[$key]['Customer_SLA'];
								$findPlace = true;
						}

						elseif(preg_match('/^-stat/', $event['message']['text'])){
							$data = $event['message']['text'];    
							$whatIWant = substr($data, strpos($data, ' ') + 1);

							if(stripos($json[$key]['Customer_Name'],$whatIWant) !== false){
								$tt = 	$json[$key]['Customer_Name']."\n".
										'Status: Down'.$json['status'];

								$findPlace = true;
								break;		
							}
							else $tt = 'ไม่พบข้อมูล';	
						}

						elseif(preg_match('/^-dt/', $event['message']['text']) || preg_match('/^-down/', $event['message']['text'])){
							$data = $event['message']['text'];    
							$whatIWant = substr($data, strpos($data, ' ') + 1);

							if(stripos($json[$key]['Customer_Name'],$whatIWant) !== false){
								$tt = 	$json[$key]['Customer_Name']."\n".
										'DowntimeDuration: '.$json[$key]['DowntimeDorations'];

								$findPlace = true;
								break;						
							}
							else $tt = 'ไม่พบข้อมูล';	
						}

						elseif(preg_match('/^-ltd/', $event['message']['text']) || preg_match('/^-lastd/', $event['message']['text'])){
							$data = $event['message']['text'];    
							$whatIWant = substr($data, strpos($data, ' ') + 1);
							
							if(stripos($json[$key]['Customer_Name'],$whatIWant) !== false){
								$tt = 	$json[$key]['Customer_Name']."\n".
										'LastDownTimes: '.$json[$key]['LastDownTimes']['date'];

								$findPlace = true;
								break;						
							}
							else $tt = 'ไม่พบข้อมูล';	
						}

						elseif(preg_match('/^-utd/', $event['message']['text']) || preg_match('/^-lastd/', $event['message']['text'])){
							$data = $event['message']['text'];    
							$whatIWant = substr($data, strpos($data, ' ') + 1);
							
							if(stripos($json[$key]['Customer_Name'],$whatIWant) !== false){
								$tt = 	$json[$key]['Customer_Name']."\n".
										'LastUpTimes: '.$json[$key]['LastUptimes']['date'];

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
					$url = 'https://line.gin.totisp.net/results_nodeup.json';
					$content = file_get_contents($url);
					$json = json_decode($content, true);

					foreach ($json as $key=>$value) {
							//if($event['message']['text'] == 'status'){
							if(stripos($json[$key]['Customer_Name'],$event['message']['text']) !== false){
								$tt = 	'ชื่อ: '."\n".$json[$key]['Customer_Name']."\n".
										'จังหวัด: '.$json[$key]['Province']."\n".
										'CurcuitID: '.$json[$key]['Curcuit_ID']."\n".
										'Status: UP'."\n".
										'DowntimeDuration: '.$json[$key]['UptimeDurations']."\n".
										'LastDownTimes: '.$json[$key]['LastUpTimes']['date']."\n".
										'LastUpTimes: '.$json[$key]['LastBoot']['date']."\n".
										'Customer_SLA: '.$json[$key]['Customer_SLA'];
								$findPlace = true;
								break;						
							}
							elseif(stripos($json[$key]['Customer_Name'],$event['message']['text']) !== false){
								$tt = 	'ชื่อ: '."\n".$json[$key]['Customer_Name']."\n".
										'จังหวัด: '.$json[$key]['Province']."\n".
										'CurcuitID: '.$json[$key]['Curcuit_ID']."\n".
										'Status: UP'."\n".
										'UptimeDurations: '.$json[$key]['UptimeDurations']."\n".
										'LastDownTimes: '.$json[$key]['LastUpTimes']['date']."\n".
										'LastUpTimes: '.$json[$key]['LastBoot']['date']."\n".
										'Customer_SLA: '.$json[$key]['Customer_SLA'];
								$findPlace = true;
								break;						
							}
							elseif(preg_match('/^-stat/', $event['message']['text'])){
								$data = $event['message']['text'];    
								$whatIWant = substr($data, strpos($data, ' ') + 1);
								if(stripos($json[$key]['Customer_Name'],$whatIWant) !== false){
									$tt = 	$json[$key]['Customer_Name']."\n".
											'Status: Up';
									$findPlace = true;
									break;						
								}
								else $tt = 'ไม่พบข้อมูล';	
						}
						elseif(preg_match('/^-ut/', $event['message']['text']) || preg_match('/^-up/', $event['message']['text'])){
							$data = $event['message']['text'];    
							$whatIWant = substr($data, strpos($data, ' ') + 1);
							if(stripos($json[$key]['Customer_Name'],$whatIWant) !== false){
								$tt = 	$json[$key]['Customer_Name']."\n".
										'UptimeDurations: '.$json[$key]['UptimeDurations'];
								$findPlace = true;
								break;						
							}
							else $tt = 'ไม่พบข้อมูล';	
						}

						elseif(preg_match('/^-ltu/', $event['message']['text']) || preg_match('/^-lastu/', $event['message']['text'])){
							$data = $event['message']['text'];    
							$whatIWant = substr($data, strpos($data, ' ') + 1);
							if(stripos($json[$key]['Customer_Name'],$whatIWant) !== false){
								$tt = 	$json[$key]['Customer_Name']."\n".
										'LastUpTimes: '.$json[$key]['LastUpTimes']['date'];
								$findPlace = true;
								break;						
							}
							else $tt = 'ไม่พบข้อมูล';	
						}

						elseif(preg_match('/^-lstb/', $event['message']['text']) || preg_match('/^-lastb/', $event['message']['text'])){
							$data = $event['message']['text'];    
							$whatIWant = substr($data, strpos($data, ' ') + 1);
							
							if(stripos($json[$key]['Customer_Name'],$whatIWant) !== false){
								$tt = 	$json[$key]['Customer_Name']."\n".
										'LastUpTimes: '.$json[$key]['LastBoot']['date'];

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