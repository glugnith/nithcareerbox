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
	<link rel="stylesheet" href="upload.css" type="text/css">

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
	<div class="navigation-bar">
	<ul class="nav nav-tabs">
  <li role="presentation" class="active"><a href="#"><?php echo $_SESSION['user'];?></a></li>
  <li role="presentation"><a href="#">Profile</a></li>
  <li role="presentation"><a href="logout.php">Logout</a></li>
</ul>
	</div>
<div class="flex-container">
	<h1 id="upload">Upload your file here</h1>
	<form action="upload.php" method="post" enctype="multipart/form-data">
		<div class="flex-item1">
		<input type="file" name="myfile">
		</div>
		<div class="flex-item1">
		<input type="submit" name="upload" value="upload">
		</div>
	</form>
	<form action="view.php" method="post" >
		<div class="flex-item3">
		<button type="submit" class="btn btn-warning" name="view_cv">View CV</button>
		</div>
	</form>
	<p><?php if(isset($_GET['error'])) if($_GET['error'] == 1 ) echo "* No CV uploaded yet.";
		else if($_GET['error'] == 2 ) echo "* no file selected";
		else if($_GET['error'] == 3 ) echo "Only pdf file is allowed."; ?></p>
</div>

</body>
</html>