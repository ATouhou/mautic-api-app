<?php
session_name("oauthtester");
session_start();

require __DIR__ . '/vendor/autoload.php';

use Mautic\Auth\ApiAuth;
use Mautic\MauticApi;

$access_token = getAccessToken();
$access_token_secret = accessTokenSecret();

var_dump($access_token);
var_dump($access_token_secret);

// ApiAuth::initiate will accept an array of OAuth settings
$settings = array(
    'baseUrl'      => 'http://localhost/mautic',
    'version'      => 'OAuth1a',
    'clientKey'    => '4iuna559fd0ks0s4ckgko40kw4cwc8wso0ksoggkc4w4g4s4k',
    'clientSecret' => '30xc05amfukgsokss04cgk8gwws84kk4ccg8soogo480s8w440', 
    'callback'     => 'http://localhost/html/mautic-api-app'
);

$auth = ApiAuth::initiate($settings);

if (!empty($access_token) && !empty($access_token_secret)) {
	//var_dump($_SESSION);
	$accessToken = array();
	$accessToken['access_token'] = $access_token;
	$accessToken['access_token_secret'] = $access_token_secret;
	$accessToken['expires'] = null;
	$accessToken['refresh_token'] = null;
	$auth->setAccessTokenDetails($accessToken);
}



if ($auth->validateAccessToken()) {
	echo 'El token está validado ';
	if ($auth->accessTokenUpdated()) {
		echo 'El token ha sido actualizado ';
		$accessTokenData = $auth->getAccessTokenData();
		saveToken($accessTokenData);
	}
	$apiUrl = 'http://localhost/mautic';
  $contactApi = MauticApi::getContext("contacts", $auth, $apiUrl);
  $contact = $contactApi->get(1);
  var_dump($contact);
  $data = array(
    'firstname' => 'Prueba 6',
    'lastname'  => 'Contact',
    'email'     => 'jim@his-site6.com',
    'ipAddress' => '192.168.1.122'
	);

	var_dump($contact = $contactApi->create($data));
	
} else {
	echo 'El token no está validado ';
}



function saveToken($accessTokenData)
{
	$access_token = $accessTokenData['access_token'];
	$access_token_secret = $accessTokenData['access_token_secret'];
	file_put_contents('accessToken.txt', $access_token);
	file_put_contents('accessTokenSecret.txt', $access_token_secret);
}


function getAccessToken()
{
	return file_get_contents('accessToken.txt');
}

function accessTokenSecret()
{
	return file_get_contents('accessTokenSecret.txt');
}