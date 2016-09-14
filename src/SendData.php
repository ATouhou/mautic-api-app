<?php

namespace ANS\src;

use Mautic\Auth\ApiAuth;
use Mautic\MauticApi;

class SendData
{
	private $settings = array();
	private $auth;
	private $access_token = '2kzypijke5icck44gg0gkgggggccgoocwcs0g4o84kw04g0s0o';
	private $access_token_secret = '5pan9u12uc084okso8owo8ssogc084s0g8wocw8c4w4o8s4s84';

	public function __construct()
	{
		//var_dump($_SESSION);
		$this->settings = array(
	    'baseUrl'      => 'http://localhost/mautic',
	    'version'      => 'OAuth1a',
	    'clientKey'    => '104u3x971dao88kwoko4swo40ko0c4gw0sww4ggg8wo0g4scwo',
	    'clientSecret' => '5vd2m6syi3wows0sok8ook40oo4k0csc80oocc44cc0wwoco4g', 
	    'callback'     => 'http://localhost/mautic-api-app/index2.php'
		);

		$this->auth = ApiAuth::initiate($this->settings);
		$this->saveSession();
		$this->auth->enableDebugMode();
		var_dump($this->auth->validateAccessToken());
		$this->validateAccessToken();
	}

	public function send($data)
	{
		$apiUrl = 'http://localhost/mautic';
	  $contactApi = MauticApi::getContext("contacts", $this->auth, $apiUrl);
	  $contact = $contactApi->create($data);
	}

	public function saveSession()
	{
		if (!empty($_SESSION['access_token'])) {
			//var_dump($_SESSION);
			$accessToken = array();
			//$accessToken['access_token'] = $_SESSION['access_token'];
			$accessToken['access_token'] = $this->access_token;
			//$accessToken['access_token_secret'] = $_SESSION['access_token_secret'];
			$accessToken['access_token_secret'] = $this->access_token_secret;
			$accessToken['expires'] = $_SESSION['expires'];
			$accessToken['refresh_token'] = $_SESSION['refresh_token'];
			$this->auth->setAccessTokenDetails($accessToken);
		}
	}

	public function validateAccessToken()
	{
		if ($this->auth->validateAccessToken()) {
		    if ($this->auth->accessTokenUpdated()) {
		        $accessTokenData = $this->auth->getAccessTokenData();
		        var_dump($accessTokenData);
		        $_SESSION['access_token'] = $accessTokenData['access_token'];
		        $_SESSION['access_token_secret'] = $accessTokenData['access_token_secret'];
		        $_SESSION['expires'] = $accessTokenData['expires'];
		        $_SESSION['refresh_token'] = null;
		    } 
		}
		$accessTokenData = $this->auth->getAccessTokenData();
		var_dump($accessTokenData); 
	}

}