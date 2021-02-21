<?php
include ('functions.php');
include('DBconnect.php');
global $db;

    $query = "DROP table locations";
    $sth = mysqli_query($db, $query);
    
    $query1 = "CREATE TABLE locations(lat decimal(10,8),lon decimal(10,8),activity VARCHAR(100),timestamp datetime,user varchar(255),accuracy int(10),recorded datetime DEFAULT NOW())";
     $sth1 = mysqli_query($db, $query1);


// $query1 = "CREATE table locations(lat decimal(10,8),lon decimal(10,8),activity VARCHAR(100),timestamp datetime,user	varchar(255),accuracy int(10),recorded datetime DEFAULT NOW()";
// $sth1 = mysqli_query($db, $query1);
// $query2 = "DROP table users";
// $sth2 = mysqli_query($db, $query2);
// $query3 = "CREATE table users(id VARCHAR(250),password VARCHAR(250),email VARCHAR(250),username VARCHAR(250),user_type VARCHAR(250)";
// $sth3 = mysqli_query($db, $query3);
