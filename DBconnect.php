<?php
$db = mysqli_connect('localhost','root','','web');
if ($db->connect_error) {
	die("Connection failed:" . $db->connect_error);
}
