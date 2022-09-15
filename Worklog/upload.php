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
                    $id = $row['ID'];
                    echo "<div id='Test'>";
                    if (!empty($_POST['Edit'])){
                        echo '<form method="post">';
                            echo '<input type="hidden" name="Editing" value="'.$id.'">';
                            echo '<input type="submit" id="Edit" value="Back">';
                        echo '</form>';
                    }
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
    <div class="CalDaySquare" id="BackB">
        <form method="post" action="CalendarDays.php">
            <?php echo '<input type="hidden" name="ShowDays" value="'.$dummy.'">' ?>
            <?php echo '<input type="hidden" name="DateTransfer" value="'.$DateTransfer.'">' ?>
            <input type="submit" class="CalDaySquare" id="Back" value="Back">
        </form>
    </div>
    <?php
    if (@$_POST['Edit'] == 0){
        echo '<div id="EditButton">';
            echo '<form method="post">';
                echo '<input type="hidden" name="Edit" value="1">';
                echo '<input type="submit" value="Edit">';
            echo '</form>';
        echo '</div>';
    }
    if (@$_POST['Edit'] == 1){
        echo '<div id="EditButton2">';
            echo '<form method="post">';
                echo '<input type="hidden" name="Edit" value="0">';
                echo '<input type="submit" value="StopEdit">';
            echo '</form>';
        echo '</div>';
    }
    if(@$_POST['Editing']){

        $sql = "SELECT * FROM worklog WHERE `worklog`.`ID` = ".$_POST['Editing'];
        if($result = mysqli_query($conn, $sql)){
            if(mysqli_num_rows($result) > 0){
                while($row = mysqli_fetch_array($result)){
                    $dummy = $row['TimeS'];
                    echo "Starting time: <input type='time' name='TimeS' required='require' placeholder='$dummy' value='$dummy'>";
                    $dummy = $row['TimeE'];
                    echo "Ending time: <input type='time' name='TimeE' required='require' placeholder='$dummy' value='$dummy'>";
                    $dummy = $row['Comment'];
                    echo "Kommentar: <input type='text' name='Kommentar' required='require' placeholder='$dummy' value='$dummy'>";

                }
            }
        }
        $sql = "UPDATE `worklog` SET `TimeS` = '14:30', `TimeE` = '17:45', `Date` = '2022-09-14', `Comment` = 'ded' WHERE `worklog`.`ID` = 294";
    }
        ?>
    </div>
</div>



