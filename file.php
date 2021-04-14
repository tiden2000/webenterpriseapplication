<?php
include "config.php";
$selected_val = $_POST['uploaded-files'];  // Storing Selected Value In Variable

if(isset($_POST['files_submit'])) {  // Delete selected file
    unlink($selected_val);
    if($_POST['faculty'] == "IT") {header('Location: informationtechnology.php');}
    else if($_POST['faculty'] == "BS") {header('Location: business.php');}
    else if($_POST['faculty'] == "PO") {header('Location: politics.php');}
    else if(isset($_SESSION['uname_coordinator'])) {header('Location: coordinator.php');}
    else {header('Location: index.php');}
}

if(isset($_POST['files_download'])) {  // Downloads selected file
    $tokens = explode('/', $selected_val);
    $str = trim(end($tokens));
    header("Content-disposition: attachment; filename=$str");
    readfile($selected_val);
}
?>