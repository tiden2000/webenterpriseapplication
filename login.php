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
        <title>Login</title>
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
                    </ul>
                </div>
            </div>
        </nav>
    </header>
    <div class="container-login">
        <form method="post" action="">
            <div id="div_login">
                <h1>Login</h1>
                <div>
                    <input type="text" class="form-control" id="txt_uname" name="txt_uname" placeholder="Username" />
                </div>
                <div>
                    <input type="password" class="form-control" id="txt_uname" name="txt_pwd" placeholder="Password"/>
                </div>
                <div>
                    <input type="submit" class="btn btn-primary" value="Submit" name="but_submit" id="but_submit" />
                </div>
            </div>
        </form>
    </div>
<div>

<?php
include "config.php";

// The scrpit checks for valid student usernam and password THEN do the same for coordinator
// Therefore, students and coordinators MUST NOT have the same username and password

if(isset($_POST['but_submit'])){

    $uname = mysqli_real_escape_string($con,$_POST['txt_uname']);
    $password = mysqli_real_escape_string($con,$_POST['txt_pwd']);

    if ($uname != "" && $password != ""){

        // Get the row of the logged in student
        $sql_query_student = "select count(*) as cntUser from students where username='".$uname."' and password='".$password."'";
        $result = mysqli_query($con,$sql_query_student);
        $row = mysqli_fetch_array($result);
        $count = $row['cntUser'];

        // Get id of the currently loggin student
        $sql_query_student_id = "select id, faculty from students where username='".$uname."' and password='".$password."'";
        $result3 = mysqli_query($con, $sql_query_student_id);
        $row3 = mysqli_fetch_array($result3);
        $id = $row3['id'];
        $faculty = $row3['faculty'];
        $isStudent;

        // If username and password are valid, transfer to the corresponding student page along with their username and id
        if($count > 0){
            if($faculty == "Information Technology") {
                $_SESSION['uname'] = $uname;
                $_SESSION['id'] = $id;
                $_SESSION['IT'] = "";
                header('Location: informationtechnology.php');
            }
            else if($faculty == "Business") {
                $_SESSION['uname'] = $uname;
                $_SESSION['id'] = $id;
                $_SESSION['BS'] = "";
                header('Location: business.php');
            }
            else if($faculty == "Politics") {
                $_SESSION['uname'] = $uname;
                $_SESSION['id'] = $id;
                $_SESSION['PO'] = "";
                header('Location: politics.php');
            }
        }

        // Same process with student but for coordinator
        $sql_query_coordinator = "select count(*) as cntUser from coordinators where username='".$uname."' and password='".$password."'";
        $result2 = mysqli_query($con,$sql_query_coordinator);
        $row2 = mysqli_fetch_array($result2);
        $count2 = $row2['cntUser'];

        $sql_query_coordinator_faculty = "select faculty from coordinators where username='".$uname."' and password='".$password."'";
        $result5 = mysqli_query($con,$sql_query_coordinator_faculty);
        $row5 = mysqli_fetch_array($result5);
        $facultyCoordinator = $row5['faculty'];

        if($count2 > 0){
            if($facultyCoordinator == "Information Technology") {
                $_SESSION['uname_coordinator'] = $uname;
                $_SESSION['IT'] = "";
                header('Location: coordinator.php');
            }
            else if($facultyCoordinator == "Business") {
                $_SESSION['uname_coordinator'] = $uname;
                $_SESSION['BS'] = "";
                header('Location: coordinator.php');
            }
            else if($facultyCoordinator == "Politics") {
                $_SESSION['uname_coordinator'] = $uname;
                $_SESSION['PO'] = "";
                header('Location: coordinator.php');
            }
        }

        // Same process with student and coordinator but for manager
        $sql_query_manager = "select count(*) as cntUser from managers where username='".$uname."' and password='".$password."'";

        $result4 = mysqli_query($con,$sql_query_manager);

        $row4 = mysqli_fetch_array($result4);

        $count4 = $row4['cntUser'];

        if($count4 > 0){
            $_SESSION['uname_manager'] = $uname;
            header('Location: manager.php');
        }

        $sql_query_guest = "select count(*) as cntUser from guests where username='".$uname."' and password='".$password."'";

        $result4 = mysqli_query($con,$sql_query_guest);

        $row4 = mysqli_fetch_array($result4);

        $count4 = $row4['cntUser'];

        if($count4 > 0){
            $_SESSION['uname_guest'] = $uname;
            header('Location: guest.php');
        }
        else{
            echo "Invalid username and password";
        }
    }
}
?>
    </div>

    <div class="footer-dark-student" style="margin-top:250px;">
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