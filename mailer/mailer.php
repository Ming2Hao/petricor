<pre>
<?php
require_once("../connection.php");
include('OAuthTokenProvider.php');
include('Exception.php');
include('PHPMailer.php');
include('OAuth.php');
include('SMTP.php');
include('POP3.php');



use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


				//Create a new PHPMailer instance
				$mail = new PHPMailer();
				$mail->isSMTP();
				//$mail->SMTPDebug = SMTP::DEBUG_SERVER;
				$mail->Host = 'smtp.gmail.com';
				$mail->Port = 587;

				// Khsusus AMPPS set SSL spt ini	
				$mail->SMTPOptions = array(
					'ssl' => array(
						'verify_peer' => false,
						'verify_peer_name' => false,
						'allow_self_signed' => true
						)
					); 				
				
				$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
				$mail->SMTPSecure ='tls';
				$mail->SMTPAuth = true;
				$mail->Username = 'ivancs2010ggg@gmail.com';
				$mail->Password = 'eufmtzijhyydinjf';
				
				//Recipients
				$mail->setFrom('asdasdasdasd@gmail.com', $_SESSION['imel']);
				$mail->addAddress('erefivfurniture@gmail.com', 'erefiv');


            $mail->Subject  = $_SESSION["subyek"];
            $mail->Body     = $_SESSION["komentars"];
            $mail->WordWrap = 50;  

            if(!$mail->Send()) {
            	echo "<script>alert('Failed.')</script>";
            } else {
            	echo "<script>alert('Message has been sent.')</script>";
            }
			if(isset($_SESSION['currentUser'])){

				header('location: ../indexSudahLogin.php');
			}
			else{
				header('location: ../index.php');

			}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Document</title>
</head>
<body>
	
</body>
</html>
