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
    'clientKey'    => '4iuna559fd0ks0s4ckgko40kw4cwc8wso0ksoggkc4w4g4s4k',
    'clientSecret' => '30xc05amfukgsokss04cgk8gwws84kk4ccg8soogo480s8w440', 
    'callback'     => 'http://localhost/html/mautic-api-app'
);

// Initiate the auth object
$auth = ApiAuth::initiate($settings);

// Initiate process for obtaining an access token; this will redirect the user to the authorize endpoint and/or set the tokens when the user is redirected back after granting authorization

//var_dump($auth);

$auth->enableDebugMode();

//$accesToken = $auth->getAccessTokenData();
//var_dump($auth->getDebugInfo());

//var_dump($accesToken);

//var_dump($auth->validateAccessToken()); // llama a mautic para autorizar el acceso y presenta la pantalla de login

//$accesToken = $auth->getAccessTokenData();



if ($auth->validateAccessToken()) {
    if ($auth->accessTokenUpdated()) {
        $accessTokenData = $auth->getAccessTokenData();
        var_dump($accessTokenData);

        //$auth = ApiAuth::initiate($settings);
        $apiUrl = 'http://localhost/mautic';
        $contactApi = MauticApi::getContext("contacts", $auth, $apiUrl);
        var_dump($contactApi);
        $contact = $contactApi->getOwners();
        var_dump($contact);
    } else {
    	var_dump('ya está autorizada');
    	//$apiUrl = 'http://localhost/mautic';
			//$contactApi = MauticApi::getContext("contacts", $auth, $apiUrl);
    }

}

//var_dump($auth->getDebugInfo());


//$apiUrl = 'http://localhost/mautic';
//$contactApi = MauticApi::getContext("contacts", $auth, $apiUrl);

