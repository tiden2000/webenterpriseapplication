<?php
include "config.php";
// Check if user is login or not
if(!isset($_SESSION['uname_coordinator'])){
    session_destroy();
    header('Location: login.php');
}

// logout
if(isset($_POST['but_logout'])){
    session_destroy();
    header('Location: index.php');
}

?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="/css/styles.css" />
        <link rel="stylesheet" href="/css/others.css" />
        <title>Coordinator Dashboard</title>
    </head>
    
    <body>
        <header>
            <nav class="navbar navbar-expand-sm bg-dark navbar-dark">
                <div class="container">
                    <a class="navbar-brand" href="/index.php">SILVERLEAF UNIVERSITY</a>
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="collapsibleNavbar">
                        <ul class="navbar-nav">
                            <li class="nav-item">
                                <a class="nav-link" href="/informationtechnology.php">InformationTechnology</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="/business.php">Business</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="/politics.php">Polictics</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="/coordinator.php">Coordinator</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="/manager.php">Manager</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="/guest.php">Guest</a>
                            </li>
                            <li class="nav-item text-white">
                                <div class="nav-link">
                                Logged in as: <?php echo $_SESSION['uname_coordinator'];?>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
        </header>
        <div class="container-coordinator-closuredate">
            <div class="container">
                <div class="row">

                    <div class="col-md-auto">
                        <!-- This form is for choosing closure date -->
                        <form action="" method="post">
                        <label for="deadline">Closure Date: </label>
                        <input type="date" id="deadline" name="deadline">

                        <label for="faculty">Faculty: </label>
                        <select id="faculty" name="faculty">
                            <option value="1">Information Technology</option>
                            <option value="2">Business</option>
                            <option value="3">Politics</option>
                        </select>

                        <input type="submit">
                        </form>

                        <!-- This form is for choosing FINAL closure date -->

                        <form action="" method="post">
                        <label for="deadline-final">Final Closure Date: </label>
                        <input type="date" id="deadline-final" name="deadline-final">

                        <label for="faculty">Faculty: </label>
                        <select id="faculty" name="faculty">
                            <option value="1">Information Technology</option>
                            <option value="2">Business</option>
                            <option value="3">Politics</option>
                        </select>

                        <input type="submit">
                        </form>
                    </div>

                    <div class="col">
                        <form action="#" method="post">
                        <?php
                        $query = "SELECT students.name FROM students";
                        $result = mysqli_query($con, $query);
                        echo "<select name='students'>";
                        while($row = mysqli_fetch_array($result)) {   // Creates a loop to loop through results
                            if(!empty($row['name'])) { // Print student names
                                echo $row['name'];
                                echo "<option value='" . $row['name'] . "'>" . $row['name'] . "</option>";
                            }
                        }
                        echo "</select>";
                        ?>

                        <input type="submit" name="students_submit" value="Open Chat Window" style="margin-top:10px"/>
                        </form>

                        <?php
                        if(isset($_POST['students_submit'])){
                            $selected_val = $_POST['students'];  // Storing Selected Value In Variable
                            $_SESSION['students-name'] = $selected_val;
                            if (!headers_sent()) {    
                                header('Location: chat.php');
                                exit;
                            }
                            else {  
                                echo "<script>
                                window.location.href='chat.php';
                                </script>";
                            }
                        }
                        ?>
                    </div>
                    <div class="col">
                        <form method='post' action="">
                        <input type="submit" value="Logout" name="but_logout">
                        </form>
                    </div>
                </div>
            </div>
        </div>

            <!-- This script let user add closure and final closure dates -->

            <?php


            if(isset($_POST['deadline'])) {
            
                $orgDate = $_POST['deadline'];
            
                $deadline = date("Y-m-d", strtotime($orgDate));

                if(!empty($_POST['faculty'])) {
                    $selected = $_POST['faculty'];
                }
                $sql = "update deadlines set closuredate = " . "'" . $deadline . "'" . "where id=" .$selected. " and closuredate is not null";

                if ($con->query($sql) === TRUE) {
                }
                else {
                    echo "Error: " . $sql . "<br>" . $con->error;
                }

                echo "<script>
                window.location.href='coordinator.php';
                </script>";
            }

            if(isset($_POST['deadline-final'])) {

                $orgDate = $_POST['deadline-final'];
            
                $deadline = date("Y-m-d", strtotime($orgDate));

                if(!empty($_POST['faculty'])) {
                    $selected = $_POST['faculty'];
                }

                $sql = "update deadlines set closuredatefinal = " . "'" . $deadline . "'" . "where id=" .$selected. " and closuredatefinal is not null";

                if ($con->query($sql) === TRUE) {
                }
                else {
                    echo "Error: " . $sql . "<br>" . $con->error;
                }

                echo "<script>
                window.location.href='coordinator.php';
                </script>";
            }
            ?>
        </div>

        <div class="container-coordinator-closuredate">
            <div class="container">
                <div class="row">

                    <div class="col">
                        <h5>Closure Date</h5>
                        <?php

                        $query = "SELECT * FROM deadlines";
                        $result = mysqli_query($con, $query);

                        echo "<select name='closuredate'>";
                        while($row = mysqli_fetch_array($result)) {   // Creates a loop to loop through results
                            if(!empty($row['closuredate'])) { // Print closure date
                                echo $row['closuredate'];
                                echo "<option value='" . $row['closuredate'] . "'>" . $row['faculty'] . ": " . $row['closuredate'] . "</option>";
                            }
                        }
                        echo "</select>";
                        echo "<br>";
                        ?>
                        <h5>Final Closure Date</h5>
                        <?php
                        $query = "SELECT * FROM deadlines";
                        $result = mysqli_query($con, $query);

                        echo "<select name='closuredatefinal'>";
                        while($row = mysqli_fetch_array($result)) {   // Creates a loop to loop through results
                            if(!empty($row['closuredatefinal'])) { // Print closure date
                                echo $row['closuredatefinal'];
                                echo "<option value='" . $row['closuredatefinal'] . "'>" . $row['faculty'] . ": " . $row['closuredatefinal'] . "</option>";
                            }
                        }
                        echo "</select>";
                        ?>
                    </div>

                    <div class="col">
                        <div class="coordinator-files">
                        <form action="fileUploadScript_Staff.php" method="post" enctype="multipart/form-data">
                        Upload a File (images and documents only):
                        <input type="file" name="the_file" id="fileToUpload">
                        <input type="hidden" id="faculty_input" name="faculty" value="Coordinator" />
                        <input type="submit" name="submit" value="Start Upload">
                        </form>
                        </div>
                    </div>

                    <div class="col">
                        <form action="#" method="post">
                        <?php
                        if(isset($_SESSION['IT'])) {$query = "SELECT id FROM students WHERE faculty ='Information Technology'";}
                        else if(isset($_SESSION['BS'])) {$query = "SELECT id FROM students WHERE faculty ='Business'";}
                        else if(isset($_SESSION['PO'])) {$query = "SELECT id FROM students WHERE faculty ='Politics'";}
                        $result = mysqli_query($con, $query);
                        echo "<p>Students IDs:</p>";
                        echo "<select name='students-files'>";
                        while($row = mysqli_fetch_array($result)) {   // Creates a loop to loop through results
                            if(!empty($row['id'])) { // Print student names
                                echo $row['id'];
                                echo "<option value='" . $row['id'] . "'>" . $row['id'] . "</option>";
                            }
                        }
                        echo "</select>";
                        ?>

                        <input type="submit" name="students_submit-files" value="Open Student Submissions" style="margin-top:10px"/>
                        </form>
                        <?php
                        if(isset($_POST['students_submit-files'])){
                            $selected_val = $_POST['students-files'];  // Storing Selected Value In Variable
                            $_SESSION['students-id'] = $selected_val;
                            if (!headers_sent()) {    
                                header('Location: coordinator.php');
                                exit;
                            }
                            else {  
                                echo "<script>
                                window.location.href='coordinator.php';
                                </script>";
                            }
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>

            <div class="container-coordinator-files">
                <div class="container">
                        <div class="row">
                            <div class="col">
                            <?php
                                function dir_empty($dir) {
                                    if (!is_readable($dir)) return NULL; 
                                    return (count(scandir($dir)) == 2);
                                }
                                if(isset($_SESSION['IT'])) {$mainDir = 'uploads/Information Technology';}
                                else if(isset($_SESSION['BS'])) {$mainDir = 'uploads/Business';}
                                else if(isset($_SESSION['PO'])) {$mainDir = 'uploads/Politics';}
                                //set main directory

                                //gets sub directories of PDFS directory
                                $subDirectories = scandir($mainDir);

                                //removes the first two indexes in the directories array that are just dots
                                unset($subDirectories[0]);
                                unset($subDirectories[1]);

                                // Trim the file path to get the name of the file only
                                function get_file_from_path($file) {
                                    $tokens = explode('/', $file);
                                    $str = trim(end($tokens));
                                    return $str;
                                }

                            ?>

                            <!-- List files in drop-down-list -->
                            <form action="file.php" method="post">
                                <?php
                                if(!isset($_SESSION['students-id'])) {$_SESSION['students-id'] = 0;};
                                $str = $mainDir . '/' . $_SESSION['students-id'] . '/*';
                                $fileList = glob($str);
                                $replaceStr = $mainDir . '/' . $_SESSION['students-id'] . '/';
                                echo "<select name='uploaded-files'>";
                                foreach($fileList as $filename){
                                    if(is_file($filename)){
                                        echo "<option value='" . $filename . "'>" . str_replace($replaceStr, "", $filename) . "</option>";
                                    }
                                }
                                echo "</select>";
                                ?>
                                <input type="submit" name="files_download" value="Download Selected Submission"/>  <!-- Download button -->
                            </form>
                            
                            </div>
                            <div class="col">
                            <form action="file.php" method="post">
                                <?php
                                $str = 'uploads/SelectedSubmissions/*';
                                $fileList = glob($str);
                                $replaceStr = 'uploads/SelectedSubmissions/';
                                echo "<select name='uploaded-files'>";
                                foreach($fileList as $filename){
                                    if(is_file($filename)){
                                        echo "<option value='" . $filename . "'>" . str_replace($replaceStr, "", $filename) . "</option>";
                                    }
                                }
                                echo "</select>";
                                ?>
                                <input type="submit" name="files_download" value="Download Selected Submission"/>  <!-- Download button -->
                                <input type="submit" name="files_submit" value="Delete Selected Submission"/>  <!-- Delete button -->
                            </form>
                            <?php
                                $con->close();
                            ?>
                            </div>
                        </div>
                </div>
            </div>

            <div class="footer-dark">
        <footer>
            <div class="container">
                <div class="row">
                    <div class="col-sm-6 col-md-3 item">
                        <h3>General Information</h3>
                        <ul>
                            <li><p>silverleaf@university.com</p></li>
                            <li>Local: 01632 960608</li>
                            <li>International: +44 1632 960608</li>
                        </ul>
                    </div>
                    <div class="col-sm-6 col-md-3 item">
                        <h3>Faculties</h3>
                        <ul>
                            <li>39  Boroughbridge Road, BISHOPBRIDGE</li>
                            <li>64  Sea Road, LAMBOURN WOODLANDS</li>
                            <li>68  Ivy Lane, WARDY HILL</li>
                        </ul>
                    </div>
                    <div class="col-sm-6 col-md-3 item">
                        <h3>Legal</h3>
                        <ul>
                            <li><a href="">Copyright</a></li>
                            <li><a href="">Plagiarism</a></li>
                            <li><a href="">Privacy</a></li>
                            <li><a href="">Terms and Conditions</a></li>
                            <li><a href="">Cookie Policy</a></li>
                        </ul>
                    </div>
                    <div class="col-sm-6 col-md-3 item">
                        <h3>Social Media</h3>
                        <ul>
                            <li><a href="">Facebook</a></li>
                            <li><a href="">Twitter</a></li>
                            <li><a href="">Instagram</a></li>
                        </ul>
                    </div>
                </div>
                <p class="copyright">SILVERLEAF UNIVERSITY © 2021</p>
            </div>
        </footer>
    </div>
    </body>
</html>