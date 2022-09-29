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
                    <div id='DateDisplay'>  
                        <div id='Dates'>
                            <?php
                                echo $Year." ";

                            ?>
                        </div>
                    </div>
        <?php 
            if($_POST['ShowMonths'] != NULL){ // If a month has been recieved, fill with data
                echo '<div class="CalDaySquare" id="YearM">';
                    echo '<form method="post" action="CalendarMonths.php">'; // Year -1
                        echo '<input type="hidden" name="YearSelect" value="'.$YearDown.'">';
                        echo '<input type="hidden" name="ShowMonths" value="1">';
                        echo '<input type="submit" class="CalDaySquare" id="YearM2" value="←">';
                    echo '</form>';
                echo '</div>';

                echo '<div class="CalDaySquare" id="YearC">';
                    echo '<form method="post" action="CalendarMonths.php">'; // Year Current
                        echo '<input type="hidden" name="YearSelect" value="'.date('Y').'">';
                        echo '<input type="hidden" name="ShowMonths" value="1">';
                        echo '<input type="submit" class="CalDaySquare" id="YearC2" value="'.date('Y').'">';
                    echo '</form>';
                echo '</div>';

                echo '<div class="CalDaySquare" id="YearM">';
                    echo '<form method="post" action="CalendarMonths.php">'; // Year +1
                        echo '<input type="hidden" name="YearSelect" value="'.$YearUp.'">';
                        echo '<input type="hidden" name="ShowMonths" value="1">';
                        echo '<input type="submit" class="CalDaySquare" id="YearM2" value="→">';
                    echo '</form>';
                echo '</div>';
                
                while ($dummy < 12){ // Print out 12 months
                    $dummy += 1;
                    $monthName = date('M', mktime(0, 0, 0, $dummy, 1));
                    if($dummy < 10){ // Prefix single numbers by a 0 (01,02,03)
                        $dummy = "0" . $dummy;
                    }
                    echo '<div class="CalDaySquare">';
                    ?>
                            <form method="post" action="CalendarDays.php">
                                <?php echo '<input type="hidden" name="ShowDays" value="'.$dummy.'">';
                                    echo '<input type="hidden" name="YearSelect" value="'.$Year.'">';
                                    if (($dummy == date('m')) && ($Year == date('Y'))){ // If the month is the same as the current month. Color the month orange
                                        echo '<input type="submit" class="CalDaySquare" value="'.$monthName.'" style="background-color:orange;">';
                                    }
                                    else{
                                        echo '<input type="submit" class="CalDaySquare" value="'.$monthName.'">';
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
            <div class="CalDaySquare" id="BackB">
                <form method="post" action="CalendarIndex.php">
                    <input type="submit" class="CalDaySquare" id="Back" value="Back">
                </form>
            </div>
    </div>
</div>


