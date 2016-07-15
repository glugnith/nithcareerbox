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
	  	else
	  	{
	  		$result = mysqli_query($con,"SELECT * FROM user ORDER BY username ASC");

	  		/*if($result->num_rows > 0)
	  		{
	  			while($row = $result->fetch_assoc())
	  			{

	  			}
	  		}*/
	  	}
	  	if(isset($_POST))
	  	{
	  		if (isset($_POST['activate']))//writing here
	  		{
	  			# code...
	  			$rlno = $_POST['rno'];
	  			mysqli_query($con,"UPDATE user SET active=1 WHERE username = $rlno");
	  			header("Location:dashboard.php");
	  		}
	  		else if(isset($_POST['deactivate']))
	  		{
	  			$rlno = $_POST['rno'];
	  			mysqli_query($con,"UPDATE user SET active=0 WHERE username = $rlno");
	  			header("Location:dashboard.php");
	  		}
	  		if(isset($_POST['delete_ac']))
	  		{
	  			$rlno = $_POST['rno'];
	  			mysqli_query($con,"DELETE FROM user WHERE username = $rlno");
	  			header("Location:dashboard.php");
	  		}
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
	  <li role="presentation" onclick="downloadcv()"><a href="#">Download</a></li>
	  <li role="presentation"><a href="logout.php">Log Out</a></li>
</ul>
<h1 style="text-align:center;">Welcome Admin</h1>
	<p id="demo" style="color:red; width:100%; background:yellow; min-height: 50px; text-align:center; padding-top:5px; padding-bottom:5px;">Good day!</p>

	
	<div style="width:60%; margin: auto; border: 3px solid #73AD21; padding: 10px;; " >

			<table class="table table-hover" style="text-align:center;">
		        <tr>
			        <th style="text-align:center;">Select All<br/>

			        	<input type="checkbox" class="selectAll" id="selectAll" onclick="checkUncheck()" >


			        </th>
			        <th style="text-align:center;">Roll NO.</th>
			        <th style="text-align:center;">Name</th>
			        <th style="text-align:center;">Status</th>
			        <th style="text-align:center;">CV</th>
			        <th style="text-align:center;">Last Updated</th>
			        <th style="text-align:center;">Action</th>
			        <!-- <td><h1>Action</h1></td> -->
      			</tr>
      		
		    <?php
		    	$i=0;

		      	while($out=mysqli_fetch_array($result)) 
		      	{
					        $i++;
					        $rollno =$out['username'];
					        $name = $out['name'];
					        $status = $out['active'];
					        $cv_path =$out['cv'];
					        $time = $out['timestamp'];
					        

					       	
			?>
					        <tr>
						        <td><input type="checkbox" class="select" value="<?php echo "$rollno";?>" ></td>
						        <td><?php echo $rollno;?></td>
						        <td><?php echo $name;?></td>
						        <td><?php
						        		 if(!$status)
						        		 {?>
						        		 	
						        		 	<form action="dashboard.php" method="post">
						        		 		<input type="hidden" name="rno" value="<?php echo "$rollno";?>">
						        		 		<input type="submit" value="Inactive" name = "activate" style="color:red;"></input>
						        		 	</form>
						        		 <?php
						        		 }
						        		 else
						        		 {?>
						        		 	<form action="dashboard.php" method="post">
						        		 		<input type="hidden" name="rno" value="<?php echo "$rollno";?>">
						        		 		<input type="submit" value="Active" name = "deactivate" style="color:green;"></input>
						        		 	</form>
						        		 <?php
						        		 }
						        		 ;?>
						        			
						        </td>
					        	<td>
					        		<?php
						        		if($out['cv']== null)
								        {
								        	
								        	echo "N A";
								        }
								        else
								        {
								        	echo "<a href='$cv_path'>Download Cv</a>";
								        }
							       	?>
							    </td>
							    <td>
							    	<?php echo $time; ?>
							    </td>
							    <td>
							    	
							    	<form action="dashboard.php" method="post">
						        		 		<input type="hidden" name="rno" value="<?php echo "$rollno";?>">
						        		 		<input type="submit" value="Delete" name = "delete_ac" style="color:red;"></input>
						        		 	</form>
							    </td>
					        </tr>
					     <?php

		      	}
		    ?>
		      </table>
		</div>
		

</body>
<script>
	function checkUncheck()//selects or unselect all the rows in table...
	{
		if(document.getElementById("selectAll").checked)//this section runs if select all checkbox is selected..
		{
			var rows = document.getElementsByClassName("select");
			var len = rows.length;
			for(var i = 0; i < len ; i++ )
			{
				rows[i].checked = true;
			}
		}
		else if(!document.getElementById("selectAll").checked)//this section runs if select all checkbox is unselected..
		{
			var rows = document.getElementsByClassName("select");
			var len = rows.length;
			for(var i = 0; i < len ; i++ )
			{
				rows[i].checked = false;
			}

		}
	}
	/*function singleUnchecked()//this function is used to uncheck the select all checkbox if any of the checkbox is unchecked..
	{
		if(document.getElementsByClassName().checked)
		{
			alert("hello");
		}
	}*/
	function downloadcv()
	{
		document.getElementById("demo").innerHTML = "Downloading ";
		var rows = document.getElementsByClassName("select");
		var len = rows.length;
		var srows = [];
		var count = 0;
		for(var i = 0; i < len ; i++ )
		{
			if(rows[i].checked)
			{
				srows.push(rows[i]);
				count++;
			}
		}
		for(var i = 0; i < count ; i++ )
		{
			document.getElementById("demo").innerHTML += srows[i].value+" ";
		}
	}

</script>
</html>

