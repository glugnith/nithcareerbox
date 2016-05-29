<?php include("config.php");
session_start();
if(isset($_SESSION['user'])){
	header("Location:index.php");
}
if (!$con)
 	{
 		die('Could not connect: ' . mysqli_error());
  		echo "could not connect";
  	}
	if (isset($_POST['loginform']))
	{
   	// login related check
		//get value
		$username = $_POST['username'];
		$password = $_POST['password'];
		//fetching data from database
		$result = mysqli_query($con,"SELECT * FROM user WHERE username = '$username' AND password = '$password'");
		//validate
		//checking if database retuns any rows
		$out = mysqli_fetch_array($result);
		$active = $out['active'];
		$count = 0;
		$count = mysqli_num_rows($result);
		
		if($count > 0 && $active == 1)
		{
			$_SESSION['user'] = $username;
			header("Location: index.php");
		}
		else if( $count > 0 && $active == 0 )
			$wrongpwd = "Ask the admin to activate your account manually.";
		else
			$wrongpwd = "Wrong Username or password";
	} 
	//registration form section..................
	if (isset($_POST['registerform']))
	{
	   // registration related check
		$regusername = $_POST['regusername'];
		$regfullname = $_POST['regfullname'];
		$regemail = $_POST['regemail'];
		$regpwd1 = $_POST['regpwd1'];
		$regpwd2 = $_POST['regpwd2'];

		//comparing both passwords........
		//if passoword do not match show error
		if( !($regpwd1 == $regpwd2))
		{
			$unmatchedpass = "password do not match";
		}
		//if successful.............
		else
		{
			//$a = htmlspecialchars($regfullname);
			
			mysqli_query($con,"insert into user values($regusername, '$regfullname', '$regemail','$regpwd1', null ,0)");
			$success = "Registration successful";
			$_SESSION['MESSAGE'] = $success;
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
<body class="background">
<style type="text/css">
   body { background: navy !important; } /* Adding !important forces the browser to overwrite the default style applied by Bootstrap */
</style>
<!-- Sign up button -->
<div id="first">
<form class="login">
<button  type="button" class="btn btn-primary" data-toggle="modal" data-target="#signupForm">
	SignUp
</button>

<!-- Log in button -->

<button type="button"  class="btn btn-primary" data-toggle="modal" data-target="#loginForm">
	LogIN
</button>
</form>
</div>
<div style="text-align: center; color: green; ">
	<h6 style="font-size: 20px; color: green;"><?php if(isset($_POST['registerform']))echo $sucess; ?></h6>
	<h6 style="font-size: 20px; color: red;"><?php if(isset($_POST['registerform']))echo $unmatchedpass; ?></h6>
	<h5 style="font-size: 20px; color: red;"><?php if(isset($_POST['loginform']))echo $wrongpwd; ?></h5>
</div>
<!--Pop up sign Up form -->
<div class="modal fade" id="signupForm">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label=""><span>&times;</span>
				</button>
				<h4 class="modal-title">Sign Up</h4>
			</div>
			<div class="modal-body">
				<form class="form-horizontal" action="login.php" method="post">
					<div class="form-group">
						<label class="col-md-4 col-md-offset-1">Name:</label>
						<div class="col-md-5">
							<input type="text" class="form-control input-sm" name="regfullname" placeholder="Full Name">
						</div>
					</div>

					<div class="form-group">
						<label class="col-md-4 col-md-offset-1">Roll No:</label>
						<div class="col-md-5">
							<input type="text" class="form-control input-sm" name="regusername" placeholder="Roll no">
						</div>
					</div>

					<div class="form-group">
						<label class="col-md-4 col-md-offset-1">Email:</label>
						<div class="col-md-5">
							<input type="email" name="regemail" placeholder="example@exp.com" class="form-control input-sm">
						</div>
					</div>

					<div class="form-group">
						<label class="col-md-4 col-md-offset-1">Password:</label>
						<div class="col-md-5">
							<input type="password" name="regpwd1" placeholder="password" class="form-control input-sm">
						</div>
					</div>

					<div class="form-group">
						<label class="col-md-4 col-md-offset-1">Confirm Password:</label>
						<div class="col-md-5">
							<input type="password" name="regpwd2" placeholder="repeat password" class="form-control input-sm">
						</div>
					</div>

					<div class="form-group">
						<div class="col-md-2 col-md-offset-8">
							<input type="submit" class="btn btn-success" name="registerform" value="Sign Up">
						</div>
					</div>
				</form>
			</div>
			<div class="modal-footer"></div>
		</div>

		
	</div>
</div>

<!-- PopUp Login Form -->
 <div class="modal fade" id="loginForm">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label=""><span>&times;</span>
				</button>
				<h4 class="modal-title">Log In</h4>
			</div>
			<div class="modal-body">
				<form class="form-horizontal" action="login.php" method="post">
					<div class="form-group">
						<label class="col-md-4 col-md-offset-1">User:</label>
						<div class="col-md-5">
							<input type="text" class="form-control input-sm" name="username" placeholder="Roll No" autofocus/>
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-4 col-md-offset-1">Password:</label>
						<div class="col-md-5">
							<input type="password" class="form-control input-sm" name="password" placeholder="password" autofocus/>
						</div>
					</div>
					<div class="form-group">
						<div class="col-md-2 col-md-offset-8">
							<input type="submit" class="btn btn-success" name="loginform" value="Log In">
						</div>
					</div>
				</form>
			</div>
			<div class="modal-footer"></div>
		</div>
		
	</div>
</div>
<!-- javascript files    -->
	<script src="js/jquery.min.js"></script>
<!-- Latest compiled and minified JavaScript -->
	<script src="js/bootstrap.min.js">
	</script>
	<script type="text/javascript">
			function messages(a){
				 if(a == 1)
				 	alert("Registration successful");
			}

		</script>
</body>
</html>