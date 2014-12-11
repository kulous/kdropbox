<?php
$email = $_REQUEST['email'];
if($email == ""){
	echo "Please enter an email address";
	exit();
}
$message = $_REQUEST['content'];
$subject = "DropBox Results";
$headers = "FROM: DropBox <dropbox@server.com>";
$headers .= "TO: DropBox User<$email>";
$headers .= "MIME-Version: 1.0\r\n";
$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
$s = mail($email,$subject,$message,$headers);
echo $s ? "Email sent to ".$_REQUEST['email'] : "There was an error sending the message";
?>
