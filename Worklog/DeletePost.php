<div id='fuckyoupost'>
    <?php
        session_start();
        require_once("db.php");
    
        echo "<div id='DataContainer'>";
        $sql = "SELECT * FROM worklog order by ID desc";
        if($result = mysqli_query($conn, $sql)){
            if(mysqli_num_rows($result) > 0){
                while($row = mysqli_fetch_array($result)){
                    echo "<div id='Test'>";
                    echo "<div id='TimeS' class='DataBox'> Time: " . $row['TimeS'] . " - " . $row['TimeE']. "<div>  </div> </div>";
                    echo "<div id='Date' class='DataBox'> Posts date: " . $row['Date'] . "</div>";
                    echo "<div id='Comment' class='DataBox'> Comment: " . $row['Comment'] . "</div>";
                    echo "</div>";
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
        echo "</div>";
    ?>
</div>


