<?php require_once("includes/session.php"); ?>
<?php require_once("includes/connection.php"); ?>
<?php require_once("includes/functions.php"); ?>
<?php
	if(logged_in())
	{
		redirect_to("staff.php");
	}
	if(isset($_POST['submit']))
	{
		$username=trim(mysql_prep($_POST['username']));
		$password=trim(mysql_prep($_POST['password']));
		$hashed_password=sha1($password);
		
		$query="SELECT * FROM users
				WHERE username='{$username}'
				 AND hashed_password='{$hashed_password}'
				LIMIT 1";
		$result=mysqli_query($connection,$query);
		confirm_query($result);
		if($result)
		{
			$found_user=mysqli_fetch_array($result);
			$_SESSION['user_id']=$found_user['id'];
			$_SESSION['username']=$found_user['username'];
			redirect_to("staff.php");
		}
		else
		{$message="Invalid credentials";
		 $message .=mysql_error();	}
	}
		if(isset($_GET['logout']) && $_GET['logout']==1)
		{
			$message="Successfully logged out";
		}
?>
<?php include("includes/header.php"); ?>
<table id="structure">
	<tr>
		<td id="navigation">
		<a href="index.php">Return to Public Section</a>
<td id="page">
		<h2>Login</h2>
		<?php if(!empty($message))
			{echo "<p class=\"message\">".$message."</p>";}
		?>
		<form action="login.php" method="post">
		<table>
		<tr>
		<td>Username:</td>
		<td><input type="text" name="username" maxlength="50"></td>
		</tr><tr>
		<td>Password:</td>
		<td><input type="password" name="password" maxlength="40"></td>
		</tr><tr>
		<td colspan="2"><input type="submit" name="submit" value="Login"></td>
		</tr>
		</table>
		</form>
		</td>
		</tr>
		</table>
<?php include("includes/footer.php"); ?>