<?php
include "config.php";

// Check if user is login or not
if(!isset($_SESSION['uname_guest'])){
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
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="/css/styles.css" />
        <link rel="stylesheet" href="/css/others.css" />
        <title>Guest Dashboard</title>
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
                                Logged in as: <?php echo $_SESSION['uname_guest'];?>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
        </header>

        <div class="container">
            <div class="row">
                <div class="col">
                <div class="guest-content">
                    <?php
                        function getFileCount($path) {
                            $size = 0;
                            $ignore = array('.','..','cgi-bin','.DS_Store');
                            $files = scandir($path);
                            foreach($files as $t) {
                                if(in_array($t, $ignore)) continue;
                                if (is_dir(rtrim($path, '/') . '/' . $t)) {
                                    $size += getFileCount(rtrim($path, '/') . '/' . $t);
                                } else {
                                    $size++;
                                }   
                            }
                            return $size;
                        }
                        $currentDirectory = getcwd();
                        $path = 'uploads/Information Technology';
                        $path2 = 'uploads/Business';
                        $path3 = 'uploads/Business';
                        $total = getFileCount($path) + getFileCount($path2) + getFileCount($path3);
                        echo "Total of articles submitted in:<br>";
                        echo "-- Information Technology: " . getFileCount($path). " article(s)<br>";
                        echo "-- Business: " . getFileCount($path2). " article(s)<br>";
                        echo "-- Politics: " . getFileCount($path3). " article(s)<br>";
                        echo "Total number: " . $total . " article(s)";
                    ?>
                </div>
                </div>
                <div class="col">
                    <div class="guest-content">
                        <?php
                            echo "Total number of selected articles: " . getFileCount('uploads/SelectedSubmissions') . " articles";
                            echo "<br>";
                            function getFileCountByYear($path, $year) {
                                $size = 0;
                                $ignore = array('.','..','cgi-bin','.DS_Store');
                                $files = scandir($path);
                                foreach($files as $t) {
                                    if(in_array($t, $ignore)) continue;
                                    if (is_dir(rtrim($path, '/') . '/' . $t)) {
                                        $size += getFileCount(rtrim($path, '/') . '/' . $t);
                                    } else if(date("Y", filectime('uploads/SelectedSubmissions/' . $t)) == $year) {
                                        $size++;
                                    }   
                                }
                                return $size;
                            }
                            echo "Number of selected articles in <br>-- 2021: " . getFileCountbyYear('uploads/SelectedSubmissions', 2021) . " articles";
                            echo "<br>";
                            echo "-- 2020: " . getFileCountbyYear('uploads/SelectedSubmissions', 2020) . " articles";
                            echo "<br>";
                            echo "-- 2019: " . getFileCountbyYear('uploads/SelectedSubmissions', 2019) . " articles";
                            ?>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col">
                    <div class="guest-content">
                        <?php
                        echo "Number of students that contributed their work in:<br>";
                        echo "-- Information Technology: " . $total_items  = count( glob("uploads/Information Technology/*", GLOB_ONLYDIR) ) . " article(s)<br>";
                        echo "-- Business: " . $total_items  = count( glob("uploads/Business/*", GLOB_ONLYDIR) ) . " article(s)<br>";
                        echo "-- Politics: " . $total_items  = count( glob("uploads/Politics/*", GLOB_ONLYDIR) ) . " article(s)<br>";
                        ?>
                    </div>
                </div>

                <div class="col">
                    <div class="guest-content">
                        <?php
                        $query = "SELECT * FROM coordinators";
                        $result = mysqli_query($con, $query);
                        $coordinator = 0;

                        while($row = mysqli_fetch_array($result)) {
                            $coordinator = $coordinator + 1;
                        }

                        echo "Number of coordinators participated: " . $coordinator . " coordinator(s)";
                        echo "<br>";

                        $query = "SELECT * FROM managers";
                        $result = mysqli_query($con, $query);
                        $manager = 0;

                        while($row = mysqli_fetch_array($result)) {
                            $manager = $manager + 1;
                        }

                        echo "Number of managers participated: " . $manager . " manager(s)";
                        echo "<br>";

                        $query = "SELECT * FROM students";
                        $result = mysqli_query($con, $query);
                        $student = 0;

                        while($row = mysqli_fetch_array($result)) {
                            $student = $student + 1;
                        }

                        echo "Number of students participated: " . $student . " student(s)";
                        ?>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col">
                    <div class="guest-content">
                        <?php
                        $currentYear = date("Y");
                        $files = scandir('uploads/SelectedSubmissions/');
                        unset($files[0]); // Unset dots
                        unset($files[1]);
                        echo "<h5>Download articles for " . $currentYear . "</h5>";
                        foreach($files as $file) {  // List files as download links
                            if(date("Y", filectime('uploads/SelectedSubmissions/' . $file)) == $currentYear) {
                                echo "<a href=$file>".basename($file)."</a>";
                            echo "<br>";
                            }
                        }
                        ?>
                    </div>
                </div>
            </div>    
            <form method='post' action="">
            <input type="submit" value="Logout" name="but_logout">
        </form>
        </div>

        <div class="footer-dark-student" style="margin-top:300px;">
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