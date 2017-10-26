<?php
$id = 10;
$status = 'draft';
$type = 'CI';
$username='03c38cc1-4d8f-492f-9621-6d57632b1d90';
$password='c930a783-7b9c-4b3f-9caf-b97f294fb9b2';
$URL='https://bluemail.w3ibm.mybluemix.net/rest/v2/emails';
$email = array();
$email[] = 'alimao@br.ibm.com';
$email[] = 'default@us.ibm.com';
$email[] = 'default@us.ibm.com';


$postData = '{
	"contact": "NotReplyIbox@br.ibm.com",
	"recipients": [
		{"recipient": '.json_encode($email[0]).'},
        {"recipient": '.json_encode($email[1]).'},
        {"recipient": '.json_encode($email[2]).'}
	],
	"subject": "[IBOX] Test Mail ",
	"message": "Testing the email service. Defaults selected."
 }';

$ch = curl_init('https://bluemail.w3ibm.mybluemix.net/rest/v2/emails');
curl_setopt_array($ch, array(
    CURLOPT_POST => TRUE,
    CURLOPT_RETURNTRANSFER => TRUE,
    CURLOPT_HTTPHEADER => array(
        "Authorization: Basic " . base64_encode($username . ":" . $password),
        'Content-Type: application/json'
    ),
    CURLOPT_URL => $URL,
    CURLOPT_POSTFIELDS => $postData
));

$response = curl_exec($ch);

if($response === FALSE){
    die(curl_error($ch));
}
$responseData = json_decode($response, TRUE);

print_r($responseData);
?>