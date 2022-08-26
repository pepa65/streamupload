<!DOCTYPE html>
<meta charset="utf-8">
<title>Stream Upload</title>
<script>
function respond(){
	const feedback = document.getElementById('response');
	feedback.innerHTML = '<b>File is uploading</b>';
}
</script>
<div style="display:flex; justify-content:center; align-items:center; height:95vh;">
	<form action="upload.php" method="post" enctype="multipart/form-data" onsubmit="respond()">
		<table>
			<tr><td colspan=2 align=center><h1>Video Upload Page</h1></td></tr>
		  <tr>
				<td>Streamkey:</td>
				<td><input type="text" name="streamkey" id="streamkey" required title="re_ followed by a string of 0-9, a-f or underscore characters (20 or longer)" pattern="re_[a-f0-9_]{20,}"></td></tr>
	  	<tr>
				<td>Date:</td>
				<td><input type="date" name="date" id="date" required></td></tr>
			<tr>
				<td>Time:</td>
        <td><input type="time" name="time" id="time" required></td></tr>
			<tr>
				<td>Video File:</td>
				<td><input type="file" name="fileToUpload" id="fileToUpload" required accept=".mp4"></td></tr>
			<tr><td><p></td></tr>
		  <tr><td align=center colspan="2"><input type="submit" value="Schedule Stream" name="submit"></td></tr>
			<tr><td><p></td></tr>
		  <tr><td align=center colspan="2" id="response"></td></tr>
		</table>
	</form>
</div>
