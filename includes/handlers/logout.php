<?php
include('../../gconfig.php');
$google_client->revokeToken(['access_token']);

session_start();
session_destroy();
header("Location: ../../login.php")
?>
