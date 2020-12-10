<?php
session_start();

$notLoggedIn = '0';

if (isset($_SESSION["uid"])) {
  $uid = $_SESSION["uid"];
  $fname = $_SESSION["fname"];
} else {
  $notLoggedIn = '1';
} {
  $db = new mysqli("", "", "", "");

  if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
  }


  if (isset($_POST["logoutValue"]) && $_POST["logoutValue"]) {
    if (isset($_SESSION["uid"])) {
      $logoutQuery = "UPDATE Users SET isLoggedin=0 WHERE uid='$uid';";
      $db->query($logoutQuery);

      $_SESSION = array();
      session_destroy();

      header("Location: login.php");
      exit();
    }
  }

  $q =
    "SELECT Movies.title, Movies.mid, Movies.poster, AVG(rating) as average
    FROM Movies LEFT JOIN Ratings
    ON Ratings.mid = Movies.mid 
    GROUP BY Movies.title, Movies.mid, Movies.poster
    ORDER BY average DESC LIMIT 15;";


  $result = $db->query($q);
}

if (isset($_GET["sortSubmit"]) && $_GET["sortSubmit"]) {
  if ($_GET["ratingdropdown"] == 'title') {

    $q = "SELECT Movies.title, Movies.mid, Movies.poster, AVG(rating) as average
  FROM Movies LEFT JOIN Ratings
  ON Ratings.mid = Movies.mid 
  GROUP BY Movies.title, Movies.mid, Movies.poster
  ORDER BY Movies.title ASC LIMIT 15;";

    $result = $db->query($q);
  } else if ($_GET["ratingdropdown"] == 'ratingHL') {
    $q = "SELECT Movies.title, Movies.mid, Movies.poster, AVG(rating) as average
  FROM Movies LEFT JOIN Ratings
  ON Ratings.mid = Movies.mid 
  GROUP BY Movies.title, Movies.mid, Movies.poster
  ORDER BY average DESC LIMIT 15;";

    $result = $db->query($q);
  } else if ($_GET["ratingdropdown"] == 'ratingLH') {
    $q = "SELECT Movies.title, Movies.mid, Movies.poster, AVG(rating) as average
  FROM Movies LEFT JOIN Ratings
  ON Ratings.mid = Movies.mid 
  GROUP BY Movies.title, Movies.mid, Movies.poster
  ORDER BY average ASC LIMIT 15;";

    $result = $db->query($q);
  } else if ($_GET["ratingdropdown"] == 'releaseyear') {
    $q = "SELECT Movies.title, Movies.mid, Movies.poster, AVG(rating) as average
  FROM Movies LEFT JOIN Ratings
  ON Ratings.mid = Movies.mid 
  GROUP BY Movies.title, Movies.mid, Movies.poster
  ORDER BY Movies.year DESC LIMIT 15;";

    $result = $db->query($q);
  }
}

if (isset($_GET["originsSubmit"]) && $_GET["originsSubmit"]) {

  $origin = $_GET["Origins"];

  $q = "SELECT Movies.title, Movies.mid, Movies.poster, AVG(rating) as average
  FROM Movies LEFT JOIN Ratings
  ON Ratings.mid = Movies.mid 
  WHERE Movies.origin = '$origin'
  GROUP BY Movies.title, Movies.mid, Movies.poster
  ORDER BY average DESC LIMIT 15;";

  $result = $db->query($q);
}

if (isset($_GET["genresSubmit"]) && $_GET["genresSubmit"]) {

  $genre = $_GET["Genres"];

  $q = "SELECT Movies.title, Movies.mid, Movies.poster, AVG(rating) as average
  FROM Movies LEFT JOIN Ratings
  ON Ratings.mid = Movies.mid 
  WHERE Movies.genre = '$genre'
  GROUP BY Movies.title, Movies.mid, Movies.poster
  ORDER BY average DESC LIMIT 15;";

  $result = $db->query($q);
}

