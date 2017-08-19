<?php require_once("includes/session.php"); ?>
<?php require_once("includes/connection.php"); ?>
<?php require_once("includes/functions.php"); ?>
<?php confirm_logged_in(); ?>
<?php
	$errors=array();
		$required_fields=array('username','hashed_password');
		foreach($required_fields as $fieldname)
		{
			if(!isset($_POST[$fieldname]) || empty($_POST[$fieldname]))
			{	
				$errors[]='$fieldname';
			}
		}
			$fields_with_length=array('username'=>50,'hashed_password'=>40);
					foreach($fields_with_length as $fieldname=>$max_length)
					{
						if(strlen(trim(mysql_prep($_POST[$fieldname])))>$max_length)
						{$errors[]=$fieldname;}
					}
	if(!empty($errors))
	{
		redirect_to("new_user.php");
		exit;
	}
	
	if(empty($errors))
				{
					$username=mysql_prep($_POST['username']);
					$hashed_password=mysql_prep($_POST['hashed_password']);
									
					$query="INSERT INTO users(username,hashed_password)
							VALUES(
							'{$username}','{$hashed_password}')
							";
					mysqli_query($connection,$query);
					if(mysqli_query($connection,$query))
					{
					header("Location: staff.php");
					exit;
					//Success!
					}
				}
?>
<?php mysqli_close($connection); ?>