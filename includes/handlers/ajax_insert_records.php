<?php
$connect = mysqli_connect("localhost", "root", "", "business");
session_start();

if(!empty($_POST)) {

    $added_by = mysqli_real_escape_string($connect, $_POST["added_by"]);
    $date_added = mysqli_real_escape_string($connect, $_POST["date_added"]);
    $status = mysqli_real_escape_string($connect, $_POST["status"]);

    if($_POST["records_id"] != '') {
        $query = "
        UPDATE posts
        SET added_by='$added_by',
        date_added='$date_added',
        status='$status'
        WHERE id='".$_POST["records_id"]."'";

        $_SESSION['update_message'] = "<div class='alert alert-success alert-dismissible fade show mt-2'>
                                            <button type='button' class='close' data-dismiss='alert'>&times;</button>
                                            Row has been <strong>Updated</strong>!
                                        </div>";
        
        //========= Start PHP Mailer =========
        $records_details_query = mysqli_query($connect, "SELECT * FROM posts WHERE id='" . $_POST["records_id"] . "'");
        $records = mysqli_fetch_array($records_details_query);

        date_default_timezone_set('Asia/Manila');

        function clean_text($string)
        {
            $string = trim($string);
            $string = stripslashes($string);
            $string = htmlspecialchars($string);
            return $string;
        }
        // If Verified Status
        if ($status == "Verified") {
            require '../../phpmailer/class/class.phpmailer.php';
            $mail = new PHPMailer;
            $mail->IsSMTP();                                //Sets Mailer to send message using SMTP
            $mail->Host = 'smtp.gmail.com';        //Sets the SMTP hosts of your Email hosting, this for Godaddy
            $mail->Port = '587';                                //Sets the default SMTP server port
            $mail->SMTPAuth = true;                            //Sets SMTP authentication. Utilizes the Username and Password variables
            $mail->Username = 'wetutwetut@gmail.com';                    //Sets SMTP username
            $mail->Password = 'wetwet666';                    //Sets SMTP password
            $mail->SMTPSecure = 'tls';                            //Sets connection prefix. Options are "", "ssl" or "tls"
            $mail->From = $records['email'];                    //Sets the From email address for the message
            $mail->FromName = "BPR-SantaMariaLaguna";                //Sets the From name of the message
            $mail->AddAddress('wetutwetut@gmail.com', 'BPR-SantaMariaLaguna');        //Adds a "To" address
            $mail->AddCC($records['email'], "Moderator");    //Adds a "Cc" address
            $mail->WordWrap = 50;                            //Sets word wrapping on the body of the message to a given number of characters
            $mail->IsHTML(true);                            //Sets message type to HTML				
            $mail->Subject = "Important Notice (VERIFIED)";                //Sets the Subject of the message
            $mail->Body = "									
                <html>
                <body>
                    <p>
                        Magandang araw <strong>" . $records['first_name'] . " " . $records['last_name'] . "</strong> </strong>,
                    </p>
                    <p>
                        Ang iyong BUSINESS PERMIT REGISTRATION ay NAAPRUBAHAN nito lamang " . date('F j, Y g:i:a  '). "<br>
                        Mangyari lamang na pumunta sa Munisipyo ng Sta. Maria, Laguna upang magbayad at makuha ang pisikal na dokumento. 
                        <br><br>
                        <strong> ========= This is an automated message. Do not reply. =========</strong>
                    </p>
                </body>
                </html>"; // Customize Html Template

            if ($mail->Send()) //Send an Email. Return true on success or false on error
            {
                $error = '<label class="text-success">Thank you for contacting us</label>';
            } else {
                $error = '<label class="text-danger">There is an Error</label>';
            }
        }else if ($status == "Please Resubmit") {
            require '../../phpmailer/class/class.phpmailer.php';
            $mail = new PHPMailer;
            $mail->IsSMTP();                                //Sets Mailer to send message using SMTP
            $mail->Host = 'smtp.gmail.com';        //Sets the SMTP hosts of your Email hosting, this for Godaddy
            $mail->Port = '587';                                //Sets the default SMTP server port
            $mail->SMTPAuth = true;                            //Sets SMTP authentication. Utilizes the Username and Password variables
            $mail->Username = 'bannedefused3@gmail.com';                    //Sets SMTP username
            $mail->Password = '0639854227101msdcfredsw';                    //Sets SMTP password
            $mail->SMTPSecure = 'tls';                            //Sets connection prefix. Options are "", "ssl" or "tls"
            $mail->From = $records['email'];                    //Sets the From email address for the message
            $mail->FromName = "BPR-SantaMariaLaguna";                //Sets the From name of the message
            $mail->AddAddress('bannedefused3@gmail.com', 'BPR-SantaMariaLaguna');        //Adds a "To" address
            $mail->AddCC($records['email'], "Moderator");    //Adds a "Cc" address
            $mail->WordWrap = 50;                            //Sets word wrapping on the body of the message to a given number of characters
            $mail->IsHTML(true);                            //Sets message type to HTML				
            $mail->Subject = "Important Notice (REJECT)";                //Sets the Subject of the message
            $mail->Body = "									
                <html>
                <body>
                    <p>
                        Magandang araw <strong>" . $records['first_name'] . " " . $records['last_name'] . "</strong> </strong>,
                    </p>
                    <p>
                        Ang iyong BUSINESS PERMIT REGISTRATION ay HINDI NAAPRUBAHAN.<br>
                        Siguraduhin na ang mga impormasyon na iyong inilagay ay wasto.
                        <br><br>

                        <strong> ========= This is an automated message. Do not reply. =========</strong>
                    </p>
                </body>
                </html>"; // Customize Html Template

            if ($mail->Send()) //Send an Email. Return true on success or false on error
            {
                $error = '<label class="text-success">Thank you for contacting us</label>';
            } else {
                $error = '<label class="text-danger">There is an Error</label>';
            }
        }
        else {

        }
        //========= End PHP Mailer =========





    }
    else {
        // $query = "
        // INSERT INTO users(first_name, last_name, username, email, password, signup_date, user_type, gender)
        // VALUES('$first_name', '$last_name','$username', '$email', '$password_1', '$signup_date', '$user_type', '$gender');
        // ";
    }
    if(mysqli_query($connect, $query)) {

    }

}


?>
