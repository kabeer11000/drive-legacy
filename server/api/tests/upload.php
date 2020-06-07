<script>
function UploadFile(data, folderid)
{
	// Define a boundary, I stole this from IE but you can use any string AFAIK
	var boundary = "---------------------------7da24f2e50046";
	var xhr = new XMLHttpRequest();
	var body = '--' + boundary + '\r\n'
		// Parameter name is "file" and local filename is "temp.txt"
		+
		'Content-Disposition: form-data; name="file[]";' +
		'filename="temp.txt"\r\n'
		// Add the file's mime-type
		//Can be changed to upload file in other formats
		+
		'Content-type: plain/text\r\n\r\n' +
		data + '\r\n' +
		boundary + '--';

	xhr.open("POST", "http://drive.hosted-kabeersnetwork.unaux.com/server/api/upload/?id=" + folderid, true);
	xhr.setRequestHeader(
		"Content-type", "multipart/form-data; boundary=" + boundary

	);
	xhr.onreadystatechange = function ()
	{
		if (xhr.readyState == 4 && xhr.status == 200)
			alert("File uploaded!");
	};
	xhr.send(body);
}
var userid = '5e996300e70bb';
var text = 'Hello World';
//UserID is same as users "My Drive (Root)" folder Id
UploadFile(text, userid);
</script>