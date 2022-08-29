<?php
error_reporting(E_ALL);
//set_time_limit(0);
if($_SERVER['REQUEST_METHOD']!=='POST'){
	header('Location: /');
}

function Back($msg){
	print('<br>&nbsp;<br>'.$msg.'<br>&nbsp;<br>
<form action="/" method="post">
<input type="submit" value="Upload another file" name="submit">
</form></div>');
	exit;
}

header('Content-type: text/html; charset=utf-8');
$upload=htmlspecialchars(basename($_FILES['fileToUpload']['name']));
$key=$_POST['streamkey'];
$date=$_POST['date'];
$hour=substr($_POST['time'], 0, 2);
$min=substr($_POST['time'], 3, 2);
$time=$hour.$min;
$target=$_POST['target'];
$dir='streams/';
$name=$key.'.'.$date.'_'.$time.'@'.$target;
$file=$dir.$name.'.upload';
print('<!DOCTYPE html>
<meta charset="utf-8">
<title>Encoding</title>
<div style="display:flex; flex-direction:column; justify-content:center; text-align:center; align-items:center; height:95vh;">
<h3>Encoding</h3>
File: '.$upload);
$now=date('Y-m-dHi');
if(strcmp($now, $date.$time)>0){
	Back('Scheduling '.$now.' in the past: '.$date.' '.$time);
}
$nextyear=date('Y-m-dHi', strtotime('+1 year'));
if(strcmp($nextyear, $date.$time)<0){
	Back('Scheduling too far into the future: '.$date.' '.$time);
}
if($_FILES['fileToUpload']['error']!=UPLOAD_ERR_OK){
	Back('Error uploading the file');
}
if(!move_uploaded_file($_FILES['fileToUpload']['tmp_name'], $file)){
	Back('Error moving the file');
}

Back('File is now being encoded to "'.$name.'.mp4"<br>&nbsp;<br>
Scheduling for '.$date.' at '.$hour.':'.$min.'h on '.$target);
?>
