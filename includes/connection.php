<?php
require("constants.php");
$connection=mysqli_connect(DB_SERVER,DB_USER,DB_PASS);
if(!$connection)
{
	die("Failed to connect: ". mysql_error());
}
?>
<?php
$db_select=mysqli_select_db($connection,DB_NAME);
if(!$db_select)
{
	die("Failed to select: ". mysql_error());
}
?>
