<?php
session_name("oauthtester");
session_start();

require __DIR__ . '/vendor/autoload.php';

use Mautic\Auth\ApiAuth;
use Mautic\MauticApi;

// ApiAuth::initiate will accept an array of OAuth settings
$settings = array(
    'baseUrl'      => 'http://localhost/mautic',
    'version'      => 'OAuth1a',
    'clientKey'    => '2z1txnfms8ysw0ogsooksw0o84048gw8cwo8ccsc80ss008sw4',
    'clientSecret' => '55h90z8xolgk8ko4cgkskc4ccgg40c40gk4k0c4wwggcg8ossk', 
    'callback'     => 'http://localhost/mautic-api-app'
);

// Initiate the auth object
$auth = ApiAuth::initiate($settings);


if (!empty($_SESSION['access_token'])) {
	//var_dump($_SESSION);
	$accessToken = array();
	$accessToken['access_token'] = $_SESSION['access_token'];
	$accessToken['access_token_secret'] = $_SESSION['access_token_secret'];
	$accessToken['expires'] = $_SESSION['expires'];
	$accessToken['refresh_token'] = $_SESSION['refresh_token'];
	$auth->setAccessTokenDetails($accessToken);
}

$auth->enableDebugMode();

//$auth->setAccessTokenDetails($_SESSION[$auth]);

if ($auth->validateAccessToken()) {
    if ($auth->accessTokenUpdated()) {
        $accessTokenData = $auth->getAccessTokenData();
        $_SESSION['access_token'] = $accessTokenData['access_token'];
        $_SESSION['access_token_secret'] = $accessTokenData['access_token_secret'];
        $_SESSION['expires'] = $accessTokenData['expires'];
        $_SESSION['refresh_token'] = null;

        var_dump($accessTokenData);

        //$auth = ApiAuth::initiate($settings);
        $apiUrl = 'http://localhost/mautic';
        $contactApi = MauticApi::getContext("contacts", $auth, $apiUrl);
        var_dump($contactApi);
        $contact = $contactApi->getOwners();
        $contact = $contactApi->get(1);
        var_dump($contact);

        

    } else {
    	var_dump('ya está autorizada');
    	$apiUrl = 'http://localhost/mautic';
	    $contactApi = MauticApi::getContext("contacts", $auth, $apiUrl);
	    var_dump($contactApi);
	    $contact = $contactApi->getOwners();
	    $contact = $contactApi->get(1);
	    var_dump($contact);
	            // Creo un contacto
	    echo 'creo un contacto';
        $data = array(
			    'firstname' => 'Prueba 3',
			    'lastname'  => 'Contact',
			    'email'     => 'prueba_3@example.com',
			    'ipAddress' => '192.168.1.22'
				);

				var_dump($contact = $contactApi->create($data));
    }

} else {
		echo 'no ha validado el acceso';
}

//var_dump($auth->getDebugInfo());


//$apiUrl = 'http://localhost/mautic';
//$contactApi = MauticApi::getContext("contacts", $auth, $apiUrl);

