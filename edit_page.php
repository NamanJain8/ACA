<?php require_once("includes/session.php"); ?>
<?php require_once("includes/connection.php"); ?>
<?php require_once("includes/functions.php"); ?>
<?php confirm_logged_in(); ?>
<?php include("includes/header.php"); ?>
<?php 
	if(intval($_GET['page'])==0)
	{
		redirect_to("content.php");
	}
	if(isset($_POST['submit']))
	{
		$errors=array();
					$required_fields=array("menu_name","position","visible","content");
					foreach($required_fields as $fieldname)
					{
					if(!isset($_POST[$fieldname]) || (empty($_POST[$fieldname])&&$_POST[$fieldname]==0))
						{
							$errors[]=$fieldname;
						}
					}
				
					$fields_with_length=array('menu_name'=>30);
					foreach($fields_with_length as $fieldname=>$max_length)
					{
						if(strlen(trim(mysql_prep($_POST[$fieldname])))>$max_length)
						{$errors[]=$fieldname;}
					}
	
				if(empty($errors))
				{
					$id=mysql_prep($_GET['page']);
					//$subject_id=
					$menu_name=mysql_prep($_POST['menu_name']);
					$position=mysql_prep($_POST['position']);
					$visible=mysql_prep($_POST['visible']);
					$content=mysql_prep($_POST['content']);
					
					$query="UPDATE pages SET
							menu_name='{$menu_name}',
							position={$position},
							visible={$visible},
							content='{$content}'
							WHERE id={$id}
							";
					mysqli_query($connection,$query);
					if(mysqli_affected_rows($connection)==1)
					{
						//success
						$message="Subject was successfully updated";
					}
					else
					{
						//failure in update
						$message="Page update failed.";
						$message .="<br>".mysql_error();
					}	
				}
				else
				{
					//errors reported
					$message="There were ".count($errors)." errors in the form.";
					$message.="		Please review the following field:{$errors[0]}";
				}
	}
?>
<?php find_selected_page(); ?>
	<table id="structure">
		<tr>
			<td id="navigation">
			<?php echo navigation($sel_subject,$sel_page); ?>
			</td>
			<td id="page">
				<h2>Edit Page:<?php echo $sel_page['menu_name']; ?></h2>
				<?php if(!empty($message))
				{ echo "<p class=\"message\">{$message}</p>"; }
				?>
				<form action="edit_page.php?page=<?php echo urlencode($sel_page['id']); ?>" method="post">
					<p>Page Name:
						<input type="text" value="<?php echo $sel_page['menu_name']; ?>" id="menu_name" name="menu_name">
					</p>
					<p>Page's Subject:
					<select name="subject_name">
							<?php
							$subject_set=get_all_subjects();
							$subject_count=mysqli_num_rows($subject_set);
							foreach($subject_set as $subject)
							{
								$count=1;
								if($subject['id']==$sel_page['subject_id'])
								{ echo "<option value=\"{$count}\" selected>{$subject['menu_name']}</option>"; }
								else
								{ echo "<option value=\"{$count}\">{$subject['menu_name']}</option>"; }
								$count=$count+1;							
							}
							 echo "</select>";
							?>
					</p>
					</p>
					<p>Position:
						<select name="position" value="<?php echo $sel_page['position']; ?>">
					 	<?php
							$page_set=get_pages_for_subject($sel_page['subject_id'],"false");
							$page_count=mysqli_num_rows($page_set);
							for($count=1;$count<=$page_count+1;$count++)
							{
								if($sel_page['position']==$count)
								{ echo "<option value=\"{$count}\" selected>{$count}</option>"; }
								else
								{ echo "<option value=\"{$count}\">{$count}</option>"; }	
							}
							 echo "</select>";
						?>
					</p>
					<p>Visibility:
						<input type="radio" value="2" name="visible" <?php if($sel_page['visible']==2){ echo " checked"; } ?>>No
						&nbsp;
						<input type="radio" value="1" name="visible" <?php if($sel_page['visible']==1){ echo " checked"; } ?>>Yes
					</p>
					<p>Content:
						<textarea cols="100" rows="10" name="content" value="<?php echo $sel_page['content'] ?>"><?php echo $sel_page['content']; ?></textarea>
					</p>
					<input type="submit" name="submit" value="Edit Page">
					&nbsp; &nbsp;
					<a href="delete_page.php?page=<?php echo urlencode($sel_page['id']);?>" onclick="return confirm('Are you sure?')">Delete Page</a>
					</form>  
				<br>
				<a href="content.php">Cancel</a>
			</td>
		</tr>
	</table>
<?php require("includes/footer.php"); ?>
