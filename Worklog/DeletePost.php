<?php
    session_start();
    require_once("db.php");
    $Prev = $_POST['PrevPage'];
    echo $Prev;
    $sql = "DELETE FROM `worklog` WHERE `worklog`.`ID` =".$_POST['DeletePost'];
    if($result = mysqli_query($conn, $sql)){  
    } 
    Header("Location: ".$Prev.".php");
?>