if (isset($_GET["searchSubmit"]) && $_GET["searchSubmit"]) {
  $search = $_GET["search"];


  $q = "SELECT Movies.title, Movies.mid, Movies.poster, AVG(rating) as average
  FROM Movies LEFT JOIN Ratings
  ON Ratings.mid = Movies.mid 
  WHERE Movies.title LIKE '%$search%' 
  GROUP BY Movies.title, Movies.mid, Movies.poster
  ORDER BY average DESC LIMIT 15;";

  $result = $db->query($q);

  if ($result->num_rows == 0) {
    $error = "No result matches your search.";
    $db->close();
  } else {
    $error = "";
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

  <div class="signup-container">

    <h3 class="first"> Search by: </h3>
    <section class="second">
      <h3> Origin </h3>
      <form action="homepage.php" method="GET">
        <input type="hidden" name="originsSubmit" value="1" />
        <select name="Origins">
          <option default value="-"> -- </option>
          <option value="American"> American </option>
          <option value="Australian"> Australian </option>
          <option value="Bollywood"> Bollywood </option>
          <option value="British"> British </option>
          <option value="Canadian"> Canadian </option>
          <option value="Chinese"> Chinese </option>
          <option value="Japanese"> Japanese </option>
          <option value="Punjabi"> Punjabi </option>
          <option value="Russian"> Russian </option>
        </select>
        <input type="submit" value="Search" />
      </form>
    </section>

    <section class="third">
      <h3> Genre </h3>
      <form action="homepage.php" method="GET">
        <input type="hidden" name="genresSubmit" value="1" />
        <select name="Genres">
          <option default value="-"> -- </option>
          <option value="action"> action </option>
          <option value="adventure"> adventure </option>
          <option value="biography"> biography </option>
          <option value="comedy"> comedy </option>
          <option value="crime"> crime </option>
          <option value="drama"> drama </option>
          <option value="family"> family </option>
          <option value="fantasy"> fantasy </option>
          <option value="horror"> horror </option>
          <option value="musical"> musical </option>
          <option value="mystery"> mystery </option>
          <option value="patriotic"> patriotic </option>
          <option value="romance"> romance </option>
          <option value="sci-fi"> sci-fi </option>
          <option value="social"> social </option>
          <option value="sports"> sports </option>
          <option value="spy"> spy </option>
          <option value="suspense"> suspense </option>
          <option value="thriller"> thriller </option>
          <option value="war"> war </option>
          <option value="western"> western </option>
          <option value="wuxia"> wuxia </option>
          <option value="zombie"> zombie </option>
        </select>
        <input type="submit" value="Search" />
      </form>
    </section>
  </div>

  <h3> Search Results: </h3>
  <p class="err_msg1"> <?= $error ?> </p>
  <label id="msg_search" class="err_msg1"></label>
  <h4> Sort By : </h4>
  <form action="homepage.php" method="GET">
    <input type="hidden" name="sortSubmit" value="1" />
    <select name="ratingdropdown">
      <option value="ratingHL"> Rating (high to low) </option>
      <option value="ratingLH"> Rating (low to high) </option>
      <option value="title"> Title </option>
      <option value="releaseyear"> Release Year </option>
    </select>
    <input type="submit" value="Sort" />
  </form>

  <div>
    <div id="container" class="container">

      <?php

      while ($row = $result->fetch_assoc()) {
        $title = $row["title"];
        $mid = $row["mid"];
        $poster = $row["poster"];
        $rating = $row["average"];

      ?>

        <section class="item">

          <form onclick="location.href = 'details.php?mid=<?= $mid ?>'" method="GET">
            <input type="hidden" name="mid" value="<?= $mid ?>" />
            <img class="watchlistposter" src="<?php echo $poster; ?>.jpg" alt="<?= $title ?> poster">
          </form>
          <h3 class="center"> <?= $title ?> </h3>
          <h5 class="center"> Rating: <?= $rating ?> / 5 </h5>
        </section>

      <?php
      }
      $db->close();
      ?>

    </div>
  </div>


  <script type="text/javascript" src="events-r.js"></script>
</body>

</html>