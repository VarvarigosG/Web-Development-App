<?php
include('DBconnect.php');
?>
<!DOCTYPE html>
<html>
<div class="panel panel-default">
    <div class="panel-heading">
        <div class="row">
            <div class="col-md-9">
                <h3 class="panel-title">Παράμετροι αναζήτησης</h3>
            </div>
            <div class="col-md-4">
                <select name="act1" class="form-control" id="act1">
                    <option value="">Δραστηριοτητα</option>
                    <?php
                    $query = "SELECT activity FROM locations GROUP BY activity DESC";
                    $sth = mysqli_query($db, $query);
                    $rows = array();
                    while ($r = mysqli_fetch_assoc($sth)) {
                        $rows[] = $r;
                    }

                    ?>
                    <?php
                    foreach ($rows as $row) {
                        echo '<option value="' . $row["activity"] . '">' . $row["activity"] . '</option>';
                    }
                    ?>
                </select>
            </div>
            <div class="col-md-2">
                <select name="year1" class="form-control" id="year1">
                    <option value="">Ετος απο</option>
                    <?php
                    $query = "SELECT EXTRACT(YEAR from timestamp) as x FROM locations GROUP BY x DESC";

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
                    $query = "SELECT EXTRACT(YEAR from timestamp) as x FROM locations GROUP BY x DESC";

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
                <select name="day1" class="form-control" id="day1">
                    <option value="">Μέρα εώς</option>
                    <?php
                    $query = "SELECT DAYOFWEEK(timestamp) as x FROM locations GROUP BY x ASC";

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
                <select name="day2" class="form-control" id="day2">
                    <option value="">Μέρα εώς</option>
                    <?php
                    $query = "SELECT DAYOFWEEK(timestamp) as x FROM locations GROUP BY x ASC";

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
                    $query = "SELECT MONTH(timestamp) as x FROM locations GROUP BY x ASC";

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
                    $query = "SELECT MONTH(timestamp) as x FROM locations GROUP BY x ASC";

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
                <select name="time1" class="form-control" id="time1">
                    <option value="">Ωρα απο</option>
                    <?php
                    $query = "SELECT EXTRACT(HOUR from timestamp) as x FROM locations GROUP BY x ASC";

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
                <select name="time2" class="form-control" id="time2">
                    <option value="">Ωρα εως</option>
                    <?php
                    $query = "SELECT EXTRACT(HOUR from timestamp) as x FROM locations GROUP BY x ASC";

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
            <div class="col-md-4">
                <select name="act2" class="form-control" id="act2">
                    <option value="">Δραστηριοτητα σε Συνδιασμο</option>
                    <?php
                    $query = "SELECT activity FROM locations GROUP BY activity DESC";
                    $sth = mysqli_query($db, $query);
                    $rows = array();
                    while ($r = mysqli_fetch_assoc($sth)) {
                        $rows[] = $r;
                    }

                    ?>
                    <?php
                    foreach ($rows as $row) {
                        echo '<option value="' . $row["activity"] . '">' . $row["activity"] . '</option>';
                    }
                    ?>
                </select>
            </div>
            <div style="text-align: center;">
            <button id="search" type="button">GO</button></div>
        </div>
    </div>
