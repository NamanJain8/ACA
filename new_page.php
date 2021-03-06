<?php require_once("includes/session.php"); ?>
<?php require_once("includes/connection.php"); ?>
<?php require_once("includes/functions.php"); ?>
<?php confirm_logged_in(); ?>
<?php include("includes/header.php"); ?>
<?php find_selected_page(); ?>
	<table id="structure">
		<tr>
			<td id="navigation">
			<?php echo navigation($sel_subject,$sel_page); ?>
			</td>
			<td id="page">
				<h2>Add Page</h2>
				<form action="create_page.php?subj=<?php echo urlencode($sel_subject['id']); ?>" method="post">
					<p>Page Name:
						<input type="text" value="" id="menu_name" name="menu_name">
					</p>
					<p>Position:
						<select name="position">
						<?php
							$page_set=get_pages_for_subject($_GET['subj']);
							$page_count=mysqli_num_rows($page_set);
							for($count=1;$count<=$page_count+1;$count++)
							{
								echo "<option value=\"{$count}\">{$count}</option>";
							}
							 echo "</select>";
						?>
					</p>
					<p>Visibility:
						<input type="radio" value="0" name="visible">No
						&nbsp;
						<input type="radio" value="1" name="visible">Yes
					</p>
					<p>Content:<br>
						<textarea name="content" cols="100" rows="10"></textarea>
					</p>
					<input type="submit" value="Create Page">
					</form>  
				<br>
				<a href="content.php">Cancel</a>
			</td>
		</tr>
	</table>
<?php require("includes/footer.php"); ?>
