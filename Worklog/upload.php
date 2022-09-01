<div id='fuckyoupost'>
    <?php
        session_start();
        require_once("db.php");
        echo '<link rel="stylesheet" href="style.css">';
        $Checked = FALSE;
        $Today = date("Y-m-d");
        $CurrentTime = date("h:i");


        
        if (!empty($_POST) || ($_POST['Kommentar'] != NULL)){
            $Date = $_POST['Date'];
            $TimeS = $_POST['TimeS'];
            $TimeE = $_POST['TimeE'];
            $Kommentar = $_POST['Kommentar'];

            $sql = "SELECT * FROM worklog";
            if($result = mysqli_query($conn, $sql)){
                if(mysqli_num_rows($result) > 0){
                    while($row = mysqli_fetch_array($result)){
                        if (($Date == $row['Date']) && ($TimeS == $row['TimeS']) && ($TimeE == $row['TimeE']) && ($Kommentar == $row['Comment'])) {
                            $Checked = TRUE;
                        }
                    }    
                    if ($Checked == FALSE) {
                        $sql2 = "INSERT INTO `worklog` (`ID`, `TimeS`, `TimeE`, `Date`, `Comment`) VALUES (NULL, '".$TimeS."', '".$TimeE."', '".$Date."', '".$Kommentar."')";
                        if ($conn->query($sql2) === TRUE) {
                            echo "New record created successfully";
                        } 
                        else {
                            echo "Error: " . $sql2 . "<br>" . $conn->error;
                        } 
                    }
                } 
                else{
                    echo "No match for Query";
                }
            }
        }


        $sql = "SELECT * FROM worklog";
        if($result = mysqli_query($conn, $sql)){
            if(mysqli_num_rows($result) > 0){
                while($row = mysqli_fetch_array($result)){
                    echo "<div id='Test'>";
                    echo "Starting time: " . $row['TimeS'];
                    echo "<br> Ending time: " . $row['TimeE'];
                    echo "<br> Posts date: " . $row['Date'];
                    echo "<br> Comment: " . $row['Comment'];
                    echo "</div>";
                }
                echo "</table>";
                // Free result set
                mysqli_free_result($result);
            } else{
                echo "No match for Query";
            }
        } else{
            echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
        }


    ?>
    
    <form method="post">
    Date: <input type="text" name="Date" required="require" onfocus='(this.type="date")' onblur='(this.type="text")' <?php echo'value="'.$Today.'"' ?>><br>
    Starting time: <input type="text" name="TimeS" required="require" onfocus='(this.type="time")' onblur='(this.type="text")' <?php echo'value="'.$CurrentTime.'"' ?>><br>
    Ending time: <input type="text" name="TimeE" required="require" onfocus='(this.type="time")' onblur='(this.type="text")'><br>
    Kommentar: <input type="text" name="Kommentar" required="require">
    <input type="submit">
    </form>
</div>


