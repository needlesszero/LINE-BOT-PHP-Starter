<?php

$urlAuthen = 'http://10.22.1.26/results_nodedown.json';
$contentAuthen = file_get_contents($urlAuthen);
$jsonAuthen = json_decode($contentAuthen, true);

foreach($jsonAuthen as $key=>$value) {					
			echo jsonAuthen[$key]['Customer_Name'];
			}
?>