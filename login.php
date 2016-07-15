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
		//captcha validation
		if(empty($_SESSION['6_letters_code'] ) ||
		strcasecmp($_SESSION['6_letters_code'], $_POST['6_letters_code']) != 0)
		{
		//Note: the captcha code is compared case insensitively.
		//if you want case sensitive match, update the check above to
			$wrongpwd = "The captcha code does not match!";
		}
	   	if(empty($wrongpwd)) {
			// login related check

			//get value
			$username = $_POST['username'];
			$regpwd2 = $_POST['password'];
			$password = md5($regpwd2);
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
				$wrongpwd = "Ask admin to activate your account.";
			else
				$wrongpwd = "Either username or password is wrong.";
   		}
	} 
	//registration form section..................
	if (isset($_POST['registerform']))
	{
		//captcha validation
		if(empty($_SESSION['6_letters_code2'] ) || strcasecmp($_SESSION['6_letters_code2'], $_POST['6_letters_code2']) != 0)
		{
			$errors = "The captcha code does not match!";
		}
	   	if(empty($errors)) {
	   		// registration related check
			$regusername = $_POST['regusername'];
			$regfullname = $_POST['regfullname'];
			$regemail    = $_POST['regemail'];
			$regpwd1     = $_POST['regpwd1'];
			$regpwd2     = $_POST['regpwd2'];

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
				$regpwd1 = md5($regpwd2);
				if(mysqli_query($con,"insert into user(`username`,`name`,`email`,`password`,`cv`,`active`) values($regusername, '$regfullname', '$regemail','$regpwd1', null ,0)"))
				$success = "Registration successful";
				else
					$unmatchedpass = "Roll number already registered contact admin for more info.";
			}
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
<div style="text-align: center; color: green; ">
	<h6 style="font-size: 20px; color: green;"><?php if(isset($_POST['registerform']))if(isset($success)) echo $success; ?></h6>
	<h6 style="font-size: 20px; color: red;"><?php if(isset($_POST['registerform'])) if(isset($unmatchedpass)) echo $unmatchedpass; ?></h6>
	<h6 style="font-size: 20px; color: red;"><?php if(isset($_POST['registerform'])) if(isset($errors)) echo $errors; ?></h6>
	<h6 style="font-size: 20px; color: red;"><?php if(isset($_POST['loginform'])) if(isset($wrongpwd)) echo $wrongpwd; ?></h6>
</div>
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
						
							<div class="col-md-offset-1 center">
								<img src="captcha2.php?rand=<?php echo rand(); ?>" id='captchaimg' >
							</div>
							<label class="col-md-4 col-md-offset-1" for='message'>Enter the code above here :</label><br>
							<div class="col-md-5">
								<input id="6_letters_code2" name="6_letters_code2" type="text" class="form-control input-sm" placeholder="write code here"><small>Can't read the image? click <a href='javascript: refreshCaptcha();'>here</a> to refresh</small>
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
						
							<div class="col-md-offset-1 center">
								<img src="captcha.php?rand=<?php echo rand(); ?>" id='captchaimg2' >
							</div>
							<label class="col-md-4 col-md-offset-1" for='message'>Enter the code above here :</label><br>
							<div class="col-md-5">
								<input id="6_letters_code" name="6_letters_code" type="text" class="form-control input-sm" placeholder="write code here"><small>Can't read the image? click <a href='javascript: refreshCaptcha2();'>here</a> to refresh</small>
							</div>
							
					</div>

					<div class="form-group">
						<div class="col-md-2 col-md-offset-8">
							<input type="submit" class="btn btn-success" name="loginform" value="Log In" >
						</div>
					</div>
				</form>
			</div>
			<div class="modal-footer"></div>
		</div>
		
	</div>
</div>
<!-- refresh captcha code -->
<script>
	function refreshCaptcha()
	{
		var img = document.images['captchaimg'];
		img.src = img.src.substring(0,img.src.lastIndexOf("?"))+"?rand="+Math.random()*1000;
	}
	function refreshCaptcha2()
	{
		var img = document.images['captchaimg2'];
		img.src = img.src.substring(0,img.src.lastIndexOf("?"))+"?rand="+Math.random()*1000;
	}
</script>
<script>

</script>
<!-- javascript files    -->
	<script src="js/jquery.min.js"></script>
<!-- Latest compiled and minified JavaScript -->
	<script src="js/bootstrap.min.js"></script>
</body>
</html>