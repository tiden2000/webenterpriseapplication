<?php
include "config.php";
session_start();
if(isset($_SESSION['uname'])){
    $text = $_POST['text'];
    $text_message = "<div class='msgln'><span class='chat-time'>".date("g:i A")."</span> <b class='user-name'>".$_SESSION['uname']."</b> ".stripslashes(htmlspecialchars($text))."<br></div>";
    $chatlog = "log" . $_SESSION['id'] . ".html";
    file_put_contents($chatlog, $text_message, FILE_APPEND | LOCK_EX);
}
if(isset($_SESSION['uname_coordinator'])){
    $text = $_POST['text'];
    $text_message = "<div class='msgln'><span class='chat-time'>".date("g:i A")."</span> <b class='user-name'>".$_SESSION['uname_coordinator']."</b> ".stripslashes(htmlspecialchars($text))."<br></div>";
    $chatlog = "log" . $_SESSION['chatlogid'] . ".html";
    file_put_contents($chatlog, $text_message, FILE_APPEND | LOCK_EX);
}
?>