<?php  //Start of document
        session_start();
        require_once("db.php");
        echo '<link rel="stylesheet" href="style.css">';
?>
        <div id='fuckyoupost' style='height:100vh;'>
    <?php

        $Checked = FALSE;
        $dummy = NULL;
        if(@$_POST['ShowDays']){
            $_SESSION['Month'] = $_POST['ShowDays'];
        }
        if(@$_POST['YearSelect']){
            $_SESSION['Year'] = $_POST['YearSelect'];
        }
        $Year = $_SESSION['Year'];
        
    ?>
    <div id="CalendarBox">    
        <?php 
            if(1==1){
                ?>
                    <div id='DateDisplay'>
                        <div id='Dates'>
                            <?php
                                echo $_SESSION['Year']." ";
                                $monthName = date('F', mktime(0, 0, 0, $_SESSION['Month'], 1));
                                echo $monthName;
                            ?>
                        </div>
                    </div>
                    <div class="CalDaySquare" id="BackB">
                        <form method="post" action="CalendarMonths.php">
                            <?php echo '<input type="hidden" name="ShowMonths" value="'.$Year.'">' ?>
                            <?php echo '<input type="hidden" name="YearSelect" value="'.$Year.'">' ?>
                            <?php echo'<input type="submit" class="CalDaySquare" id="Back" value="Back">' ?>
                        </form>
                    </div>
                <?php
                while ($dummy < cal_days_in_month(CAL_GREGORIAN,$_SESSION['Month'],$Year)){
                    $dummy += 1;
                    if($dummy < 10){
                        $dummy = "0" . $dummy;
                    }
                    echo '<div class="CalDaySquare">';
                    ?>
                        <form method="post" action="upload.php">
                            <?php echo '<input type="hidden" name="ShowDays" value="'.$dummy.'">' ?>
                            <?php echo '<input type="hidden" name="Kommentar" value="'.NULL.'">' ?>
                            <?php echo '<input type="hidden" name="Date" value="'.NULL.'">' ?>
                            <?php echo '<input type="hidden" name="TimeE" value="'.NULL.'">' ?>
                            <?php echo '<input type="hidden" name="TimeS" value="'.NULL.'">';
                            if(($dummy == date('d')) && ($_SESSION['Month'] == date('m')) && ($_SESSION['Year'] == date('Y'))){
                                echo'<input type="submit" id="DayC" class="CalDaySquare" value="'.$dummy.'">';
                            }
                            else{
                                echo'<input type="submit" id="DayR" class="CalDaySquare" value="'.$dummy.'">';
                            }
                            ?>
                        </form>
                    <?php
                    echo '</div>';
                }
            }
        ?>
    </div>
</div>


