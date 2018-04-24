<?php
$url = 'http://line.gin.totisp.net/testCurl.php';
 echo $url;
 $curl = curl_init();
 curl_setopt_array($curl, array(
                        CURLOPT_RETURNTRANSFER => 1,
                        CURLOPT_URL => $url,
                        CURLOPT_USERAGENT => 'Thai Prosperous IT co.,Ltd.'
                   ));
 $resp = curl_exec($curl);
 curl_close($curl);
 ?>