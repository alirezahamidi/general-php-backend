<?php

header("Access-Control-Allow-Origin: *");
ini_set('memory_limit','256M'); // this is optional.
ini_set('post_max_size','64M');
ini_set('upload_max_filesize','64M');
header('Access-Control-Allow-Headers: client-token,request-type');
// include '../config.php';


$target_dir = "./";
$target_file = $target_dir . basename($_FILES["file"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));


$allowed_types = array ( 'image/jpeg', 'image/png' );
$fileInfo = finfo_open(FILEINFO_MIME_TYPE);
$detected_type = finfo_file( $fileInfo, $_FILES['file']['tmp_name'] );
if ( !in_array($detected_type, $allowed_types) ) {
    die ( 'invalid-type' );
    return;
}
finfo_close( $fileInfo );

if(isset($_POST["submit"])) {
    $check = getimagesize($_FILES["file"]["tmp_name"]);
    if($check !== false) {
        // echo "File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;
    } else {
        echo "error";
        $uploadOk = 0;
        return;
    }
}

if (file_exists($target_file)) {
    echo "exists";
    $uploadOk = 0;
    return;
}

if ($_FILES["file"]["size"] > 2000000) {
    echo "larg";
    $uploadOk = 0;
    return;
}

if ($uploadOk == 0) {
    echo "error";
} else {
    if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
        echo "success";
        $path_info = pathinfo($target_file);
        if($path_info['extension']=="jpg"|| $path_info['extension']=="png"){
            make_thumb($target_file,$target_file."_thumb".".jpg","120");
        }

    } else {
        echo "error";//, there was an error uploading your file.";
    }
}

function make_thumb($src, $dest, $desired_width) {
    $source_image = imagecreatefromjpeg($src);
    $width = imagesx($source_image);
    $height = imagesy($source_image);
    $desired_height = floor($height * ($desired_width / $width));
    $virtual_image = imagecreatetruecolor($desired_width, $desired_height);
    imagecopyresampled($virtual_image, $source_image, 0, 0, 0, 0, $desired_width, $desired_height, $width, $height);
    imagejpeg($virtual_image, $dest);
}

return;
?>
