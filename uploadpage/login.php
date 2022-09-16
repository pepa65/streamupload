<?php // Login page
session_start();
$user=$_POST['user'];
if(!empty($user)){ // Login attempt
	// Read hash and check password
	$mh=file(__DIR__.'/../mailhash',FILE_IGNORE_NEW_LINES & FILE_SKIP_EMPTY_LINES);
	foreach($mh as $line){
		if(substr($line, 0, 1)!='#'){
			$field=explode("\t", trim($line, "\n"));
			$hashes[$field[0]]=$field[2];
			if($field[0]==$user){
				if(password_verify($_POST['password'], $field[2])){ // Password correct: login
					$_SESSION['user']=$user;
					header('Location: index.php');
					exit;
				}
			}
		}
	}
}

// New login attempt
print('<!DOCTYPE html>
<meta charset="utf-8">
<title>Stream Upload login</title>
<link rel="icon" href="favicon.png">
<link rel="stylesheet" href="page.css">
<div class="container">
	<div class="incontainer">
		<h1>Stream Upload</h1>');
if(isset($_POST['login'])){
	print('
		<h4>Invalid Username or Password</h4>');
}
print('
		<form action="login.php" method="post">
			<input type="text" name="user" placeholder="Username" required title="string of 0-9, a-z, A-Z" pattern="[a-zA-Z0-9]+">
			<input type="password" name="password" placeholder="Password" required>
			<input type="submit" name="login" value="Login" autofocus>
		</form>
	</div>
</div>');
?>
