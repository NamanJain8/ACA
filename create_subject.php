<?php require_once("includes/session.php"); ?>
<?php require_once("includes/connection.php"); ?>
<?php require_once("includes/functions.php"); ?>
<?php confirm_logged_in(); ?>
<?php 
	$errors=array();
	//For validation
	$required_fields=array('menu_name','position','visible');
	foreach($required_fields as $fieldname)
	{
		if(!isset($_POST[$fieldname])||empty([$fieldname]))
		{
			$errors[]='{$fieldname}';
		}
	}
	
	$fields_with_length=array('menu_name'=>30);
	foreach($fields_with_length as $fieldname=>$max_length)
	{
		if(strlen(trim(mysql_prep($_POST[$fieldname])))>$max_length)
		{$errors=$fieldname;}
	}
	if(!empty($errors))
	{
		redirect_to("new_subject.php");
	}		
?>
<?php
	$menu_name=mysql_prep($_POST['menu_name']);
	$position=mysql_prep($_POST['position']);
	$visible=mysql_prep($_POST['visible']);
?>
<?php 
	$query="INSERT into subjects(
			menu_name, position,visible
			) VALUES (
			'{$menu_name}',{$position},{$visible}
			)";
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
				echo mysql_error();
			}
			
			
?>
<?php mysqli_close($connection); ?>