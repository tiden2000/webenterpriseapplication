<?php
    include "config.php";

    $currentDirectory = getcwd();

    // Direct uploaded files to their respective folders based on users by changing upload path
    if($_POST['faculty'] == "Coordinator") {$uploadDirectory = "/uploads/SelectedSubmissions/";}
    if($_POST['faculty'] == "Manager") {$uploadDirectory = "/uploads/PublishedSubmissions/";}

    $errors = []; // Store errors here

    $fileExtensionsAllowed = ['jpeg','jpg','png','doc','docx','zip']; // These will be the only file extensions allowed 

    $fileName = $_FILES['the_file']['name'];
    $fileSize = $_FILES['the_file']['size'];
    $fileTmpName  = $_FILES['the_file']['tmp_name'];
    $fileType = $_FILES['the_file']['type'];
    $fileExtension = strtolower(end(explode('.',$fileName)));
    $uploadPath = $currentDirectory . $uploadDirectory . basename($fileName);

      if (isset($_POST['submit'])) {

        if (! in_array($fileExtension,$fileExtensionsAllowed)) {
          $errors[] = "This file extension is not allowed. Please upload a JPEG or PNG file";
        }

        if ($fileSize > 4000000) {
          $errors[] = "File exceeds maximum size (4MB)";
        }

        if (empty($errors)) {
          $didUpload = move_uploaded_file($fileTmpName, $uploadPath);

          if ($didUpload) {
            echo "The file " . basename($fileName) . " has been uploaded";
            if($uploadDirectory == "/uploads/SelectedSubmissions/") {header('Location: coordinator.php');}
            else if($uploadDirectory == "/uploads/PublishedSubmissions/") {header('Location: manager.php');}
          } else {
            echo "An error occurred. Please contact the administrator.";
          }
        } else {
          foreach ($errors as $error) {
            echo $error . "These are the errors" . "\n";
          }
        }

      }
?>