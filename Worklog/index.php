<?php
    session_start();
    require_once("db.php");

    $sql = "SELECT * FROM worklog";
        if($result = mysqli_query($conn, $sql)){
            if(mysqli_num_rows($result) > 0){
                while($row = mysqli_fetch_array($result)){
                    echo "<br> Starting time: " . $row['TimeS'];
                    echo "<br> Ending time: " . $row['TimeE'];
                    echo "<br> Posts date: " . $row['Date'];
                    echo "<br> Comment: " . $row['Comment'] . "<br>";
                }
                echo "</table>";
                // Free result set
                mysqli_free_result($result);
            } else{
                echo "No match for Query";
            }
        } 
        else{
            echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
        }

        echo date("Y,m,d");