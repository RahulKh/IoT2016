<html>
<head>
<title>Login</title>
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
						<li class="active"> <a href= "home.php" > Home </a></li>
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

session_start();

$username = @$_POST['username'];
$password = @$_POST['password'];

if ($username&&$password)
{
  $conn = mysqli_connect("localhost","root","password","login") or die("Couldn't connect to mysql");

  $sql = "SELECT * FROM users WHERE username='$username'";
  $result = mysqli_query($conn,$sql);
  $numrows = mysqli_num_rows($result);
  if ($numrows!=0)
  {
    while ($row = mysqli_fetch_assoc($result))
    {
      $dbusername = $row['username'];
      $dbpassword = $row['password'];
    }
#Checks if the username and password match the database
    if ($username==$dbusername&&hash('sha512',$password)==$dbpassword)
    {
       @$_SESSION['username']=$username;
	?>
	<h2>Logged In!</h2>
	<?php
	header("refresh:1;url=home.php");
	die();
    }
    else
       ?>
	<h2>Incorrect password!!</h2>
	<?php
	header("refresh:5;url=index.php");
    	die();

  }
  else
	?>
	<h2>This users doesn't exist!</h2>
	<?php
	header("refresh:5;url=index.php");
    	die();

}
else
?>
	<h2>Please login first</h2>
	<?php
	header("refresh:5;url=index.php");
    die();

#Closes the connections to mysql
$conn->close();
?>
</div>
</body>
</html>
