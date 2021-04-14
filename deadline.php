    <?php
    include "config.php";

    $deadlineId;

    if($_POST['faculty'] == "IT") {$deadlineId = 1;}
    if($_POST['faculty'] == "BS") {$deadlineId = 2;}
    if($_POST['faculty'] == "PO") {$deadlineId = 3;}

    $sql = "select closuredate from deadlines where id=" . $deadlineId;
    $result = mysqli_query($con, $sql);

    $loop = true;
    $orgDate = "";
    while($row = $result->fetch_assoc() and $loop == true) {
        $orgDate = $row['closuredate'];
        if(!empty($orgDate)) {$loop = false;}
    }

    $deadline = date("Y-m-d", strtotime($orgDate));

    $_SESSION['deadline'] = $deadline;


    $sql2 = "select closuredatefinal from deadlines where id=" . $deadlineId;
    $result2 = mysqli_query($con, $sql2);

    $loop2 = true;
    $orgDate2 = "";
    while($row2 = $result2->fetch_assoc() and $loop2 == true) {
        $orgDate2 = $row2['closuredatefinal'];
        if(!empty($orgDate2)) {$loop2 = false;}
    }

    $deadlineFinal = date("Y-m-d", strtotime($orgDate2));

    $_SESSION['deadlinefinal'] = $deadlineFinal;
    ?>