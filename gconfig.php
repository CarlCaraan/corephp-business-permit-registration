<?php
require_once 'vendor/autoload.php';


$google_client = new Google_Client();

$google_client->setClientId('1027852877992-gmjnevvt61vjmo17nsbi2hi6jhb21fpo.apps.googleusercontent.com'); // Set Client Id

$google_client->setClientSecret('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');

$google_client->setRedirectUri('http://localhost/Business%20Permit%20Registration/adminhome.php'); // Set Secret Id

$google_client->addScope('email');

$google_client->addScope('profile');
?>
