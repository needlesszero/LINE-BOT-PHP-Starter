<?php
$access_token = 'uqhIt5rrQz+lIsYeKXJj1vN0uN/iGOI82cpggWhyLW/0xqEAudj9NCX+YgM9HA+lOROLnYrlXO5peau/5MeriEs/kUu4iu0WojXBWLqXqj7QDByc60mpmBvWUGg/gfSoxyRNlv4BwVwdD+wsgmpzDgdB04t89/1O/w1cDnyilFU=';

// Get POST body content
$content = file_get_contents('php://input');
// Parse JSON
$events = json_decode($content, true);


echo "OK";