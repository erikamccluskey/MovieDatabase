<?php

session_start();
$uid = $_SESSION["uid"];

$wid = $_GET["wid"];
$mid = $_GET["mid"];

$db = new mysqli("", "", "", "");

if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}

    $q1 = "INSERT INTO Entries (wid, mid, dateAdded) VALUES ('$wid', '$mid', NOW());";
    $result = $db->query($q1);

   echo json_encode($wid); 

$db->close();
?>