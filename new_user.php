<?php require_once("includes/session.php"); ?>
<?php require_once("includes/connection.php"); ?>
<?php require_once("includes/functions.php"); ?>
<?php confirm_logged_in(); ?>
<?php include_once("includes/form_functions.php"); ?>
<?php
if(isset($_POST['submit']))
{	$errors=array();
		$required_fields=array('username','password');
		foreach($required_fields as $fieldname)
		{
			if(!isset($_POST[$fieldname]) || empty($_POST[$fieldname]))
			{	
				$errors[]=$fieldname;
			}
		}
			$fields_with_length=array('username'=>50,'password'=>40);
					foreach($fields_with_length as $fieldname=>$max_length)
					{
						if(strlen(trim(mysql_prep($_POST[$fieldname])))>$max_length)
						{$errors[]=$fieldname;}
					}
	
		$username=trim(mysql_prep($_POST['username']));
		$password=trim(mysql_prep($_POST['password']));
		$hashed_password=sha1($password);
										
	if(empty($errors))
				{
					$query="INSERT INTO users(username,hashed_password) 
							VALUES(
							'{$username}','{$hashed_password}')
							";
					$result=mysqli_query($connection,$query);
					if($result)
					{
						$message="The user was successfully created.";
					}
					else{
						$message="The user could not be created.";
						$message.=mysql_error();
					}
				}
	else		{
					$message=count($errors)." found";
					//redirect_to("new_user.php?failed=0");
					//exit;
				}
}
	if(isset($_POST['submit']))
	{}
	else{
		$username="";
		$password="";
	}
?>
<?php include("includes/header.php"); ?>
<table id="structure">
	<tr>
		<td id="navigation">
		<a href="staff.php">Return to Menu</a>
<td id="page">
		<h2>Create New User</h2>
		<?php if(!empty($message))
			{echo "<p class=\"message\">".$message."</p>";}
		?>
		<?php if(!empty($errors))
			{ display_errors($errors);}
		?>
			<form action="new_user.php" method="post">
		<table>
		<tr>
		<td>Username:</td>
		<td><input type="text" name="username" maxlength="50" value="<?php echo htmlentities($username); ?>"></td>
		</tr><tr>
		<td>Password:</td>
		<td><input type="password" name="password" maxlength="40" value="<?php echo htmlentities($password); ?>"></td>
		</tr><tr>
		<td colspan="2"><input type="submit" name="submit" value="Create User"></td>
		</tr>
		</table>
		</form>
		</td>
		</tr>
		</table>
<?php include("includes/footer.php"); ?>