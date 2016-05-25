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
		if(!isset($_SESSION['user']))
	  	{
	  		header("Location:login.php");
	  	}
	}
	
?>
<!DOCTYPE html>
<html>
<head>
	<title>Nith CareerBox</title>
</head>
<body>
	<h1>Welcome <?php echo $_SESSION['user'];?></h1>
	<h1>Upload your file here</h1>
	<form action="upload.php" method="post" enctype="multipart/form-data">
		<input type="file" name="myfile">
		<input type="submit" name="upload" value="upload">
	</form>
	<form action="view.php" method="post">
		<input type="submit" name="view_cv" value="View CV">

	</form>
	<a href="logout.php">logout</a>

</body>
</html>