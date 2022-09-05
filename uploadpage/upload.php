<?php
error_reporting(E_ALL);
$headers=getallheaders();
$authuser=$headers['X-User'];
if($_SERVER['REQUEST_METHOD']!=='POST'){
	header('Location: /');
}

function Back($msg){
	print('<p>'.$msg.'</p>
<form action="/" method="post">
<input type="submit" value="Upload another file" name="submit">
</form></div>');
	exit;
}

header('Content-type: text/html; charset=utf-8');
$upload=htmlspecialchars(basename($_FILES['file']['name']));
$key=$_POST['streamkey'];
$datetime=$_POST['datetime'];
$email=$_POST['email'];
if($email){
	$email='_'.$email;
} else {
	$email='_'.$authuser;
}
$date=substr($datetime, 0, 10);
$hour=substr($datetime, 11, 2);
$min=substr($datetime, 14, 2);
$time=$hour.$min;
$target=$_POST['target'];
$dir='streams/';
$name=$key.'.'.$date.'_'.$time.$email.'@'.$target;
$file=$dir.$name.'.upload';
print('<!DOCTYPE html>
<meta charset="utf-8">
<title>Encoding</title>
<link rel="icon" href="favicon.png">
<link rel="stylesheet" href="page.css">
<div class="container">
<h1>Encoding</h1>
'.($authuser==='' ? '' : '<p>For: <b>'.$authuser.'</b></p>').'
<p>File: <b>'.$upload.'</b></p>');
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

print('<p>File is now being encoded to <b>'.$name.'.mp4</b></p>');
if($email){
	print('<p>When done, an email will be sent to <b>'.substr($email,1).'</b></p>');
}
Back('Scheduling for <b>'.$date.'</b> at <b>'.$hour.':'.$min.'</b>h on <b>'.$target.'</b>');
?>
