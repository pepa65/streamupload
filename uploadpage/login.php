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
		<table>
			<tr><td></td><td align="center"><h1>Stream Upload</h1></td></tr>');
if(isset($_POST['login'])){
	print('
			<tr><td></td><td><b>Invalid User or Password</b></td></tr>');
}
print('
			<form action="login.php" method="post">
				<tr>
					<td>User:</td>
					<td><input type="text" name="user" required title="string of 0-9, a-z, A-Z" pattern="[a-zA-Z0-9]+"></td></tr>
				<tr>
					<td class="left">Password:</td>
					<td class="right"><input type="password" name="password" required></td></tr>
				<tr><td></td><td><input type="submit" name="login" value="Login"></td></tr>
			</form>
		</table>
	</div>
</div>');
?>
