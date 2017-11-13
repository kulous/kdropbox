<?php
$final_destination = getcwd()."/d";

if(!is_dir($final_destination)){
  mkdir(getcwd()."/d");
}


if (isset($_FILES['myFile'])) {
        $hash = $_REQUEST['hash'];
        if(!is_dir($final_destination."/".$hash)){
                mkdir($final_destination."/".$hash);
        }
        $fileName = $_FILES['myFile']['name'];
        if (!file_exists($final_destination."/".$hash."/".$fileName)) {
                $ok = move_uploaded_file($_FILES['myFile']['tmp_name'], $final_destination."/".$hash."/" . $_FILES['myFile']['name']);
                echo $ok ? "$fileName uploaded to <a href='http://".$_SERVER['SERVER_NAME']."/d/$hash/$fileName'>$hash/$fileName</a>" : "Uploading of $fileName failed";
        }
        else{
                echo "A file with the name '$fileName' already exists.";
        }
        exit;
}
?>
