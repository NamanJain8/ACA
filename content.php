<?php require_once("includes/session.php"); ?>
<?php require_once("includes/connection.php"); ?>
<?php require_once("includes/functions.php"); ?>
<?php confirm_logged_in(); ?>
<?php include("includes/header.php"); ?>
<?php find_selected_page(); ?>
	<table id="structure">
		<tr>
			<td id="navigation">
			<ul class="subjects">
			<?php echo navigation($sel_subject,$sel_page) ?>
			<br><br>
			<a href="new_subject.php">+ Add New Subject</a>
			</td>
			<td id="page">
				<h2><?php if(!is_null($sel_subject)){ echo $sel_subject['menu_name']; }
						  elseif($sel_page){ echo $sel_page['menu_name']; } 
						  else{ echo "Select something";}
					?></h2>
				<div class="content-page"><?php
				if($sel_page)
				{echo $sel_page['content'];
				echo "<br><a href=\"edit_page.php?page=";
				echo urlencode($sel_page['id']);
				echo "\">Edit Page</a>";}
				?></div>
			</td>
		</tr>
	</table>
<?php require("includes/footer.php"); ?>
