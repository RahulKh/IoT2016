<?php
/*
Note: For this prototype the database/email account password have been written in plaintext for simplicity purposes and we acknowledge this is huge security risk. In real life product the code would reference an external file where the password would be retrieve from. And this would  not be accessible externally. 
*/
?>
<html>
<head>
<title>Mail</title>
<meta name ="viewport" content="width=device-width initial-scale = 1.0"> 
<link href= "css/bootstrap.min.css" rel = "stylesheet">
<link href= "css/styles.css" rel = "stylesheet">

</head>
<body>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script src= "js/bootstrap.js"> </script>

	<div class="navbar navbar-inverse navbar-static-top">
		<div class="container">
				<div class="navbar-header">
						<a class="navbar-brand" href"#">IOT Network Management</a>
						</div>
						<div class="collapse navbar-collapse navHeaderCollapse">
						<ul class= "nav navbar-nav navbar-right">
						<li class="active"> <a href= "#" > Home </a></li>
						<li > <a href= "#"> Dashboard </a></li>
						<li class= "dropdown">
							<a href= "#" class = "dropdown-toggle" data-toggle="dropdown"> Settings<b class = "caret"></b></a>
							<ul class="dropdown-menu">
							<li> <a href="#"> Email Now </a> </li>
							<li> <a href="#"> Email Settings </a> </li>
							</ul>
						</li>
					</ul>
				</div>
			</div>
	</div>
<div class= "container" id="one">
		<div class="jumbotron">
<?php
require ('./PHPMailer/PHPMailerAutoload.php');

session_start();
$username = @$_SESSION['username'];
if ($username == "")
       {
	?>
	<h2>Please login first</h2>
	<?php
	header("refresh:5;url=index.php");
    die();
}
    else{
	      $conn = mysqli_connect("localhost","root","password","login") or die("Couldn't connect to mysql");
              $logfile = file_get_contents('Alerts.log');
	    #----------------------------Emailing---------------------------------

	$q1 = "SELECT email FROM users WHERE username='$username'";
        $result1 = mysqli_query($conn,$q1);
        $r1 = mysqli_fetch_assoc($result1);
        $email = $r1["email"];
	
	$mail = new PHPMailer;


	$mail->isSMTP();					// Set mailer to use SMTP
	$mail->Host = 'smtp.live.com';  			// Specify main and backup SMTP servers
	$mail->SMTPAuth = true;					// Enable SMTP authentication
	$mail->Username = 'uoit2016iot@outlook.com';		// SMTP username
	$mail->Password = 'Uoit2016';				// SMTP password
	$mail->SMTPSecure = 'tls';				// Enable TLS encryption, `ssl` also accepted
	$mail->Port = 587;					// TCP port to connect to
	
	$mail->setFrom('from@example.com', 'Mailer');
	$mail->addAddress($email, 'Michael Western');     
	
	$mail->isHTML(true);
	
	$mail->Subject = 'Message';
	$mail->Body    = $logfile;
	$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
	
	if(!$mail->send()) {
?>
    	<h2>Message could not be sent</h2>
<?php
	echo 'Mailer Error: ' . $mail->ErrorInfo;
	header("refresh:2;url=home.php");
    	die();
	} else {
?>
    	<h2>Message sent</h2>
<?php
	header("refresh:2;url=home.php");
    	die();
}
}
#Closes the connections to mysql
$conn->close();
?>
</div>
</body>
</html>
