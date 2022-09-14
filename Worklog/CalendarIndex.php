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
        echo $_SESSION['FullDate'];
        echo "<div id='DataContainer'>";
            $sql = "SELECT * FROM worklog order by ID desc";
            if($result = mysqli_query($conn, $sql)){
                if(mysqli_num_rows($result) > 0){
                    while($row = mysqli_fetch_array($result)){
                        echo "<div id='Test'>";
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
        <form method="post" action="CalendarMonths.php">
            <?php echo 'Kommentar: <input type="hidden" name="ShowMonths" value="'.$Year.'">' ?>
            <input type="submit" value="Submit">
        </form>

        <form method="post" action="upload.php">
            <?php echo 'Go to current day: <input type="hidden" name="Today" value="'.$Today.'">' ?>
            <input type="submit" value="Submit">
        </form>
        
    </div>
</div>


