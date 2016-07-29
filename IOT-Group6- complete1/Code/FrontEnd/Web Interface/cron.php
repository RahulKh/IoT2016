<?php
/*
Note: For this prototype the database/email account password have been written in plaintext for simplicity purposes and we acknowledge this is huge security risk. In real life product the code would reference an external file where the password would be retrieve from. And this would  not be accessible externally. 
*/
#Retrieve the log to send
$logfile = file_get_contents('Alerts.log');
$hour = "00";
$min = "00";

$today = date("H:i");

	$conn = mysqli_connect("localhost","root","password","email") or die("Couldn't connect to mysql");

if ($today == $hour.":".$min)
{	
	require ('./PHPMailer/PHPMailerAutoload.php');

	$conn = mysqli_connect("localhost","root","password","email") or die("Couldn't connect to mysql");

 	$sql = "SELECT username FROM users WHERE id='1'";
  	$result = mysqli_query($conn,$sql);
  	$row = mysqli_fetch_assoc($result);
  	$dbusername = $row['username'];

	$username = $dbusername;
	if ($username == "")
        	echo "Please login first";
    	else{
              $conn = mysqli_connect("localhost","root","password","login") or die("Couldn't connect to mysql");

	#----------------------------Emailing---------------------------------
	
	$q1 = "SELECT email FROM users WHERE username='$username'";
        $result1 = mysqli_query($conn,$q1);
        $r1 = mysqli_fetch_assoc($result1);
        $email = $r1["email"];
	#$email = "uoit2016iot@outlook.com";
		  
	$mail = new PHPMailer;

	$mail->isSMTP();					// Set mailer to use SMTP
	$mail->Host = 'smtp.live.com';				// Specify main and backup SMTP servers
	$mail->SMTPAuth = true;					// Enable SMTP authentication
	$mail->Username = 'uoit2016iot@outlook.com';		// SMTP username
	$mail->Password = 'Uoit2016';				// SMTP password
	$mail->SMTPSecure = 'tls';				// Enable TLS encryption, `ssl` also accepted
	$mail->Port = 587;					// TCP port to connect to
	
	$mail->setFrom('from@example.com', 'Mailer');
	$mail->addAddress($email, 'Michael Western'); 
	$mail->isHTML(true);                                  	// Set email format to HTML
	
	$mail->Subject = 'Message';
	$mail->Body    = $logfile;
	$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
	
	if(!$mail->send()) {
	    echo 'Message could not be sent.';
	    echo 'Mailer Error: ' . $mail->ErrorInfo;
	} else {
	    echo 'Message has been sent';
	}
}
}
#Closes the connections to mysql
$conn->close();
?>
