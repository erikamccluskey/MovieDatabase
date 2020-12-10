<?php
session_start();
if (!isset($_SESSION["uid"])) {
  header("location: login.php");
  exit();
} else {
  $uid = $_SESSION["uid"];
  $fname = $_SESSION["fname"];

  $db = new mysqli("", "", "", "");

  if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
  }

  if (isset($_POST["deleteWatchlist"]) && $_POST["deleteWatchlist"]) {
    $wid = $_POST['wid'];

    $deleteWatchlistQ = "DELETE FROM Watchlists WHERE wid='$wid';";
    $db->query($deleteWatchlistQ);
  }

  if (isset($_POST["addNewWatchlist"]) && $_POST["addNewWatchlist"]) {
    $watchlistName = $_POST["watchlistNew"];

    $q = "INSERT INTO Watchlists (uid, name, dateCreated) VALUES ('$uid', '$watchlistName', NOW());";
    $result = $db->query($q);
  }

  $getWatchlistQuery = "SELECT name, wid FROM Watchlists WHERE uid='$uid';";
  $allWatchlistTitles = $db->query($getWatchlistQuery);
}


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

  <h3 class="name"> Watchlists </h3>

  <?php

  while ($row = $allWatchlistTitles->fetch_assoc()) {
    $watchlistName = $row['name'];
    $watchlistId = $row['wid'];

    $getFourMovies =
      "SELECT Movies.poster
FROM Movies
INNER JOIN Entries ON Movies.mid = Entries.mid
WHERE Entries.wid='$watchlistId'
LIMIT 4;";

    $posters = $db->query($getFourMovies);
  ?>

    <div class="general-watchlist-container">

      <section class="onemovie">
        <form onclick="location.href = 'watchlistdetails.php?wid=<?= $watchlistId ?>&watchlistName=<?= $watchlistName ?>'" method="GET">
          <input type="hidden" name="wid" value="<?= $watchlistId ?>" />
          <input type="hidden" name="watchlistName" value="<?= $watchlistName ?>" />
          <h3 class="watchlist-title"><?= $watchlistName ?></h3>
        </form>
        <p> Click on the watchlist to see all the movies </p>
        <br>

        <form action="watchlist.php" method="POST">
          <input type="hidden" name="deleteWatchlist" value='1' />
          <input type="hidden" name="wid" value="<?= $watchlistId ?>" />
          <input type="submit" class="watchlistbutton" value="Delete watchlist" />
        </form>


      </section>

      <?php

      while ($rowOfPoster = $posters->fetch_assoc()) {
        $poster = $rowOfPoster['poster'];
      ?>

        <section>
          <img class="watchlistposter" src="<?php echo $poster; ?>.jpg" />
        </section>

      <?php
      }
      ?>
    </div>
    <br>
  <?php
  }
  $db->close();
  ?>

  <br>

  <h3 class="name"> Want to create a new watchlist? </h3>
  <form action="watchlist.php" method="POST" id="watchlistForm" class="center">
    <input type="hidden" name="addNewWatchlist" value="1" />
    <label for="watchlistNew"> New watchlist name: </label><br>
    <input type="text" id="watchlistNew" name="watchlistNew"> <br>
    <label id="msg_watchlistName" class="err_msg"></label>
    <label id="msg_count" class="count"></label>
    <br>
    <input type="submit" value="Create a new watchlist" class="watchlistbutton" /><br>
  </form>

  <script type="text/javascript" src="events-r.js"></script>
</body>

</html>