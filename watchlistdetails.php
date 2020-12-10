<?php
  session_start();
  if (!isset($_SESSION["uid"]))
  {
    header("location: login.php");
    exit();
  } 
 else 
  {
  $uid = $_SESSION["uid"];
  $fname = $_SESSION["fname"];

  $db = new mysqli("", "", "", "");
    
  if ($db->connect_error)
  {
     die ("Connection failed: " . $db->connect_error);
  }

  $watchlistId = $_GET['wid'];
  $watchlistName = $_GET['watchlistName'];

  $q = 
  "SELECT Movies.title, Movies.mid, Movies.poster, AVG(rating) as average
  FROM Movies 
  LEFT JOIN Ratings ON Ratings.mid = Movies.mid 
  INNER JOIN Entries ON Movies.mid = Entries.mid
  WHERE Entries.wid = '$watchlistId'
  GROUP BY Movies.title, Movies.mid, Movies.poster
  ORDER BY average;";

$result=$db->query($q);

?>


<!DOCTYPE html>
<html>

<head>
    <title> MovieNet </title>
    <link rel="stylesheet" href="styleSheet.css">
    <script type="text/javascript" src="validation.js"> </script>
</head>

<body>

    <header>
        <h1 class="logo"> MovieNet </h1>

    </header>
    <br>

    <div class="topnav">
    <a class="active" href="homepage.php"> Home </a>
    <a href="watchlist.php"> Watchlists </a>

    <form action="homepage.php" method="POST">
      <input type="hidden" name="logoutValue" value='1' />
      <input type="submit" class="logout" value="Logout" />
    </form>
    <p> Hi, <?php echo $fname; ?> </p>


    <form action="homepage.php" method="GET" id="searchBar" class="searchform">
      <label for="search"> Search:</label>
      <input type="hidden" name="searchSubmit" value="1" />
      <input type="text" id="search" name="search">
      <input type="submit" value="Search" />
    </form>

  </div>

    <h2 class="name"> <?=$watchlistName?> </h2>
    
    <h4> Return to <a href="watchlist.php"> all watchlists </a> </h4>

    <p class="center" id="delete_msg"></p>

    <div class="watchlist-container">

    <?php

while($row = $result->fetch_assoc()){
  $title = $row["title"];
  $mid = $row["mid"];
  $poster = $row["poster"];
  $rating = $row["average"];

?>

        <section>

    <div id="<?=$mid?>">
    <form onclick="location.href = 'details.php?mid=<?=$mid?>'" method="GET"> 
      <input type="hidden" name="mid" value="<?=$mid?>"/>
      <img class="watchlistposter" src="<?php echo $poster;?>.jpg" alt="<?=$title?> poster">
     </form>
      <h3 class="center"> <?=$title?> </h3>
      <h5 class="center"> Rating: <?= $rating ?> / 5 </h5>
      <form>
      <input type="hidden" id="mid" name="mid" value="<?=$mid?>"/>
      <input type="hidden" id="wid" name="wid" value="<?=$watchlistId?>"/>
      <button type="button" class="deleteButton"> Delete </button>
      </form>
    </div>

      <br>

    </section>

    <?php
  }
  $db->close();
}
  ?>
</div>

<script type="text/javascript" src="events-r.js"></script>
</body>

</html>