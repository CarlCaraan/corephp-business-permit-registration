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

$data .= '
<div style="width: 100%; align-items: center; text-align: center; justify-content: center;">
    <h5>Republic of the Philippines</h5>
    <h5>Province of Laguna</h5>
    <h5>Municipality of Santa Maria</h5>
    <h3>Office of the Mayor</h3>

    <hr>

    <h1>BUSINESS PERMIT</h1>

</div>
is granted to:<br><br>
';

//Add data
$data .= '<strong>Full Name: </strong>' . $first_name . ' ' . $last_name . ' ' . $middle_name . ' ' . $last_name . ' ' . $suffix_name . '<br>';
$data .= '<strong>Email: </strong>' . $email . '<br>';
$data .= '<strong>Phone Number: </strong>' . $phone . '<br>';

//Write pdf
$mpdf->WriteHTML($data);


//Output to browser
$mpdf->Output('' . $first_name . " " . $last_name . '.pdf', 'D');
