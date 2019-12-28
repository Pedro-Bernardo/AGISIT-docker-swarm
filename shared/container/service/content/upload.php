<?php
    $target_dir = $_ENV["UPLOAD_DIR"];
    $target_file = basename($_FILES["fileToUpload"]["name"]);
    $uploadOk = 1;

    // Remove anything which isn't a word, whitespace, number
    // or any of the following caracters -_~,;[]().
    $target_file = mb_ereg_replace("([^\w\s\d\-_~,;\[\]\(\).])", '', $target_file);
    // Remove any runs of periods (thanks falstro!)
    $target_file = mb_ereg_replace("([\.]{2,})", '', $target_file);

    // append file name to upload dir
    $target_file = $target_dir . $target_file;


    if(isset($_POST["submit"])) {
        
        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
            // echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
        } else {
            // echo "Sorry, there was an error uploading your file.";
        }

    }
    header('Location: index.php');
?>