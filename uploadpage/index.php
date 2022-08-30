<!DOCTYPE html>
<meta charset="utf-8">
<title>Stream Upload</title>
<link rel="icon" href="favicon.png">
<link rel="stylesheet" href="style.css">
<script>
function respond(){
	const feedback = document.getElementById('response');
	feedback.innerHTML = '<b>File is uploading</b>';
}
</script>
<div class="container">
	<div class="incontainer">
	<form action="upload.php" method="post" enctype="multipart/form-data" onsubmit="respond()">
		<table>
			<tr><td></td><td align="center"><h1>Stream Upload</h1></td></tr>
			<tr>
				<td>Target:</td>
				<td>
					<select name="target" id="target" required>
						<option value="Restream">Restream</option>
						<option value="Facebook">Facebook</option>
						<option value="YouTube">YouTube</option>
					</select>
				</td></tr>
			<tr>
				<td class="left">Streamkey:</td>
				<td class="right"><input type="text" name="streamkey" id="streamkey" required title="string of 0-9, a-z, A-Z or underscore characters" pattern="[a-zA-Z0-9_]+"></td></tr>
			<tr>
	 	 		<td>Date and Time:</td>
				<td><input type="datetime-local" name="datetime" id="datetime" required></td></tr>
			<tr>
				<td>Video File:</td>
				<td><input type="file" name="fileToUpload" id="fileToUpload" required accept=".mp4"></td></tr>
			<tr><td><br></td></tr>
			<tr><td></td><td><input type="submit" value="Schedule Stream" name="submit"></td></tr>
			<tr><td><br></td></tr>
			<tr><td align=center colspan="2" id="response"></td></tr>
		</table>
	</form>
</div>
</div>
