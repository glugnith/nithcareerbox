<?php
	include("config.php");
	session_start();
		/*try
		{
			$con = new PDO('mysql:host=localhost;dbname=nithcareerbox','root','tryagain');			
			echo "connected successfully";

			//$results = $con->query('SELECT * FROM user WHERE username= 13517');
			if(isset($_POST['admin_login']))
			{
				$admin_usr = $_POST['admin_usr'];
				$admin_pass = $_POST['admin_pass'];

				$con->query('SELECT * FROM admin WHERE admin_usr = $admin_usr AND password = $admin_pass');


			}
		}
		catch(PDOException $err)
		{
			echo 'ERROR:' .$err->getMessage();
		}*/
		if(isset($_SESSION['admin_usr']))
		{
			header("Location:dashboard.php");
		}
		if (!$con)
	 	{
	 		die('Could not connect: ' . mysqli_error());
	  		echo "could not connect";
	  	}
	  	if (isset($_POST['admin_login']))
		{
	   	// login related check
			//get value
			$username = $_POST['admin_usr'];
			$password = $_POST['admin_pass'];
			//fetching data from database
			$result = mysqli_query($con,"SELECT * FROM tbl_admin WHERE username = '$username' AND password = '$password'");
			//validate
			//checking if database retuns any rows
			$count = mysqli_num_rows($result);
			if($count > 0)
			{
				$_SESSION['admin_usr'] = $username;
				header("Location: dashboard.php");
			}
			else
			{
				$wrongpwd = "Wrong Username or password";
				echo "not loged in";
			}
		} 
		
		
?>

<!DOCTYPE html>
<html>
<head>
	<title>Admin panel</title>
	<link rel="stylesheet" href="checkfile.css" type="text/css">
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<link rel="stylesheet" href="admin.css">
</head>
<body>

<!-- Form-->
<div class="admin">
<div class="image"></div>
<form class="form-inline" action="admin.php" method="post">
  <div class="form-group">
    <label for="exampleInputName2">Admin</label>
    <input type="text" class="form-control" id="exampleInputName2" placeholder="Name" name="admin_usr">
  </div>
  <div class="form-group2">
    <label for="exampleInputEmail2">Key</label>
    <div class="first"><input type="password" class="form-control" id="exampleInputEmail2" placeholder="passoword" name="admin_pass" >
  </div>
  <div class="second"><button type="" class="btn btn-default" name="admin_login">Log In</button></div>
</form>
</div>
</body>
</html>