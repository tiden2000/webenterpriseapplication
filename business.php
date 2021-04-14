<?php
include "config.php";

// Check if user is login or not
if(!isset($_SESSION['uname']) or !isset($_SESSION['BS'])){
    session_destroy();
    header('Location: login.php');
}

// logout
if(isset($_POST['but_logout'])){
    session_destroy();
    header('Location: index.php');
}

?>
<!doctype html>
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
        <title>Business Faculty</title>
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
                        <li class="nav-item">
                            <a class="nav-link" href="/login.php">Login</a>
                        </li>
                        <li class="nav-item text-white">
                            <div class="nav-link">
                            Logged in as: <?php echo $_SESSION['uname'];?>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

        <div class="container-closuredate">
                <?php

                // Retrive closure date and display it

                $sql = "select closuredate from deadlines where id=2";
                $result = mysqli_query($con, $sql);         
                $loop = true;
                $orgDate = "";
                while($row = $result->fetch_assoc() and $loop == true) {
                    $orgDate = $row['closuredate'];
                    if(!empty($orgDate)) {$loop = false;}
                }
                $deadline = date("d/m/Y", strtotime($orgDate));
                $currentDate = date("d-m-Y");

                echo "Your deadline is: " . $deadline . "  -----  ";

                // Calculate number of days left based on current day

                $deadline = date("d-m-Y", strtotime($orgDate));

                $date1 = new DateTime($currentDate);
                $date2 = new DateTime($deadline);
                $interval = $date1->diff($date2);

                if($date2 > $date1) {echo $interval->days . " day(s) left";}
                else {echo "Deadline is overdue.";}

                echo "<br>";
                ?>

                <?php

                // Retrive final closure date and display it

                $sql = "select closuredatefinal from deadlines where id=2";

                $result = mysqli_query($con, $sql);


                $loop = true;
                $orgDate = "";
                while($row = $result->fetch_assoc() and $loop == true) {
                    $orgDate = $row['closuredatefinal'];
                    if(!empty($orgDate)) {$loop = false;}
                }

                $deadline = date("d/m/Y", strtotime($orgDate));

                $currentDate = date("d-m-Y");

                echo "Your final deadline is: " . $deadline . "  -----  ";

                // Calculate number of days left based on current day

                $deadline = date("d-m-Y", strtotime($orgDate));

                $date1 = new DateTime($currentDate);
                $date2 = new DateTime($deadline);
                $interval = $date1->diff($date2);

                if($date2 > $date1) {echo $interval->days . " day(s) left";}
                else {echo "Final deadline is overdue.";}
                ?>
            </div>

            <div class="container-student">
            <form action="fileUploadScript.php" method="post" enctype="multipart/form-data">
            Upload a File (images and documents only):
            <input type="file" name="the_file" id="fileToUpload">
            <input type="hidden" id="faculty_input" name="faculty" value="BS" />  <!-- This hidden input lets the fileUploadScript.php know the correct faculty folder to upload to -->
            <input type="submit" name="submit" value="Start Upload">
            </form>

            <form action="fileUpdateScript.php" method="post" enctype="multipart/form-data">
            Update a File (images and documents only):
            <input type="file" name="the_file" id="fileToUpload">
            <input type="hidden" id="faculty_input" name="faculty" value="BS" /> <!-- This hidden input lets the fileUpdateScript.php know the correct faculty folder to upload to -->
            <input type="submit" name="update" value="Start Update">
            </form>
            <?php
            $id = $_SESSION['id'];

            // Create folder according to student's id
            $currentDirectory = getcwd();
            $path = "uploads/Business/" . $id;
            if (!file_exists($path)) {
                mkdir($path, 0777, true);
            }
            ?>

            <form action="file.php" method="post">
            <?php
            $str = 'uploads/Business/' . $id . '/*';
            $fileList = glob($str);
            $replaceStr = 'uploads/Business/' . $id . '/';
            echo "<select name='uploaded-files'>";
            foreach($fileList as $filename){
                if(is_file($filename)){
                    echo "<option value='" . $filename . "'>" . str_replace($replaceStr, "", $filename) . "</option>";
                }
            }
            echo "</select>";
            ?>
            <input type="hidden" id="faculty_input" name="faculty" value="BS"/>
            <input type="submit" name="files_download" value="Download Selected Submission"/>
            <input type="submit" name="files_submit" value="Delete Selected Submission"/>
            </form>

            <form method='post' action="">
                <input type="submit" value="Logout" name="but_logout">
            </form>
        
        </div>

        <div class="footer-dark-student">
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