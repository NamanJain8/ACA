<?php
	//1.Find session
	session_start();
	//2.set avriables=0
	$_SESSION=array();
	//3.Clear cookies
	if(isset($_COOKIE[session_name]))
	{
		setcookie(session_name,"",time()-42000);
	}
	//4.stop session
	session_destroy();
	redirect_to("login.php?logout=1");
?>