<?php
	$db = new mysqli("", "", "", "");
	
	if ($db -> connect_error) {
	   die ("Connection failed: " . $db -> connect_error);
	}

	$q = $_GET['search'];
    
    $q = "SELECT Movies.title, Movies.mid, Movies.poster, AVG(rating) as average
    FROM Movies LEFT JOIN Ratings
    ON Ratings.mid = Movies.mid 
    WHERE Movies.title LIKE '%$q%' 
    GROUP BY Movies.title, Movies.mid, Movies.poster
    ORDER BY average";

    $result = $db->query($q);

    $arr = array();

    while ($row = $result->fetch_assoc()){
        array_push($arr, $row);
    }
   echo json_encode($arr);

	$db->close();
?>