<?php
header('Content-Type: application/json');

//Define source directory (Uploaded file)
$src_dir = getcwd()."/uploaded_file/";
//Define destination directory
$dest_dir = getcwd()."/converted_file/";

//File name including path
$file = basename($_FILES["fileToUpload"]["name"]);
$file_path = $src_dir.$file;
//Declare uploaded file path
$file_dest_path = "converted_file/";
$file_name = $_FILES['fileToUpload']['name'];

//Get file name without extension
//To write in log.txt file
$file = explode('.',$_FILES["fileToUpload"]["name"]);
$file_name = $file[0];
$file_exten = $file[1];

//Extension check flag
$extenOk = 1;
//Size check flag
$sizeOk = 1;
//Upload check flag
$uploadOk = 1;
//Upload success flag
$uploadSuccess = 1;

//Function to check if directory's empty
function isEmptyDir($dir) {
    $element = scandir($dir);
    if (count($element) == 0) {
        return true;
    }
    else {
        return false;
    }
}

//Function to delete all file in the directory
function deleteAll($dir){
    $files = glob($dir . '/*');

    foreach ($files as $file) {
        if (is_file($file))
            unlink($file);
    }
}


// Allow certain file formats
if($file_exten != "pdf") {
    $uploadOk = 0; $extenOk = 0;}
else{
    if ($_FILES["fileToUpload"]["size"] > 5000000) {
        $uploadOk = 0; $sizeOk = 0;}
}

// Check if upload check flag is set to 0 by an error
if (!$uploadOk) {
    if (!$extenOk) {echo "1";}
    else if (!$sizeOk) {echo "2";}
    
// if everything is ok, try to upload file
} else {
    //We only one instance of the file in upload and convert dir
    //So check for both dir
    //If not empty, delete all
    if (!isEmptyDir($src_dir)){
        deleteAll($src_dir);
    }
    if (!isEmptyDir($dest_dir)){
        deleteAll($dest_dir);
    }

        //Move file from temp to source directory
        move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $file_path);
        //Write uploaded file name in log.txt
        $log = fopen(getcwd()."/log.txt", "w");
        fwrite($log, $file_name);

        //Exec java in shell
        $command = "java -jar out/artifacts/JavaFile/JavaPdfTxt.jar ";
        echo shell_exec($command);

        //Download file path
        $file_dest_path = $file_dest_path.$file_name."_Converted.txt";
        echo $file_dest_path;
}
?>
