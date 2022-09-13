<?php // Schedule page
require "check.php";
$user=$_SESSION['user'];
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
</script>
<div class="container">
	<div class="incontainer">
		<h1>Stream Upload</h1>
		<div class="user"><p>User: <b>'.$user.'</b></p>
			<form action="check.php" method="post">
				<input id="logoff" type="submit" name="logoff" value="Logoff">
			</form></div>
		<form action="upload.php" method="post" enctype="multipart/form-data" onsubmit="respond()">
			<select name="target" id="target" required>
				<option value="" disabled selected hidden>Streaming Destination</option>
				<option value="Restream">Restream</option>
				<option value="Facebook">Facebook</option>
				<option value="YouTube">YouTube</option>
			</select>
			<input type="text" name="streamkey" placeholder="Stream Key" required title="string of 0-9, a-z, A-Z, underscore or dash characters" pattern="[a-zA-Z0-9_-]+">
			<input type="datetime-local" name="datetime" title="Click on the date to get a popup" required>
			<input type="file" name="file" required accept=".mp4">
			<input type="email" name="email" placeholder="Email to notify" title="Not required">
			<input type="submit" value="Schedule Stream" name="schedule">
			<p id="response"></p>
		</form>
	</div>
</div>');
?>
