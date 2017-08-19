<?php require_once("includes/session.php"); ?>
<?php require_once("includes/connection.php");?>
<?php require_once("includes/functions.php");?>
<?php confirm_logged_in(); ?>
<?php
	if(intval($_GET['page']==0))
	{
		redirect_to("content.php");
	}
	
	$id=mysql_prep($_GET['page']);
	if($page=get_page_by_id($id)){
			$query="DELETE FROM pages WHERE id={$id} LIMIT 1";
			$result=mysqli_query($connection,$query);
			if(mysqli_affected_rows($connection)==1){
				redirect_to("content.php");
			}
			else{
				//deletion failed
				echo "<p>Subject Deletion Failed</p>";
				echo "<p>".mysqli_error($result)."</p>";
				echo "<a href=\"content.php\">Return to Main Page</a>";
			}
	}
	else{
		redirect_to("content.php");
	}	
?>
<?php mysqli_close($connection);?>