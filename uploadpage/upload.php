<?php
error_reporting(E_ALL);
set_time_limit(0);
//ob_implicit_flush(true);
//ob_end_flush();
if($_SERVER['REQUEST_METHOD']!=='POST'){
	header('Location: /');
}

function back($msg){
	print($msg);
	print('<br><br>
<form action="/" method="post">
<input type="submit" value="Upload another file" name="submit">
</form>');
	exit;
}

header('Content-type: text/html; charset=utf-8');
$upload=htmlspecialchars(basename($_FILES['fileToUpload']['name']));
$key=$_POST['streamkey'];
$date=$_POST['date'];
$time=$_POST['time'];
$dir='uploads/';
$name=$key.'.'.$date.'_'.$time;
$file=$dir.$name;
print('<!DOCTYPE html>
<meta charset="utf-8">
<title>Uploading</title>
<h3>Uploading</h3>
File: '.$upload.'<br>');
ob_flush();
flush();
$now=date('Y-m-dH:i');
if(strcmp($now, $date.$time)>0){
	back('Scheduling '.$now.' in the past: '.$date.' '.$time);
}
$nextyear=date('Y-m-dH:i', strtotime('+1 year'));
if(strcmp($nextyear, $date.$time)<0){
	back('Scheduling too far into the future: '.$date.' '.$time);
}
if($_FILES['fileToUpload']['error']!=UPLOAD_ERR_OK){
	back('Error uploading the file');
}
if(!move_uploaded_file($_FILES['fileToUpload']['tmp_name'], $file)){
	back('Error moving the file');
}

$res=exec('../prep '.$name, $output, $ret);
if($ret==1){
	back('Not a video file, but of type: '.$res);
}
if($ret==2){
	back('Error with the encoding');
}

print('File uploaded as "'.$name.'"<br>
Scheduled for '.$date.' at '.$time);
?>
