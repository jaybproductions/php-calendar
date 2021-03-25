<?php

//Start by getting the current year
function GetCurrentYear() {
    $current_year = date("Y");
    return $current_year;
}

//Setting the current year based on if the input is empty or not
function SetYear() {

    if(isset($_GET['year'])) {
        $year = $_GET['year'];
        return $year;  
    }else {
        $current_year = GetCurrentYear();
        return $current_year;
    }
}

//Getting the months and storing them in an array
function GetMonths() {

    $monthArr = array();
    
    for($month = 1; $month < 13; $month++) {
        //i could probably optimize this because right now it's taking in 2001 as the year by default -- not sure at the moment
        $dateObj = date("F", strtotime('01.'.$month.'.2001')); 
        array_push($monthArr, $dateObj);
    }
    
    return $monthArr;
}

//Get the number of days in the month by month and year --> This account for leap years
function GetDaysInMonth($month, $year) {
    
    $days_in_month=array();

    for($d=1; $d<=31; $d++)
    {
        $time=mktime(12, 0, 0, $month, $d, $year);   
        //if the date is valid push it to the array -- useful for months with less than 31 days       
        if (date('m', $time)==$month){
            $days_in_month[]=date('Y-m-d-D', $time);
        }       
            
    }
    
    return $days_in_month;
}


//Handling getting the starting date = this is not optimal - need to find a better way
function HandleStartingDay($month) {
    //get the first day of the month
    $startDay = $month[0];
    //remove unneeded data from the string only need "XXX"
    $stripped = substr($startDay, -3); 

    switch($stripped) {
        case "Sun":
            return "";
            break;
        case "Mon":
            return '<li></li>';
            break;
        case "Tue":
            return '<li></li><li></li>';
            break;
        case "Wed":
            return '<li></li><li></li><li></li>';
            break;
        case "Thu":
            return '<li></li><li></li><li></li><li></li>';
            break;
        case "Fri":
            return '<li></li><li></li><li></li><li></li><li></li>';
            break;
        case "Sat":
            return '<li></li><li></li><li></li><li></li><li></li><li></li>';
            break;
        default: 
            return ""; 
            break;
    }
}


//Setting the year
$year = SetYear();
//Setting the months 
$months = GetMonths();
//Setting the day strings for the UI
$dayStrings = array("Su", "Mo", "Tu", "We", "Th", "Fr", "Sa");

?>



<style>
    body {
        margin: auto;
        padding: 20px;
        text-align: center;
        height: 50%;
        width: 100%;
    }

    .year-input  {
        padding-top: 20px;
        margin: auto;
        padding: 70px, 0;
        height: 10%;
        text-align: left;
    }

    .company-logo {
        height: 50%;
        margin: auto;
    }

    .current-year {
        height: 50%;
        margin: auto;
        grid-column: auto / span 3;
    }

    .container {
        margin: auto;
        display: grid;
        width: 100%;
        grid-gap: 10px;
        grid-template-columns: repeat(4, 200px);
        grid-template-rows: 100% 100% 100%;
    }

    .month {
        width: 100%;
        height: 20px;
        display: inline-block;
        text-align: center;
        background-color: green;
    }

    .month-name {
        color: white;
        font-size: 18px;
    }


    .day-string {
        width: 100%;
        justify-content: space-between;
        word-spacing: 7px;
        background-color: green;
        color: white;
    }

    .days {
        padding: 10px 0;
        background: #eee;
        margin: 0;
    
    }

    .days ul {
        float: left;
        padding: 0px 0;
        background: #eee;
        margin: 0;
    }



    .days li {
        list-style-type: none;
        width: 13.6%;
        text-align: right;
        margin-bottom: 5px;
        font-size:12px;
        float: left;
    }

</style>


<html>
    <body>
        <div>
            <div class="year-input">
                <form method="get">
                    <label>Please enter a year:</label>
                    <input type="text" name="year"/> 
                </form>
            </div>
            <div class="container">
                <div class="company-logo">Company Logo</div>
                <div class="current-year">
                    <?php echo $year?>
                </div>
                <?php foreach($months as $key=>$value): ?>
                    <div class="month">
                        <div class="month-name"><?= $value; ?></div>
                            <div class="day-string">
                                <?php foreach($dayStrings as $dayStr): ?>
                                <?= $dayStr; ?> <?php endforeach; ?>
                            </div>  
                        <ul class="days">
                            <?php echo HandleStartingDay(GetDaysInMonth($key + 1, $year)); ?>
                            <?php foreach(GetDaysInMonth($key + 1, $year) as $key=>$day): ?> 
                            <li class="day">
                                <?= $key + 1 ?>
                            </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endforeach; ?><br />
            </div>
        </div>
    </body>
</html>

