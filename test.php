<?php
var_dump(valid_sql_date("20-11-0221"));

function valid_sql_date($date) {
    //add code here
    $valDate = true;
    $dateArr = explode("-", $date);
    
    if(count($dateArr) != 3 ||
       strlen($dateArr[0]) != 4 || 
       strlen($dateArr[1]) != 2 || 
       strlen($dateArr[2]) != 2 || 
       !checkDate($dateArr[1],$dateArr[2], $dateArr[0]))
    {
      $valDate = false;
    }
       return $valDate;
}

?>