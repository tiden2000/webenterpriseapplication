<?php
    include "config.php";
    include "deadline.php";

    $id = $_SESSION['id'];
    $currentDirectory = getcwd();

    // Direct uploaded files to their respective folders based on users by changing upload path
    if($_POST['faculty'] == "IT") {$uploadDirectory = "/uploads/Information Technology/" . $id . "/"; $faculty = "Information Technology";}
    if($_POST['faculty'] == "BS") {$uploadDirectory = "/uploads/Business/" . $id . "/"; $faculty = "Business";}
    if($_POST['faculty'] == "PO") {$uploadDirectory = "/uploads/Politics/" . $id . "/"; $faculty = "Politics";}
    if($_POST['faculty'] == "Coordinator") {$uploadDirectory = "/uploads/SelectedSubmissions/";}

    $errors = []; // Store errors here

    $fileExtensionsAllowed = ['jpeg','jpg','png','doc','docx','zip']; // These will be the only file extensions allowed 

    $fileName = $_FILES['the_file']['name'];
    $fileSize = $_FILES['the_file']['size'];
    $fileTmpName  = $_FILES['the_file']['tmp_name'];
    $fileType = $_FILES['the_file']['type'];
    $fileExtension = strtolower(end(explode('.',$fileName)));
    $uploadPath = $currentDirectory . $uploadDirectory . basename($fileName);

    $currentDate = date("Y-m-d");
    $orgDate = $_SESSION['deadline'];
    $deadline = date("Y-m-d", strtotime($orgDate));

    $date1 = new DateTime($currentDate);
    $date2 = new DateTime($deadline);

    if($date2 > $date1) {

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
            while($row = mysqli_fetch_array($result)) {  // Find coordinator with corresponding faculty and send a notification email
              if(!empty($row['email'])) {
                $to_email = $row['email'];
                $subject = "Student with id: " . "'" . $id . "'" . " has submited an entry.";
                $message = 'A student has uploaded a submission, please check your dashboard.';
                $headers = 'From: noreply@university.com';
                mail($to_email,$subject,$message,$headers);
              }
            }
            echo "The file " . basename($fileName) . " has been uploaded";
              if($faculty == "Information Technology") {header('Location: informationtechnology.php');}
              else if($faculty == "Business") {header('Location: business.php');}
              else if($faculty == "Politics") {header('Location: politics.php');}
          } else {
            echo "An error occurred. Please contact the administrator.";
          }
        } else {
          foreach ($errors as $error) {
            echo $error . "These are the errors" . "\n";
          }
        }

      }
    }

    else { // Alert user of deadline overdue when attempt to upload 
      echo "<script>
      alert('Your deadline is overdue, new submissions are no longer allowed.');
      window.location.href='informationtechnology.php';
      </script>";
    }
?>