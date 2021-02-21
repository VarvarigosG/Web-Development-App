<?php
date_default_timezone_set('Europe/Athens');
session_start();
include('functions.php');
include('DBconnect.php');
$errors = array();
$file_name = $_FILES['jfile']['name'];
$file_size = $_FILES['jfile']['size'];
$file_tmp = $_FILES['jfile']['tmp_name'];
if(move_uploaded_file($file_tmp, "jfiles/" . $file_name))
{
$str = file_get_contents("jfiles/$file_name");
$data_array = json_decode($str, true);
$usr = $_SESSION['user']['username'];
$id = $_SESSION['user']['id'];
foreach ($data_array['locations'] as $location) {
    $tmstp = $location['timestampMs'];
    $tmstp = date('Y-m-d H:i:s', $tmstp / 1000);
    $lat = $location['latitudeE7'] / 10000000;
    $long = $location['longitudeE7'] / 10000000;
    $acc = $location['accuracy'];
    $latC = 38.230462;
    $longC = 21.753150;
    //PERASMA DEDOMENWN STHN VASH 
    if (array_key_exists('activity', $location)) {
        foreach ($location['activity'] as $activity) {
            foreach ($activity['activity'] as $act) {
                $actType = $act['type'];

                if (isInPatras($long, $lat, $longC, $latC)) {
                    $query = "INSERT INTO locations(user,lat,lon,activity,timestamp,accuracy,username) VALUES('$id','$lat','$long','$actType','$tmstp','$acc','$usr')";
                    mysqli_query($db, $query);
                }
            }
        }
    }
}
}
    // header("Refresh:0");
    //header('location: User.php');
?>