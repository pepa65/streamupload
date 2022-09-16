<?php // Encode page
session_start();
require "check.php";
if(!isset($_POST['schedule'])){ // If not post: start again
	header('Location: index.php');
}

function Back($msg){
	print('<p>'.$msg.'</p>
<form action="index.php" method="post">
<input type="submit" value="Upload another file" name="submit" autofocus>
</form></div>');
	exit;
}

// Get mails
$mh=file(__DIR__.'/../mailhash',FILE_IGNORE_NEW_LINES & FILE_SKIP_EMPTY_LINES);
foreach($mh as $line){
	if(substr($line, 0, 1)!='#'){
		$field=explode("\t", $line);
		$mails[$field[0]]=$field[1];
	}
}
$upload=htmlspecialchars(basename($_FILES['file']['name']));
$key=$_POST['streamkey'];
$datetime=$_POST['datetime'];
$email=$_POST['email'];
$user=$_SESSION['user'];
if($email){
	$to=$email;
	$email=':'.$email;
}else{
	$to=$mails[$user];
}
$date=substr($datetime, 0, 10);
$hour=substr($datetime, 11, 2);
$min=substr($datetime, 14, 2);
$time=$hour.$min;
$target=$_POST['target'];
$dir='streams/';
$name=$key.'.'.$date.'_'.$time.'_'.$user.$email.'@'.$target;
$file=$dir.$name.'.upload';
print('<!DOCTYPE html>
<meta charset="utf-8">
<title>Stream Upload encoding</title>
<link rel="icon" href="favicon.png">
<link rel="stylesheet" href="page.css">
<div class="user"><p class="user">User:&nbsp;<b>'.$user.'</b></p>
	<form action="check.php" method="post">
		<input id="logoff" type="submit" name="logoff" value="Logoff">
	</form></div><div class="container">
<h1>Encoding</h1>
<p>Uploaded <b>'.$upload.'</b></p>');
if(preg_match('/20[0-9][0-9]-[0-1][0-9]-[0-3][0-9]T[0-2][0-9]:[0-6][0-9]/', $datetime)===false){
	Back('Date/time somehow incorrect: '.$datetime);
}
$now=date('Y-m-dHi');
if(strcmp($now, $date.$time)>0){
	Back('Scheduling '.$now.' in the past: '.$date.' '.$time);
}
$nextyear=date('Y-m-dHi', strtotime('+1 year'));
if(strcmp($nextyear, $date.$time)<0){
	Back('Scheduling too far into the future: '.$date.' '.$time);
}
if($_FILES['file']['error']!=UPLOAD_ERR_OK){
	Back('Error uploading the file');
}
if(!move_uploaded_file($_FILES['file']['tmp_name'], $file)){
	Back('Error moving the file');
}

print('<p>Streaming <b>'.$name.'.mp4</b></p>');
print('<p>When done encoding, email <b>'.$to.'</b></p>');
Back('Streaming on <b>'.$date.'</b> at <b>'.$hour.':'.$min.'</b>h on <b>'.$target.'</b>');
?>
