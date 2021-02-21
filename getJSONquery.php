<?php
$val;$val1;$val2;$val3;$val4;$val5;$val6;$val7;$val8;$val9;
include('functions.php');
include('DBconnect.php');
global $db;
if($_GET["QN"]==1){
$query = "SELECT activity as x,(Count(activity)* 100 / (Select Count(*) From locations)) as value FROM locations WHERE activity='STILL' OR activity='IN_VEHICLE'OR activity='ON_BICYCLE'OR activity='WALKING'OR activity='RUNNING' OR activity='ON_FOOT' OR activity='UNKNOWN' OR activity='TILTING'GROUP BY activity";
}
elseif($_GET["QN"]==2){
    $query = "SELECT username as x,COUNT(*) as value FROM locations GROUP BY username";
}
elseif($_GET["QN"]==3){
    $query = "SELECT MONTH(timestamp) as x,
    COUNT(*) as value 
    FROM locations GROUP BY x";
}
elseif($_GET["QN"]==4){
    $query = "SELECT DAYOFWEEK(timestamp) as x,COUNT(*) as value FROM locations GROUP BY x";
}
elseif($_GET["QN"]==5){
    $query = "SELECT EXTRACT(HOUR from timestamp)as x,COUNT(*) as value FROM locations GROUP BY x";
}
elseif($_GET["QN"]==6){
    $query = "SELECT EXTRACT(YEAR from timestamp)as x,COUNT(*) as value FROM locations GROUP BY x";
}
elseif($_GET["QN"]==7){
    $val=$_GET["val"];
    $val1=$_GET["val1"];
    $val2=$_GET["val2"];if($val2==''){$val2=0;}
    $val3=$_GET["val3"];if($val3==''){$val3=9999;}
    $val4=$_GET["val4"];if($val4==''){$val4=0;}
    $val5=$_GET["val5"];if($val5==''){$val5=9999;}
    $val6=$_GET["val6"];if($val6==''){$val6=0;}
    $val7=$_GET["val7"];if($val7==''){$val7=9999;}
    $val8=$_GET["val8"];if($val8==''){$val8=0;}
    $val9=$_GET["val9"];if($val9==''){$val9=9999;}
    if ($val2!=0 && $val3==9999){$val3=$val2;}
    if ($val4!=0 && $val5==9999){$val5=$val4;}
    if ($val6!=0 && $val7==9999){$val7=$val6;}
    if ($val8!=0 && $val9==9999){$val9=$val8;}
    if ($val8!='' && $val1!=''){
    if($val!='' && $val1!='')
        $query = "SELECT lat,lon FROM locations WHERE (EXTRACT(YEAR from timestamp)>='$val2' AND EXTRACT(YEAR from timestamp)<='$val3') AND (MONTH(timestamp)>='$val4' AND MONTH(timestamp)<='$val5') AND (EXTRACT(HOUR from timestamp)>='$val6' AND EXTRACT(HOUR from timestamp)<='$val7') AND (DAYOFWEEK(timestamp)>='$val8' AND DAYOFWEEK(timestamp)<='$val9') AND  (activity='$val' OR activity='$val1')";}
    elseif($val!='' && $val1=='') {
        $query = "SELECT lat,lon FROM locations WHERE (EXTRACT(YEAR from timestamp)>='$val2' AND EXTRACT(YEAR from timestamp)<='$val3') AND (MONTH(timestamp)>='$val4' AND MONTH(timestamp)<='$val5') AND (EXTRACT(HOUR from timestamp)>='$val6' AND EXTRACT(HOUR from timestamp)<='$val7') AND (DAYOFWEEK(timestamp)>='$val8' AND DAYOFWEEK(timestamp)<='$val9') AND ( activity='$val')";
    //TSEK TI MERA PAIZEI THEMA
    }
    else{
        $query = "SELECT lat,lon FROM locations WHERE (EXTRACT(YEAR from timestamp)>='$val2' AND EXTRACT(YEAR from timestamp)<='$val3') AND (MONTH(timestamp)>='$val4' AND MONTH(timestamp)<='$val5') AND (EXTRACT(HOUR from timestamp)>='$val6' AND EXTRACT(HOUR from timestamp)<='$val7') AND (DAYOFWEEK(timestamp)>='$val8' AND DAYOFWEEK(timestamp)<='$val9')";
    }
}
elseif($_GET["QN"]==8){
    $val=$_GET["val"];
    $val1=$_GET["val1"];
    $val2=$_GET["val2"];if($val2==''){$val2=0;}
    $val3=$_GET["val3"];if($val3==''){$val3=9999;}
    $val4=$_GET["val4"];if($val4==''){$val4=0;}
    $val5=$_GET["val5"];if($val5==''){$val5=9999;}
    $val6=$_GET["val6"];if($val6==''){$val6=0;}
    $val7=$_GET["val7"];if($val7==''){$val7=9999;}
    $val8=$_GET["val8"];if($val8==''){$val8=0;}
    $val9=$_GET["val9"];if($val9==''){$val9=9999;}
    if ($val2!=0 && $val3==9999){$val3=$val2;}
    if ($val4!=0 && $val5==9999){$val5=$val4;}
    if ($val6!=0 && $val7==9999){$val7=$val6;}
    if ($val8!=0 && $val9==9999){$val9=$val8;}
    if ($val8!='' && $val1!=''){
    if($val!='' && $val1!='')
        $query = "SELECT* FROM locations WHERE (EXTRACT(YEAR from timestamp)>='$val2' AND EXTRACT(YEAR from timestamp)<='$val3') AND (MONTH(timestamp)>='$val4' AND MONTH(timestamp)<='$val5') AND (EXTRACT(HOUR from timestamp)>='$val6' AND EXTRACT(HOUR from timestamp)<='$val7') AND (DAYOFWEEK(timestamp)>='$val8' AND DAYOFWEEK(timestamp)<='$val9') AND  (activity='$val' OR activity='$val1')";}
    elseif($val!='' && $val1=='') {
        $query = "SELECT* FROM locations WHERE (EXTRACT(YEAR from timestamp)>='$val2' AND EXTRACT(YEAR from timestamp)<='$val3') AND (MONTH(timestamp)>='$val4' AND MONTH(timestamp)<='$val5') AND (EXTRACT(HOUR from timestamp)>='$val6' AND EXTRACT(HOUR from timestamp)<='$val7') AND (DAYOFWEEK(timestamp)>='$val8' AND DAYOFWEEK(timestamp)<='$val9') AND ( activity='$val')";
    //TSEK TI MERA PAIZEI THEMA
    }
    else{
        $query = "SELECT* FROM locations WHERE (EXTRACT(YEAR from timestamp)>='$val2' AND EXTRACT(YEAR from timestamp)<='$val3') AND (MONTH(timestamp)>='$val4' AND MONTH(timestamp)<='$val5') AND (EXTRACT(HOUR from timestamp)>='$val6' AND EXTRACT(HOUR from timestamp)<='$val7') AND (DAYOFWEEK(timestamp)>='$val8' AND DAYOFWEEK(timestamp)<='$val9')";
    }
}
$sth = mysqli_query($db, $query);
$rows = array();
while ($r = mysqli_fetch_assoc($sth)) {
    $rows[] = $r;
}
print json_encode($rows);

