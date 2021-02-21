<?php
include "DBconnect.php";
session_start();
$id = $_SESSION['var'];


global $db;
$val1;
$val2;
$val3;
$val4;
if ($_GET["Q"] == 1) {

    $val1 = $_GET["val1"];
    if ($val1 == '') {
        $val1 = 0;
    }
    $val2 = $_GET["val2"];
    if ($val2 == '') {
        $val2 = 9999;
    }
    $val3 = $_GET["val3"];
    if ($val3 == '') {
        $val3 = 0;
    }
    $val4 = $_GET["val4"];
    if ($val4 == '') {
        $val4 = 9999;
    }
    if ($val1 != 0 && $val2 == 9999) {
        $val2 = $val1;
    }
    if ($val3 != 0 && $val4 == 9999) {
        $val4 = $val3;
    }

    $query = "SELECT lat,lon FROM locations 
    WHERE user='$id' AND (EXTRACT(YEAR from timestamp)>='$val1' 
    AND EXTRACT(YEAR from timestamp)<='$val2') 
    AND (MONTH(timestamp)>='$val3' 
    AND MONTH(timestamp)<='$val4')";
}
if ($_GET["Q"] == 2) {

    $val1 = $_GET["val1"];
    if ($val1 == '') {
        $val1 = 0;
    }
    $val2 = $_GET["val2"];
    if ($val2 == '') {
        $val2 = 9999;
    }
    $val3 = $_GET["val3"];
    if ($val3 == '') {
        $val3 = 0;
    }
    $val4 = $_GET["val4"];
    if ($val4 == '') {
        $val4 = 9999;
    }
    if ($val1 != 0 && $val2 == 9999) {
        $val2 = $val1;
    }
    if ($val3 != 0 && $val4 == 9999) {
        $val4 = $val3;
    }

    $query = "SELECT activity as M,(Count(activity)* 100 / 
    (Select Count(*) From locations WHERE user='$id' AND (EXTRACT(YEAR from timestamp)>='$val1' 
    AND EXTRACT(YEAR from timestamp)<='$val2') 
    AND (MONTH(timestamp)>='$val3' 
    AND MONTH(timestamp)<='$val4'))) AS Y
    FROM locations WHERE user='$id' AND (EXTRACT(YEAR from timestamp)>='$val1' 
    AND EXTRACT(YEAR from timestamp)<='$val2') 
    AND (MONTH(timestamp)>='$val3' 
    AND MONTH(timestamp)<='$val4') 
    AND (activity='STILL' OR activity='IN_VEHICLE'OR activity='ON_BICYCLE'OR activity='WALKING'
    OR activity='RUNNING' OR activity='ON_FOOT' OR activity='UNKNOWN' OR activity='TILTING')
    GROUP BY M";
}
if ($_GET["Q"] == 3) {


    $val1 = $_GET["val1"];
    if ($val1 == '') {
        $val1 = 0;
    }
    $val2 = $_GET["val2"];
    if ($val2 == '') {
        $val2 = 9999;
    }
    $val3 = $_GET["val3"];
    if ($val3 == '') {
        $val3 = 0;
    }
    $val4 = $_GET["val4"];
    if ($val4 == '') {
        $val4 = 9999;
    }
    if ($val1 != 0 && $val2 == 9999) {
        $val2 = $val1;
    }
    if ($val3 != 0 && $val4 == 9999) {
        $val4 = $val3;
    }
    mysqli_query($db, "TRUNCATE TABLE Stats;");

    $query1 = " INSERT INTO Stats(activity, hour, sumAct)  
    SELECT distinct(activity), HOUR(timestamp) as hour,
    count(activity) as act
    FROM   locations WHERE user = '$id' AND (EXTRACT(YEAR from timestamp)>='$val1' 
    AND EXTRACT(YEAR from timestamp)<='$val2') 
    AND (MONTH(timestamp)>='$val3' 
    AND MONTH(timestamp)<='$val4')
    AND (activity='STILL' OR activity='IN_VEHICLE'OR activity='ON_BICYCLE'OR activity='WALKING'
    OR activity='RUNNING' OR activity='ON_FOOT' OR activity='UNKNOWN' OR activity='TILTING')
    GROUP BY HOUR(timestamp),activity";

    mysqli_query($db, $query1);

    $query = "SELECT t.activity as ACT, t.hour as H , t.sumAct
FROM ( SELECT activity , MAX(sumAct) AS max_sum
       FROM Stats
GROUP BY activity ) AS m
INNER JOIN Stats AS t
ON t.activity = m.activity
AND t.sumact = m.max_sum";
}

if ($_GET["Q"] == 4) {



    $val1 = $_GET["val1"];
    if ($val1 == '') {
        $val1 = 0;
    }
    $val2 = $_GET["val2"];
    if ($val2 == '') {
        $val2 = 9999;
    }
    $val3 = $_GET["val3"];
    if ($val3 == '') {
        $val3 = 0;
    }
    $val4 = $_GET["val4"];
    if ($val4 == '') {
        $val4 = 9999;
    }
    if ($val1 != 0 && $val2 == 9999) {
        $val2 = $val1;
    }
    if ($val3 != 0 && $val4 == 9999) {
        $val4 = $val3;
    }
    mysqli_query($db, "TRUNCATE TABLE StatsWeek;");

    $query2 = "INSERT INTO StatsWeek(activity, day, sumAct)         
        SELECT  distinct(activity), DAYOFWEEK(timestamp), count(*) FROM locations WHERE user = '$id' AND (EXTRACT(YEAR from timestamp)>='$val1' 
        AND EXTRACT(YEAR from timestamp)<='$val2') 
        AND (MONTH(timestamp)>='$val3' 
        AND MONTH(timestamp)<='$val4')
        AND (activity='STILL' OR activity='IN_VEHICLE'OR activity='ON_BICYCLE'OR activity='WALKING'
        OR activity='RUNNING' OR activity='ON_FOOT' OR activity='UNKNOWN' OR activity='TILTING')
        GROUP BY DAY(timestamp), activity";


    mysqli_query($db, $query2);
    $query = "SELECT t.activity as ACT
 , t.day as D  
 , t.sumAct
FROM ( SELECT activity 
          , MAX(sumAct) AS max_sum
       FROM StatsWeek
     GROUP BY activity ) AS m
INNER JOIN StatsWeek AS t
ON t.activity = m.activity
AND t.sumact = m.max_sum";
}

$sth = mysqli_query($db, $query);
$rows = array();
while ($r = mysqli_fetch_assoc($sth)) {
    $rows[] = $r;
}
print json_encode($rows);
