<?php

session_name("oauthtester");
session_start();

require __DIR__ . '/vendor/autoload.php';

use ANS\src\SendData;

$data = array(
  'firstname' => 'Prueba 3',
  'lastname'  => 'Contact',
  'email'     => 'prueba_4@example.com',
  'ipAddress' => '192.168.1.122'
);

var_dump($_SESSION);

$sendData = new SendData();

//$sendData->send($data);

