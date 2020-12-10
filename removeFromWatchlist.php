<?php

session_start();
$uid = $_SESSION["uid"];

$wid = $_GET["wid"];
$mid = $_GET["mid"];

	$db = new mysqli("", "", "", "");
	
	if ($db -> connect_error) {
	   die ("Connection failed: " . $db -> connect_error);
    }

   $deleteWatchlistQ = "DELETE FROM Entries WHERE mid='$mid' and wid='$wid';";
   $result = $db->query($deleteWatchlistQ);

   if ($result == true){
   echo json_encode($mid);
   }
   else
   {
    echo json_encode(null);
   }

	$db->close();
?>