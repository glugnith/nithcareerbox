	<?php
		session_start();
		include("config.php");
		
		//dummy username
		$username = $_SESSION['user'];
		if(isset($_FILES['myfile'])){
			$file = $_FILES['myfile'];
			define ('SITE_ROOT', realpath(dirname(__FILE__)));
			//File properties
			$file_name = $file['name'];
			$file_tmp = $file['tmp_name'];
			$file_size =$file['size'];
			$file_error = $file['error'];

			//work out the file extension
			$file_ext = explode('.',$file_name);
			$file_ext = strtolower(end($file_ext));

			$allowed = array('pdf','txt');

			if(in_array($file_ext, $allowed))
			{
				if ($file_error === 0)
				{
					# code...
					$query ="SELECT name FROM user where username = $username";
					$result = mysqli_query($con,$query);
					$data = mysqli_fetch_array($result);
					$student = $data['name'];
					$student = preg_replace('/\s+/', '_', $student);
					if($file_size <= 2097152){
						/*$file_name_new = uniqid("$username"."_",false).'.'.$file_ext;*/
						$file_name_new = "$student"."_"."$username".".".$file_ext;
						$file_destination = 'upload/'.$file_name_new;
						if(move_uploaded_file($file_tmp, $file_destination))
						{
							$success = 1;
							$path_to_cv= SITE_ROOT."/".$file_destination;
							
						}
						else
						{
							$success = 0;
							echo "not uploaded";	
						}
					}
				}
			}
			if($success)
			{
				//$query = "UPDATE user SET cv = "
				//mysqli_query($con,"");
				//these are path from home and path from root respectively.
				//echo "file uploaded to ".$file_destination;
				
				$query ="SELECT cv FROM user where username = $username";
				$result = mysqli_query($con,$query);
				$old_cv = mysqli_fetch_array($result);

				//echo "old cv name ".$old_cv['cv']." ";
				/*if(!empty($old_cv['cv']))*/
				/*if(unlink($old_cv['cv']))
				{

				}*/
				$query = "UPDATE user SET cv = '$file_destination' where username = '$username'";
				mysqli_query($con,$query);
				//echo "path to cv ".$path_to_cv;
				//echo "paht to destination " .$file_destination ;
			}

		}
	?>
<!DOCTYPE html>
<html>
<head>
	<title>View CV</title>
</head>
<body style="margin:0px;">

		<iframe src="<?php echo $file_destination;?>" style="width:100%; height:700px;" frameborder="0"></iframe>
</body>
</html>