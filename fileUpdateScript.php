<?php
    include "config.php";
    include "deadline.php";

    $id = $_SESSION['id'];
    $currentDirectory = getcwd();
    $allow = false;

    // Direct uploaded files to their respective folders based on faculty by changing upload path
    if($_POST['faculty'] == "IT") {$uploadDirectory = "/uploads/Information Technology/" . $id . "/"; $faculty = "Information Technology"; $str = 'uploads/Information Technology/' . $id . '/*'; $replaceStr = 'uploads/Information Technology/' . $id . '/';}
    if($_POST['faculty'] == "BS") {$uploadDirectory = "/uploads/Business/" . $id . "/"; $faculty = "Business"; $str = 'uploads/Business/' . $id . '/*'; $replaceStr = 'uploads/Business/' . $id . '/';}
    if($_POST['faculty'] == "PO") {$uploadDirectory = "/uploads/Politics/" . $id . "/"; $faculty = "Politics"; $str = 'uploads/Politics/' . $id . '/*'; $replaceStr = 'uploads/Politics/' . $id . '/';}

    $errors = []; // Store errors here

    $fileExtensionsAllowed = ['jpeg','jpg','png','doc','docx','zip']; // These will be the only file extensions allowed 

    $fileName = $_FILES['the_file']['name'];
    $fileSize = $_FILES['the_file']['size'];
    $fileTmpName  = $_FILES['the_file']['tmp_name'];
    $fileType = $_FILES['the_file']['type'];
    $fileExtension = strtolower(end(explode('.',$fileName)));
    $uploadPath = $currentDirectory . $uploadDirectory . basename($fileName);

    $query = "SELECT email FROM coordinators WHERE faculty=" . "'" . $faculty . "'";
    $result = mysqli_query($con, $query);

    $currentDate = date("Y-m-d");
    $orgDate = $_SESSION['deadlinefinal'];
    $deadline = date("Y-m-d", strtotime($orgDate));

    $date1 = new DateTime($currentDate);
    $date2 = new DateTime($deadline);

    if($date2 > $date1) {

      if (isset($_POST['update'])) {
        $name = basename($fileName);
        foreach(glob($str) as $filename){
          $uploadedFileName = str_replace($replaceStr, "",$filename);
          if($uploadedFileName == $name) {
            $allow = true;
            break;
          }
        }

        if (! in_array($fileExtension,$fileExtensionsAllowed)) {
          $errors[] = "This file extension is not allowed. Please upload a JPEG or PNG file";
        }

        if ($fileSize > 4000000) {
          $errors[] = "File exceeds maximum size (4MB)";
        }

        if (empty($errors) and $allow == true) {
          $didUpload = move_uploaded_file($fileTmpName, $uploadPath);

          if ($didUpload) {
            while($row = mysqli_fetch_array($result)) {   // Find coordinator with corresponding faculty and send a notification email
              if(!empty($row['email'])) {
                $to_email = $row['email'];
                $subject = "Student with id: " . "'" . $id . "'" . " has submited an update on their current submission.";
                $message = 'A student has updated a submission, please check your dashboard.';
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
          if($_POST['faculty'] == "IT") {
            echo "<script>
            alert('To update a submitted file, you must upload another file with the same name.');
            window.location.href='informationtechnology.php';
            </script>";
          }
          if($_POST['faculty'] == "BS") {
            echo "<script>
            alert('To update a submitted file, you must upload another file with the same name.');
            window.location.href='business.php';
            </script>";
          }
          if($_POST['faculty'] == "PO") {
            echo "<script>
            alert('To update a submitted file, you must upload another file with the same name.');
            window.location.href='politics.php';
            </script>";
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