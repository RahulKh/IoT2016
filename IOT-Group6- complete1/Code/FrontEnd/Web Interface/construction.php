<html>
<head>
<title>Under Construction</title>
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
						<li > <a href= "home.php" > Home </a></li>
						<li > <a href= "construction.php"> Dashboard </a></li>
						
						<li class= "dropdown">
							<a href= "#" class = "dropdown-toggle" data-toggle="dropdown"> Settings<b class = "caret"></b></a>
							<ul class="dropdown-menu">
							<li> <a href="mail.php"> Email Now </a> </li>
							<li> <a href="construction.php"> Email Settings </a> </li>
							</ul>
						</li>
					</ul>
				</div>
			</div>
	</div>
<?php
#Starts the session
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
?>
<br>
<br>	
	<center><img src="construction.jpg"><center>

<br>
<br>
<div class= "navbar navbar-inverse navbar-fixed-bottom">

	<div class="container">
		<p class="navbar-text pull-left"> <a href="aboutus.php"> About Us</a> </p>

		<a href = "logout.php" class= "navbar-btn btn-primary btn pull-right"> Log Out </a>
	</div>
	
</div>
</body>
</html>
<?php
}
?>
