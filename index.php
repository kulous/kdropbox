<?php
function encode($number) {
	return strtr(rtrim(base64_encode(pack('i', $number)), '='), '+/', '-_');
}
$hash = encode(date("U"));
/* Edit the path below to ensure your final destination is correct */
$final_destination = getcwd()."/d";

/* make sure a folder exists */
if(!is_dir($final_destination)){
  mkdir(getcwd()."/d");	
}

$max_upload = (int)(ini_get('upload_max_filesize'));
$max_post = (int)(ini_get('post_max_size'));
$memory_limit = (int)(ini_get('memory_limit'));
$upload_mb = min($max_upload, $max_post, $memory_limit);
if (isset($_FILES['myFile'])) {
	$hash = $_REQUEST['hash'];
	if(!is_dir($final_destination."/".$hash)){
		mkdir($final_destination."/".$hash);
	}
	$fileName = $_FILES['myFile']['name'];
	if (!file_exists($final_destination."/".$hash."/".$fileName)) {
		$ok = move_uploaded_file($_FILES['myFile']['tmp_name'], $final_destination."/".$hash."/" . $_FILES['myFile']['name']);
		echo $ok ? "$fileName uploaded to <a href='/d/$hash/$fileName'>$hash/$fileName</a>" : "Uploading of $fileName failed";
	}
	else{
		echo "A file with the name '$fileName' already exists.";
	}
	exit;
}
?><!DOCTYPE html>
<html>
<head>
    <title>DropBox</title>
	<link rel='stylesheet' type='text/css' href='style.css'/>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <script type="text/javascript">
	var uc = 0;
	var content = "";
        function sendFile(file) {
		console.log(file);
		var ul = document.getElementById('status');
		uc += 1;
		var d = 'upload'+uc;
		var li = document.createElement("li");
		ul.appendChild(li);
		li.textContent = 'Uploading ' + file.name;
		var uri = "index.php?hash=<?php echo $hash;?>";
		var xhr = new XMLHttpRequest();
		var fd = new FormData();
             
            xhr.open("POST", uri, true);
            xhr.onreadystatechange = function() {
		if (xhr.readyState==4 && xhr.status==200){
			content += xhr.responseText + "\n";
		}
		li.innerHTML = xhr.responseText;
            };
            fd.append('myFile', file);
            fd.append('fileName', file.name);
            // Initiate a multipart/form-data upload
            xhr.send(fd);
        }
 
        window.onload = function() {
            var dropzone = document.getElementById("dropzone");
            dropzone.ondragover = dropzone.ondragenter = function(event) {
                event.stopPropagation();
                event.preventDefault();
            }
     
            dropzone.ondrop = function(event) {
                event.stopPropagation();
                event.preventDefault();
 
                var filesArray = event.dataTransfer.files;
                for (var i=0; i<filesArray.length; i++) {
                    sendFile(filesArray[i]);
                }
            }
        }
	function sendmail(){
		var form = document.getElementById('mailme');
		var uri = form.getAttribute("action");
		var xhr = new XMLHttpRequest();
		var fd = new FormData();
		var ul = document.getElementById('status');
		li = ul.children;
		if (li.length < 1) {
			alert("There are no links to email.");
		}
		else{
			if(document.getElementsByTagName('input')[0].value != ''){
				fd.append('email',document.getElementsByTagName('input')[0].value);
				fd.append('content',content);
				xhr.open("POST", uri, true);
				xhr.onreadystatechange = function() {
					if (xhr.readyState==4 && xhr.status==200){
						alert(xhr.responseText);
					}
				};
				xhr.send(fd);
			}
			else{
				alert("Please enter an email address");
			}
		}
	}
    </script>
</head>
<body>
    <div>
	<?php echo "
	<p>This page allows you to quickly upload files for local or remote use. You can drag and drop multiple files, with an upload limit of $upload_mb mb per file. All files are publicly available to anyone with the link. </p>
";?>
        <div id="dropzone">Drag & drop your file(s) here</div>
	<ul id='status'></ul>
	<form id='mailme' action="sendmail.php?hash=<?php echo $hash;?>" method='post'>
	You can have the links above emailed to you for future use.<br/>
	Email: <input type='text' name='email'><br/>
	<button type='button' onClick="sendmail()">Send Message</button>
	</form>
    </div>
</body>
</html>
