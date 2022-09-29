<?php  //Start of document
        session_start();
        require_once("db.php");
        echo '<link rel="stylesheet" href="style.css">';
?>
<div id='fuckyoupost'>
    <?php
        $Year = date('Y');
        $Today = date('Y-m-d');
        $_SESSION['Year'] = date('Y');
        $_SESSION['Month'] = date('m');
        $_SESSION['Date'] = date('d');
        @$_SESSION['FullDate'] = $_SESSION['Year'].'-'.$_SESSION['Month'].'-'. $_SESSION['Date'];

        if((@$_POST['NewKommentar']) && (@$_POST['NewTimeE']) && (@$_POST['NewTimeS'])){
            $sql = "UPDATE `worklog` SET `TimeS` = '".$_POST['NewTimeS']."', `TimeE` = '".$_POST['NewTimeE']."', `Comment` = '".$_POST['NewKommentar']."' WHERE `worklog`.`ID` = ".$_POST['NewID'];
            if($result = mysqli_query($conn, $sql)){  
            } 
        }

        echo "<div id='DataContainer'>";
            $sql = "SELECT * FROM worklog order by `Date` desc";
            if($result = mysqli_query($conn, $sql)){
                if(mysqli_num_rows($result) > 0){
                    while($row = mysqli_fetch_array($result)){
                        $id = $row['ID'];
                        echo "<div id='Test'>";
                            if (!empty($_POST['Edit'])){
                                echo '<form method="post">';
                                    echo '<input type="hidden" name="Editing" value="'.$id.'">';
                                    echo '<input type="hidden" name="Edit" value="1">';
                                    echo '<input type="submit" id="Edit" value="Back">';
                                echo '</form>';
                            }
                            echo "<div id='TimeS' class='DataBox'> Time: " . $row['TimeS'] . " - " . $row['TimeE'];
                                echo "<form method='post' action='DeletePost.php'>";
                                    echo "<input type='hidden' name='DeletePost' value='".$row['ID']."'>";
                                    echo "<input type='hidden' name='PrevPage' value='CalendarIndex'>";
                                    echo "<input type='submit' id='Delete' value='Delete'>";
                                echo "</form>";
                            echo "</div>";
                            echo "<div id='Date' class='DataBox'> Posts date: " . $row['Date'] . "</div>";
                            echo "<div id='Comment' class='DataBox'> Comment: " . $row['Comment'] . "</div>";
                        echo "</div>";
                    }
                    echo "</table>";
                } 
                else{
                    echo "No match for Query";
                }
            } 
            else{
                echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
            }
        echo "</div>";
    ?>

    <div id="CalendarBox">   
        <div id="ChooseDate"> 
            <form method="post" action="CalendarMonths.php">
                <?php echo 'Choose Year/Month/Day: <input type="hidden" name="ShowMonths" value="'.$Year.'">' ?>
                <input type="submit" value="Go!">
            </form>
        </div>
        <div id="CurrentDate">
            <form method="post" action="upload.php">
                <?php echo 'Go to todays date: <input type="hidden" name="Today" value="'.$Today.'">' ?>
                <input type="submit" value="Submit">
            </form>
        </div>
            <?php
                if (@$_POST['Edit'] == 0){
                echo '<div id="EditPost">';
                    echo '<form method="post">';
                        echo '<input type="hidden" name="Edit" value="1">';
                        echo '<input type="submit" value="Edit">';
                    echo '</form>';
                    echo '</div>';
                }
                if (@$_POST['Edit'] == 1){
                    echo '<div id="EditPost">';
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
                                echo "<form method = 'post'>";
                                    echo "<div class='EditItems'>";
                                        $dummy = $row['TimeS'];
                                        echo "Starting time: <input type='time' name='NewTimeS' required='require' placeholder='$dummy' value='$dummy'><br>";
                                    echo "</div>";

                                    echo "<div class='EditItems'>";    
                                        $dummy = $row['TimeE'];
                                        echo "Ending time: <input type='time' name='NewTimeE' required='require' placeholder='$dummy' value='$dummy'><br>";
                                    echo "</div>";

                                    echo "<div class='EditItems'>";    
                                        $dummy = $row['Comment'];
                                        echo "Kommentar: <input type='text' name='NewKommentar' required='require' placeholder='$dummy' value='$dummy'><br>";
                                    echo "</div>";

                                    echo "<div class='EditItems'>";    
                                        $dummy = $row['ID'];
                                        echo "<input type='hidden' name='NewID' value='$dummy'>";
                                        echo "<br><input type='submit' value='Update'>";
                                    echo "</div>";

                                echo "</form>";

                            }
                        }
                    }
                }
            ?>
    </div>
</div>


