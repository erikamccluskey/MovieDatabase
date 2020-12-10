<?php
session_start();

$confirm = "";
$alreadyExists = '0';
$rateError = "";
$notLoggedIn = '0';

$db = new mysqli("", "", "", "");

if ($db->connect_error) {
  die("Connection failed: " . $db->connect_error);
} else {

  if (isset($_POST["rate"]) && $_POST["rate"]) {
    if (!isset($_SESSION["uid"])) {
      $rateError = "Please login to rate a movie.";
    } else {
      $uid = $_SESSION["uid"];
      $rating = $_POST['rating'];
      $movieToRate = $_POST['movieId'];

      $addRating =
        "INSERT INTO Ratings (uid, mid, rating, dateRated)
      VALUES ('$uid', '$movieToRate', '$rating', NOW());";

      $db->query($addRating);
    }
  }

  $movie = $_GET["mid"];
  $q =
    "SELECT Movies.title, Movies.mid, Movies.poster, Movies.origin, Movies.cast, Movies.director, Movies.year, Movies.wikiLink, Movies.genre, AVG(rating) as average
    FROM Movies LEFT JOIN Ratings
    ON Ratings.mid = Movies.mid 
    WHERE Movies.mid = '$movie'
    GROUP BY Movies.title, Movies.mid, Movies.poster, Movies.origin, Movies.cast, Movies.director, Movies.year, Movies.wikiLink, Movies.genre;";

  $result = $db->query($q);
  $row = $result->fetch_assoc();

  $genre = $row["genre"];
  $title = $row["title"];
  $poster = $row["poster"];
  $year = $row["year"];
  $cast = $row["cast"];
  $origin = $row["origin"];
  $director = $row["director"];
  $link = $row["wikiLink"];
  $rating = $row["average"];



  if (!isset($_SESSION["uid"])) {
    $notLoggedIn = '1';
    $db->close();
  } else {
    $uid = $_SESSION["uid"];
    $fname = $_SESSION["fname"];

    $viewMovieQuery = "INSERT INTO Views (uid, mid, timeViewed) VALUES ('$uid','$movie', NOW());";
    $db->query($viewMovieQuery);

    $db->close();
  }
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

    <?php
    if ($notLoggedIn == '0') {
    ?>

      <form action="homepage.php" method="POST">
        <input type="hidden" name="logoutValue" value='1' />
        <input type="submit" class="logout" value="Logout" />
      </form>
      <p> Hi, <?php echo $fname; ?> </p>

    <?php
    } else {
    ?>

      <form action="login.php" method="POST">
        <input type="submit" class="logout" value="Login/Sign Up" />
      </form>

    <?php
    }
    ?>

    <form action="homepage.php" method="GET" id="searchBar" class="searchform">
      <label for="search"> Search:</label>
      <input type="hidden" name="searchSubmit" value="1" />
      <input type="text" id="search" name="search">
      <input type="submit" value="Search" />
    </form>

  </div>
  <br>

  <input id="movieId" type="hidden" value="<?= $movie ?>" />

  <div class="signup-container">

    <section class="first">
      <img id="poster" src="<?php echo $poster; ?>.jpg" alt="movie poster">
      <h2 class="rate"> <?= $title ?> </h2>
      <h4 class="center"><?php echo $rateError; ?> </h4>
      <h3> Rating : <?= $rating ?> / 5 </h3>
      <h4> Give your rating out of 5: </h4>
      <p> Use the dropdown below to rate </p>

      <form action='' method="POST">
        <input type="hidden" name="rate" value="1" />
        <input type="hidden" name="movieId" value="<?= $movie ?>" />
        <select name="rating">
          <option value="1"> 1 </option>
          <option value="2"> 2 </option>
          <option value="3"> 3 </option>
          <option value="4"> 4 </option>
          <option value="5" selected> 5 </option>
        </select>
        <input type="submit" name="rateIt" value="Rate" />
      </form>
    </section>

    <section class="second">
      <p> Genre: <?= $genre ?> </p>
      <p> Release Year: <?= $year ?> </p>
      <p> Cast: <?= $cast ?> </p>
      <p> Origin: <?= $origin ?> </p>
      <p> Director: <?= $director ?></p>
      <p> <a href="<?= $link ?>"> Wikipedia link </a> for movie </p>
    </section>

    <section id="third" class="third">
      <h4 id="confirm_msg" class="center"><?php echo $confirm; ?> </h4>


      <button type="button" id="populateWatchlists" class="watchlistbutton"> Add to Watchlist </button>

    </section>

  </div>
  <script type="text/javascript" src="events-r.js"></script>
</body>

</html>