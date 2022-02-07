<?php

require_once __DIR__ . '/vendor/autoload.php';

//Grab variables
$first_name = $_POST['first_name'];
$last_name = $_POST['last_name'];
$middle_name = $_POST['middle_name'];
$suffix_name = $_POST['suffix_name'];
$email = $_POST['email'];
$phone = $_POST['phone'];

//Create new pdf instance
$mpdf = new \Mpdf\Mpdf(['tempDir' => 'C:/']);

//Create our pdf
$data = '';

$data .= '<h1>Your Details</h1>';

//Add data
$data .= '<strong>First Name: </strong>' . $first_name . '<br>';
$data .= '<strong>Last Name: </strong>' . $last_name . '<br>';
$data .= '<strong>Middle Name: </strong>' . $middle_name . '<br>';
$data .= '<strong>Suffix Name: </strong>' . $suffix_name . '<br>';
$data .= '<strong>Email: </strong>' . $email . '<br>';
$data .= '<strong>Phone Number: </strong>' . $phone . '<br>';

//Write pdf
$mpdf->WriteHTML($data);


//Output to browser
$mpdf->Output('' . $first_name . " " . $last_name . '.pdf', 'D');
