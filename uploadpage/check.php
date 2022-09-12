<?php // INCLUDE: Redirect to login.php if not authorized
session_start();
if(isset($_POST['logoff'])){ // Logout attempt: logout
	unset($_SESSION['user']);
}
if(!isset($_SESSION['user'])){ // Not logged in: login
	header('Location: login.php');
}
?>
