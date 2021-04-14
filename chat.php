<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
 
        <title>Tuts+ Chat Application</title>
        <meta name="description" content="Tuts+ Chat Application" />
        <link rel="stylesheet" href="/css/chat.css" />
    </head>
    <body>
    <?php
    include "config.php";
    if(!isset($_SESSION['uname']) and !isset($_SESSION['uname_coordinator'])){
        header('Location: login.php');
    }
    else {
      if(isset($_SESSION['uname'])) {$currentUser = $_SESSION['uname'];}
      if(isset($_SESSION['uname_coordinator'])) {$currentUser = $_SESSION['uname_coordinator'];}
    ?>
        <div id="wrapper">
            <div id="menu">
                <p class="welcome"><b><?php echo "Chatting as: " . $currentUser; ?></b></p>
                <p class="logout"><a id="exit" href="#">Exit Chat</a></p>
            </div>
 
            <div id="chatbox">

            <?php
            if(isset($_SESSION['uname_coordinator'])) {
                $query = "SELECT id FROM students WHERE students.name=" . "'" . $_SESSION['students-name'] . "'";
                $result = mysqli_query($con, $query);
                $row = mysqli_fetch_array($result);
                $id = $row['id'];
                $_SESSION['chatlogid'] = $id;
            }

            if(isset($_SESSION['uname'])) {
                $id = $_SESSION['id'];
                $_SESSION['chatlogid'] = $id;
            }

            $chatlog = "log" . $id . ".html";
            if(file_exists($chatlog) && filesize($chatlog) > 0){
                $contents = file_get_contents($chatlog);          
                echo $contents;
            }
            ?>
            </div>
 
            <form name="message" action="">
                <input name="usermsg" type="text" id="usermsg" />
                <input name="submitmsg" type="submit" id="submitmsg" value="Send" />
            </form>
        </div>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script type="text/javascript">
            // jQuery Document
            $(document).ready(function () {
                $("#submitmsg").click(function () {
                    var clientmsg = $("#usermsg").val();
                    $.post("post.php", { text: clientmsg });
                    $("#usermsg").val("");
                    return false;
                });
 
                function loadLog() {
                    var oldscrollHeight = $("#chatbox")[0].scrollHeight - 20; // Scroll height before the request
                    var id=<?php echo $_SESSION['chatlogid']?>;
                    $.ajax({
                        url: "log"+id+".html",
                        cache: false,
                        success: function (html) {
                            $("#chatbox").html(html); // Insert chat log into the #chatbox div
 
                            // Auto-scroll           
                            var newscrollHeight = $("#chatbox")[0].scrollHeight - 20; // Scroll height after the request
                            if(newscrollHeight > oldscrollHeight){
                                $("#chatbox").animate({ scrollTop: newscrollHeight }, 'normal'); // Autoscroll to bottom of div
                            }   
                        }
                    });
                }
 
                setInterval (loadLog, 2500);
 
                $("#exit").click(function () {
                    var exit = confirm("Are you sure you want to end the session?");
                    if (exit == true) {
                    window.location = "index.php?logout=true";
                    }
                });
            });
        </script>
    </body>
</html>
<?php
}
?>