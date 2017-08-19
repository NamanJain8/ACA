<?php require_once("includes/connection.php"); ?>
<?php require_once("includes/functions.php"); ?>
<?php
	$menu_name=$_POST['menu_name'];
	$position=$_POST['position'];
	$visible=$_POST['visible'];
?>
<?php 
	$query="INSERT into subjects(
			menu_name, position,visible
			) VALUES (
			'{$menu_name}',{$position},{$visible}"
			);
			if(mysqli_query($connection,$query))
			{
				header("Location: content.php");
				exit;
				//Success!
			}
			else
			{
				//Display error msg
				echo "Subject creation failed";
				echo .mysqli_query().;
			}
			
			
?>
<?php mysqli_close($connection); ?>