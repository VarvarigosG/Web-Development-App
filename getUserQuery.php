<?php

include "DBconnect.php";
session_start();
$id = $_SESSION['var'];

if ($_GET["QN"] == 1) {

    $query = "SELECT MONTH(timestamp) as M,
(Count(activity)* 100 
/
(Select Count(*) From locations WHERE  user = '$id' and (NOT activity = 'STILL') AND (NOT activity = 'UNKNOWN') AND (timestamp >= DATE_SUB(CURDATE(),INTERVAL 12 MONTH)))) as Y
 FROM locations 
 WHERE (activity = 'ON_FOOT' OR activity = 'WALKING' OR activity = 'RUNNING' OR activity = 'ON_BICYCLE') 
 AND (timestamp >= DATE_SUB(CURDATE(),INTERVAL 13 MONTH)) AND user = '$id' 
 GROUP BY M";
} else if ($_GET["QN"] == 2) {
    $query = "(SELECT timestamp as F
    FROM locations
    WHERE user = '$id'
    ORDER BY timestamp DESC
    LIMIT 1)
    
    UNION ALL
    
    (SELECT timestamp 
    FROM locations
    
    WHERE user = '$id'
    ORDER BY timestamp ASC    
    LIMIT 1)";
} else if ($_GET["QN"] == 3) {

    $query = "SELECT recorded as R
    FROM locations
    WHERE user = '$id'
    ORDER BY recorded DESC
    LIMIT 1";
} else if ($_GET["QN"] == 4) {
    $query = "SELECT (COUNT(*) *100 
   /
   (SELECT COUNT(*) FROM locations 

   WHERE NOT activity = 'STILL' AND NOT activity = 'UNKNOWN' AND user='$id' AND (timestamp >= DATE_SUB(CURDATE(),INTERVAL 12 MONTH)) )) AS PERCENT  FROM locations 

WHERE (user='$id'AND (timestamp >= DATE_SUB(CURDATE(),INTERVAL 12 MONTH)) and (activity = 'ON_FOOT' OR activity = 'WALKING' OR activity = 'RUNNING' OR activity = 'ON_BICYCLE')) ";
} else if ($_GET["QN"] == 5) {


    $query4 = "SELECT user from locations where user='$id' AND (timestamp >= DATE_SUB(CURDATE(),INTERVAL 2 MONTH))";
    $result1 = mysqli_query($db, $query4);

    if (mysqli_num_rows($result1) > 0) {

        $sql = "DELETE FROM Leaderboard WHERE ID='$id'";
        mysqli_query($db, $sql);
        $query1 = "INSERT INTO Leaderboard(ID,Username,Score) 
    SELECT user, username, (Count(activity)* 100 
    /
    (Select Count(*) From locations WHERE  user = '$id' and (NOT activity = 'STILL') AND (NOT activity = 'UNKNOWN') 
    AND (timestamp >= DATE_SUB(CURDATE(),INTERVAL 2 MONTH))))
    FROM locations 
    WHERE (activity = 'ON_FOOT' OR activity = 'WALKING' OR activity = 'RUNNING' OR activity = 'ON_BICYCLE') 
    AND (timestamp >= DATE_SUB(CURDATE(),INTERVAL 2 MONTH)) AND user = '$id' 
     ";
        mysqli_query($db, $query1);
    }

    $query = "SELECT ROW_NUMBER() OVER (
            ORDER BY Score DESC
              ) row_num,ID,Username AS LEADER ,Score as S
            FROM Leaderboard 
            ORDER BY Score DESC LIMIT 3";
} else if ($_GET["QN"] == 6) {
    $query = "SELECT * FROM (SELECT ROW_NUMBER() OVER (
        ORDER BY Score DESC
          ) row_num,ID,Score as S
        FROM Leaderboard 
        ORDER BY Score DESC) T WHERE ID = '$id'";

}


$sth = mysqli_query($db, $query);
$rows = array();
while ($r = mysqli_fetch_assoc($sth)) {
    $rows[] = $r;
}
print json_encode($rows);
