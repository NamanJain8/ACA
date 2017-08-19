<?php require_once("includes/session.php"); ?>
<?php require_once("includes/connection.php"); ?>
<?php require_once("includes/functions.php"); ?>
<?php confirm_logged_in(); ?>
<?php include("includes/header.php"); ?>
<?php 
	if(intval($_GET['subj'])==0)
	{
		redirect_to("content.php");
	}
	if(isset($_POST['submit']))
	{
		$errors=array();
					$required_fields=array("menu_name","position","visible");
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
					$id=mysql_prep($_GET['subj']);
					$menu_name=mysql_prep($_POST['menu_name']);
					$position=mysql_prep($_POST['position']);
					$visible=mysql_prep($_POST['visible']);
					
					$query="UPDATE subjects SET
							menu_name='{$menu_name}',
							position={$position},
							visible={$visible}
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
						$message="Subject update failed.";
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
				<h2>Edit Subject:<?php echo $sel_subject['menu_name']; ?></h2>
				<?php if(!empty($message))
				{ echo "<p class=\"message\">{$message}</p>"; }
				?>
				<form action="edit_subject.php?subj=<?php echo urlencode($sel_subject['id']); ?>" method="post">
					<p>Subject Name:
						<input type="text" value="<?php echo $sel_subject['menu_name']; ?>" id="menu_name" name="menu_name">
					</p>
					<p>Position:
						<select name="position" value="<?php echo $sel_subject['position']; ?>">
					 	<?php
							$subject_set=get_all_subjects();
							$subject_count=mysqli_num_rows($subject_set);
							for($count=1;$count<=$subject_count;$count++)
							{
								if($sel_subject['position']==$count)
								{ echo "<option value=\"{$count}\" selected>{$count}</option>"; }
								else
								{ echo "<option value=\"{$count}\">{$count}</option>"; }	
							}
							 echo "</select>";
						?>
					</p>
					<p>Visibility:
						<input type="radio" value="2" name="visible" <?php if($sel_subject['visible']==2){ echo " checked"; } ?>>No
						&nbsp;
						<input type="radio" value="1" name="visible" <?php if($sel_subject['visible']==1){ echo " checked"; } ?>>Yes
					</p>
					<input type="submit" name="submit" value="Edit Subject">
					&nbsp; &nbsp;
					<a href="delete_subject.php?subj=<?php echo urlencode($sel_subject['id']);?>" onclick="return confirm('Are you sure?')">Delete Subject</a>
					</form>  
				<br>
				<a href="content.php">Cancel</a>
				<?php if(isset($sel_subject))
					echo "<hr>";
					echo "<h2>Pages in this subject:</h2>";
					echo "<ul>";
					$page_set=get_pages_for_subject($_GET['subj'],false);
					while($page=mysqli_fetch_array($page_set))
					{
						echo "<li><a href=\"content.php?page=";
						echo urlencode($page['id']);
						echo "\">".$page['menu_name']."</a></li>";
					}
					echo "</ul>";
					echo "<a href=\"new_page.php?subj=";
					echo urlencode($sel_subject['id']);
					echo "\">+Add new page to this subject</a>";
					
				?>
			</td>
		</tr>
	</table>
<?php require("includes/footer.php"); ?>
