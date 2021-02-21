<?php
include('DBconnect.php');
session_start();
$id = $_SESSION['var'];
?>
<!DOCTYPE html>
<html>
    <div class="panel-heading1">
        <div class="row1">
            <div class="col-md-9">
                <h3 class="panel-title">Παράμετροι αναζήτησης</h3>
            </div>
            <br>
            <div class="col-md-2">
                <select name="year1" class="form-control" id="year1">
                    <option value="">Ετος απο</option>
                    <?php
                    $query = "SELECT EXTRACT(YEAR from timestamp) as x FROM locations WHERE user='$id' GROUP BY x DESC";

                    $sth = mysqli_query($db, $query);
                    $rows = array();
                    while ($r = mysqli_fetch_assoc($sth)) {
                        $rows[] = $r;
                    }

                    ?>
                    <?php
                    foreach ($rows as $row) {
                        echo '<option value="' . $row["x"] . '">' . $row["x"] . '</option>';
                    }
                    ?>
                </select>
            </div>
            <div class="col-md-2">
                <select name="year2" class="form-control" id="year2">
                    <option value="">Ετος εως</option>
                    <?php
                    $query = "SELECT EXTRACT(YEAR from timestamp) as x FROM locations WHERE user='$id' GROUP BY x DESC";

                    $sth = mysqli_query($db, $query);
                    $rows = array();
                    while ($r = mysqli_fetch_assoc($sth)) {
                        $rows[] = $r;
                    }

                    ?>
                    <?php
                    foreach ($rows as $row) {
                        echo '<option value="' . $row["x"] . '">' . $row["x"] . '</option>';
                    }
                    ?>
                </select>
            </div>


            <div class="col-md-2">
                <select name="month1" class="form-control" id="month1">
                    <option value="">Μήνας απο</option>
                    <?php
                    $query = "SELECT MONTH(timestamp) as x FROM locations WHERE user='$id' GROUP BY x ASC";

                    $sth = mysqli_query($db, $query);
                    $rows = array();
                    while ($r = mysqli_fetch_assoc($sth)) {
                        $rows[] = $r;
                    }

                    ?>
                    <?php
                    foreach ($rows as $row) {
                        echo '<option value="' . $row["x"] . '">' . $row["x"] . '</option>';
                    }
                    ?>
                </select>
            </div>
            <div class="col-md-2">
                <select name="month2" class="form-control" id="month2">
                    <option value="">Μηνας εως</option>
                    <?php
                    $query = "SELECT MONTH(timestamp) as x FROM locations WHERE user='$id' GROUP BY x ASC";
                    $sth = mysqli_query($db, $query);
                    $rows = array();
                    while ($r = mysqli_fetch_assoc($sth)) {
                        $rows[] = $r;
                    }

                    ?>
                    <?php
                    foreach ($rows as $row) {
                        echo '<option value="' . $row["x"] . '">' . $row["x"] . '</option>';
                    }
                    ?>
                </select>
            </div>

                <button id="search" class="go" type="button"> GO </button></div>

    </div>
