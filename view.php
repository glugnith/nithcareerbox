<?php
	session_start();
	$username = $_SESSION['user'];
	include("config.php");
	if (!$con)
   	{
     	die('Could not connect: ' . mysqli_error());
      	echo "could not connect";
    }
    else
    {
	    if(isset($_POST['view_cv']))
	    {
			$result = mysqli_query($con,"SELECT cv FROM user WHERE username = $username");
			$cv_path = mysqli_fetch_array($result);
			$vPath = $cv_path['cv'];
			
		}
	}
?>

<!DOCTYPE html>
<html>
<head>
	<title>View CV</title>
</head>
<body style="margin:0px;">

		<iframe src="<?php echo $vPath;?>" style="width:100%; height:700px; padding:0px margin:0px" frameborder="0"></iframe>
</body>
</html>