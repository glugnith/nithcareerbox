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
	<link rel="stylesheet" href="checkfile.css" type="text/css">
	<link rel="stylesheet" href="css/bootstrap.min.css">

</head>
<body>
<!-- <nav class="navbar navbar-default">
  <div class="container-fluid">
    <div class="navbar-header">
      <a class="navbar-brand" href="#">
        
      </a>
    </div>
  </div>
</nav> -->
	<ul class="nav nav-tabs">
  <li role="presentation" class="active"><a href="#"><?php echo $_SESSION['user'];?></a></li>
  <li role="presentation"><a href="#">Profile</a></li>
  <li role="presentation"><a href="logout.php">Logout</a></li>
</ul>
	<h1>Upload your file here</h1>
	<form action="upload.php" method="post" enctype="multipart/form-data">
		<input type="file" name="myfile">
		<input type="submit" name="upload" value="upload">
		
	</form>
	<form action="view.php" method="post" >
		
		<button type="submit" class="btn btn-warning" name="view_cv">View CV</button>

	</form>

</body>
</html>