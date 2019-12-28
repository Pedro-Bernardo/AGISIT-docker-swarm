<?php
    include("php_file_tree.php");
?>
<!DOCTYPE html>
<html>
<head>
    <link href="styles/default/default.css" rel="stylesheet" type="text/css" media="screen" />
</head>
<body>

<form action="upload.php" method="post" enctype="multipart/form-data">
    Select image to upload:
    <input type="file" name="fileToUpload" id="fileToUpload">
    <br><br>
    <input type="submit" value="Upload File" name="submit">
</form>

<?php
    echo "Node:" . $_ENV["HOST_NAME"];

    echo php_file_tree($_ENV["UPLOAD_DIR"], "");
?>

</body>
</html>