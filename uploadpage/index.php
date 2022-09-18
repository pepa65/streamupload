<?php // Schedule page
require "check.php";
$user=$_SESSION['user'];
if(empty($user)){
	header('Location: login.php');
}

print('<!DOCTYPE html>
<meta charset="utf-8">
<title>Stream Upload scheduling</title>
<link rel="icon" href="favicon.png">
<link rel="stylesheet" href="page.css">
<script>
function respond(){
	const feedback = document.getElementById("response");
	feedback.innerHTML = "<b>File is uploading</b>";
}
function filename(){
	var name = document.getElementById("name");
	name.innerHTML = document.getElementById("input").files[0].name;
	name.style.fontWeight = "normal";
}
</script>
<div class="user"><p class="user">User:&nbsp;<b>'.$user.'</b></p>
	<form action="check.php" method="post">
		<input id="logoff" type="submit" name="logoff" value="Logoff">
	</form></div>
<div class="container">
	<div class="incontainer">
		<h1>Stream Upload</h1>
		<form action="upload.php" method="post" enctype="multipart/form-data" onsubmit="respond()">
			<div class="fileinput">
				<input id="input" type="file" name="file" required accept=".mp4" onchange="filename()" autofocus>
				<input class="abs" id="fakeinput" tabindex="-1">
				<p class="abs" id="name">Click to select the video</p>
			</div>');
// Check countdown options
$cf=file(__DIR__.'/../countdown',FILE_IGNORE_NEW_LINES & FILE_SKIP_EMPTY_LINES);
$n=0;
foreach($cf as $line){
	if(substr($line, 0, 1)!='#'){
		$field=explode("\t", $line);
    $id[$n]=htmlspecialchars($field[0]);
		$name[$n++]=htmlspecialchars($field[1]);
  }
}
// Populate Countdown dropdown
if($n>0){
	print('			<select name="id" title="Click to select an optional countdown">');
	print('				<option value="_" selected>No countdown</option>');
	for($i=0; $i<$n; ++$i){
		print('				<option value="'.$id[$i].$name[$i].'">'.$name[$i].'</option>');
	}
	print('			</select>');
}
print('			<select name="target" required title="Click to select where to stream to">
				<option value="" disabled selected hidden>Streaming Destination</option>
				<option value="Restream">Restream</option>
				<option value="Facebook">Facebook</option>
				<option value="YouTube">YouTube</option>
			</select>
			<input type="text" name="streamkey" placeholder="Stream Key" required title="Enter a string of 0-9, a-z, A-Z, underscore or dash characters" pattern="[a-zA-Z0-9_-]+">
			<div class="datetime">
				<input type="date" name="date" title="Enter the date" required>
				<input type="time" name="time" title="Enter the time" required></div>
			<input type="email" name="email" placeholder="Email to notify" title="Not required">
			<input type="submit" value="Schedule Stream" name="schedule">
			<p id="response"></p>
		</form>
	</div>
</div>');
?>
