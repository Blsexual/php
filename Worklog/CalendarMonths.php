<?php  //Start of document
    session_start();
    require_once("db.php");
    echo '<link rel="stylesheet" href="style.css">';
?>
<div id='fuckyoupost' style='height:100vh;'> <!-- Canvas div -->
    <?php
        $dummy = NULL; // Variable for random usage
        $Year = $_SESSION['Year'];
        if(@$_POST['YearSelect']){
            $Year = $_POST['YearSelect'];
        }
        $YearUp = $Year + 1;
        $YearDown = $Year - 1;
        
        ?>
    <div id="CalendarBox">    
        <?php 
            if($_POST['ShowMonths'] != NULL){ // If a month has been recieved, fill with data
                echo '<form method="post" action="CalendarIndex.php">'; //To Index
                    echo'<input type="submit" class="CalDaySquare" id="Year" value="Back">';
                echo '</form>';
                
                echo '<form method="post" action="CalendarMonths.php">'; // Year -1
                    echo '<input type="hidden" name="YearSelect" value="'.$YearDown.'">';
                    echo '<input type="hidden" name="ShowMonths" value="1">';
                    echo '<input type="submit" class="CalDaySquare" id="Year" value="'.$YearDown.'">';
                echo '</form>';

                echo '<form method="post" action="CalendarMonths.php">'; // Year Current
                    echo '<input type="hidden" name="YearSelect" value="'.date('Y').'">';
                    echo '<input type="hidden" name="ShowMonths" value="1">';
                    echo '<input type="submit" class="CalDaySquare" id="Year" value="'.$Year.'">';
                echo '</form>';

                echo '<form method="post" action="CalendarMonths.php">'; // Year +1
                    echo '<input type="hidden" name="YearSelect" value="'.$YearUp.'">';
                    echo '<input type="hidden" name="ShowMonths" value="1">';
                    echo '<input type="submit" class="CalDaySquare" id="Year" value="'.$YearUp.'">';
                echo '</form>';

                while ($dummy < 12){ // Print out 12 months
                    $dummy += 1;
                    if($dummy < 10){ // Prefix single numbers by a 0 (01,02,03)
                        $dummy = "0" . $dummy;
                    }
                    echo '<div class="CalDaySquare">';
                        ?>
                            <form method="post" action="CalendarDays.php">
                                <?php echo '<input type="hidden" name="ShowDays" value="'.$dummy.'">';
                                    echo '<input type="hidden" name="YearSelect" value="'.$Year.'">';
                                    if (($dummy == date('m')) && ($Year == date('Y'))){ // If the month is the same as the current month. Color the month orange
                                        echo '<input type="submit" class="CalDaySquare" value="'.$dummy.'" style="background-color:orange;">';
                                    }
                                    else{
                                        echo '<input type="submit" class="CalDaySquare" value="'.$dummy.'">';
                                    }
                                ?>
                            </form>
                        <?php
                    echo '</div>';
                }
            }
            else{ // If no month has been set
                Header("Location: CalendarIndex.php");
            }
        ?>
    </div>
</div>


