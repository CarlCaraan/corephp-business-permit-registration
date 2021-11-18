<?php

require_once __DIR__ . '/vendor/autoload.php';

//Grab variables
$fname = $_POST['fname'];
$lname = $_POST['lname'];
$email = $_POST['email'];
$phone = $_POST['phone'];

//Create new pdf instance
$mpdf = new \Mpdf\Mpdf(['tempDir' => 'C:/']);

//Create our pdf
$data = '';

$data .= '<h1>Your Details</h1>';

//Add data
$data .= '<strong>First Name: </strong>' . $fname . '<br>';
$data .= '<strong>Last Name: </strong>' . $lname . '<br>';
$data .= '<strong>Email: </strong>' . $email . '<br>';
$data .= '<strong>Phone Number: </strong>' . $phone . '<br>';

//Write pdf
$mpdf->WriteHTML($data);


//Output to browser
$mpdf->Output('' . $fname . " " . $lname . '.pdf', 'D');
