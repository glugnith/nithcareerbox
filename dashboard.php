<?php
	session_start();
	include("config.php");
	
	if(!$con)
	{
		die('Could not connect: ' . mysqli_error());
		echo "connection failed.";
	}
	else
	{
		if(!isset($_SESSION['admin_usr']))
	  	{
	  		header("Location:login.php");
	  	}
	}
	
?>
<!DOCTYPE html>
<html>
<head>
	<title>Dashboard</title>
	<link rel="stylesheet" href="checkfile.css" type="text/css">
	<link rel="stylesheet" href="css/bootstrap.min.css">

</head>
<body>
<ul class="nav nav-tabs">
	  <li role="presentation" class="active"><a href="#">Admin</a></li>
	  <li role="presentation"><a href="#">Download All</a></li>
	  <li role="presentation"><a href="logout.php">Log Out</a></li>
</ul>
<h1>Welcome Admin</h1>

</body>
</html>