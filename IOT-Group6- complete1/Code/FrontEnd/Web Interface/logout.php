<?php

session_start();
#Destroys the session
session_destroy();
?>
<html>
<head>
<title>Logout</title>
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
<h2>Logged Out</h2>
<?php
    header("refresh:5;url=index.php");
    die();
?>
</div>
</body>
</html>
