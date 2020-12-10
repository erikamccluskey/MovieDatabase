<?php

session_start();
$uid = $_SESSION["uid"];

	$db = new mysqli("", "", "", "");
	
	if ($db -> connect_error) {
	   die ("Connection failed: " . $db -> connect_error);
    }

    $q = "SELECT name,wid FROM Watchlists WHERE uid='$uid';";

    $result = $db->query($q);

    $arr = array();

    while ($row = $result->fetch_assoc()){
        array_push($arr, $row);
    }

   echo json_encode($arr);

	$db->close();
?>