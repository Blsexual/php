<?php  //Start of document
        session_start();
        require_once("db.php");
        echo '<link rel="stylesheet" href="style.css">';
?>
<div id='fuckyoupost'>
    <?php
        $Checked = FALSE;
        $CurrentTime = date("H:i");
        $dummy = NULL;
        $Kommentar = NULL;
        $DateTransfer = @$_SESSION['FullDate'];
        $Today = $_SESSION['FullDate'];
        if(@$_POST['ShowDays']){
            $_SESSION['Date'] = $_POST['ShowDays'];
        }
        $Today = $_SESSION['Year'] . "-" . $_SESSION['Month'] . "-" . $_SESSION['Date'];
        if ($Today < 10){
            $Today = "0" . $Today;
        }

        $monthName = date('M', mktime(0, 0, 0, $_SESSION['Month']));
        echo $monthName;
        
        
        echo "<div id='DataContainer'>";
        $sql = "SELECT * FROM `worklog` WHERE Date = '$Today' order by ID desc";
        if($result = mysqli_query($conn, $sql)){
            if(mysqli_num_rows($result) > 0){
                while($row = mysqli_fetch_array($result)){
                    echo "<div id='Test'>";
                        echo "<div id='TimeS' class='DataBox'> Time: " . $row['TimeS'] . " - " . $row['TimeE'];
                            echo "<form method='post' action='DeletePost.php'>";
                                echo "<input type='hidden' name='DeletePost' value='".$row['ID']."'>";
                                echo "<input type='hidden' name='PrevPage' value='upload'>";
                                echo "<input type='submit' id='Delete' value='Delete'>";
                            echo "</form>";
                        echo "</div>";
                        echo "<div id='Date' class='DataBox'> Posts date: " . $row['Date'] . "</div>";
                        echo "<div id='Comment' class='DataBox'> Comment: " . $row['Comment'] . "</div>";
                    echo "</div>";
                }
                echo "</table>";
                mysqli_free_result($result);
            } else{
                echo "No results";
            }
        } else{
            echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
        }
        echo "</div>";
        
        if (@$_POST['Kommentar'] != NULL){
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
                            Header("Location: CalendarIndex.php");
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
    ?>

<div id="CalendarBox">    
    <form method="post">
        Date: <input type="text" name="Date" required="require" onfocus='(this.type="date")' onblur='(this.type="text")' <?php echo'value="'.$Today.'"' ?>><br>
        Starting time: <input type="text" name="TimeS" required="require" onfocus='(this.type="time")' onblur='(this.type="text")' <?php echo'value="'.$CurrentTime.'"' ?>><br>
        Ending time: <input type="text" name="TimeE" required="require" onfocus='(this.type="time")' onblur='(this.type="text")'><br>
        Kommentar: <input type="text" name="Kommentar" required="require">
        <?php echo '<input type="hidden" name="CurrentDate" value="'.$Today.'">'?>
        <?php echo '<input type="hidden" name="Reload" value="1">'?>
        <input type="submit">
    </form>
    <form method="post" action="CalendarIndex.php">
        <input type="submit" id="Year" value="To index">
    </form>
    <form method="post" action="CalendarDays.php">
        <?php echo '<input type="hidden" name="ShowDays" value="'.$dummy.'">' ?>
        <?php echo '<input type="hidden" name="DateTransfer" value="'.$DateTransfer.'">' ?>
        <input type="submit" id="Year" value="Back">
    </form>
        <?php 
            

        ?>
    </div>
</div>



