<?php require_once("includes/session.php"); ?>
<?php require_once("includes/connection.php"); ?>
<?php require_once("includes/functions.php"); ?>
<?php confirm_logged_in(); ?>
<?php 
	$errors=array();
	//For validation
	$required_fields=array('menu_name','position','visible','content');
	foreach($required_fields as $fieldname)
	{
		if(!isset($_POST[$fieldname])||empty($_POST[$fieldname]))
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
		redirect_to("new_page.php");
	}		
?>
<?php
	$menu_name=mysql_prep($_POST['menu_name']);
	$position=mysql_prep($_POST['position']);
	$visible=mysql_prep($_POST['visible']);
	$content=mysql_prep($_POST['content']);
	$subject_id=mysql_prep($_GET['subj']);
?>
<?php 
	$query="INSERT into pages(
			subject_id,menu_name, position,visible,content
			) VALUES (
			{$subject_id},'{$menu_name}',{$position},{$visible},'{$content}'
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
				echo "Page creation failed";
				echo mysql_error();
			}
			
			
?>
<?php mysqli_close($connection); ?>