<?php require_once("includes/connection.php"); ?>
<?php require_once("includes/functions.php"); ?>
<?php include("includes/header.php"); ?>
<?php find_selected_page(); ?>
<table id="structure">
	<tr>
		<td id="navigation">
		<?php echo public_navigation($sel_subject,$sel_page); ?>
		</td>
		<td id="page">
			<?php if($sel_page)
			{?>
				 <h2><?php echo htmlentities($sel_page['menu_name']); ?></h2>
				 <div class="page-content">
				<br><?php echo strip_tags(nl2br($sel_page['content']),"<br><b><p>"); ?>
			</div>
			<?php
			}
			elseif($sel_subject)
			{
				get_default_page($sel_subject['id']);
			}
			else
			{
				echo "<h2>Welcome to Widget Corp</h2>";
			}
			?>
		</td>
	</tr>
</table>
<?php require_once("includes/footer.php") ?>