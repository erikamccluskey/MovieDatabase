<?php

if (isset($_POST["loginSubmit"]) && $_POST["loginSubmit"]) {
  $myusername = trim($_POST["email"]);
  $mypassword = trim($_POST["pswd"]);


  if (strlen($mypassword) > 0 && strlen($mypassword) > 0) {
    $db = new mysqli("", "", "", "");

    if ($db->connect_error) {
      die("Connection failed: " . $db->connect_error);
    }

    $q = "SELECT uid, fname FROM Users WHERE email='$myusername' and password='$mypassword';";
    $result = $db->query($q);

    if ($row = $result->fetch_assoc()) {
      session_start();
      $_SESSION["uid"] = $row["uid"];
      $_SESSION["fname"] = $row["fname"];

      $q = "UPDATE Users SET isLoggedin=1 WHERE email='$myusername' and password='$mypassword';";
      $result = $db->query($q);

      header("location: homepage.php");
      $db->close();
      exit();
    } else {
      $error1 = "Username/password combination is incorrect.";
      $db->close();
    }
  } else {
    $error1 = "Invalid data";
  }
} else if (isset($_POST["signupSubmit"]) && $_POST["signupSubmit"]) {

  $fname = trim($_POST["fname"]);
  $lname = trim($_POST["lname"]);
  $username = trim($_POST["username"]);
  $email = trim($_POST["emailS"]);
  $password = trim($_POST["password"]);
  $passwordC = trim($_POST["passwordC"]);
  $avatar = ($_POST["fileToUpload"]);


  $db = new mysqli("", "", "", "");
  if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
  }

  $q = "INSERT INTO Users (username,fname,lname,email,password,avatar) VALUES ('$username', '$fname', '$lname', '$email', '$password','$avatar');";
  $result = $db->query($q);

  if ($result === true) {
    header("location: login.php");
    $db->close();
    exit();
  } else {
    $error2 = "Something went wrong. Try again.";
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


  <div class="signup-container">
    <section class="first">
      <h1 class="center"> Login </h1>
      <p class="err_msg"> <?= $error1 ?> </p>
      <form id="login" class="center" action="login.php" method="post">
        <input type="hidden" name="loginSubmit" value="1" />

        <label for="email">Email:</label><br>
        <input type="text" id="email" name="email"><br>
        <label id="msg_email" class="err_msg"></label><br>

        <label for="pswd">Password:</label><br>
        <input type="password" id="pswd" name="pswd"><br>
        <label id="msg_pswd" class="err_msg"></label><br>


        <input type="submit" value="Login" id="loginButton" class="watchlistbutton" /><br>
      </form>
      <br>
    </section>

    <section class="second">
      <h1 class="center">Sign-up</h1>
      <p class="center">Enter your information below to sign up!</p>

      <p class="err_msg"> <?= $error2 ?> </p>
      <form id="signUp" class="center" action="login.php" method="post">
        <input type="hidden" name="signupSubmit" value="1" />

        <label for="fname">First name:</label><br>
        <input type="text" id="fname" name="fname"><br>
        <label id="msg_fname" class="err_msg"></label><br>

        <label for="lname">Last name:</label><br>
        <input type="text" id="lname" name="lname"> <br>
        <label id="msg_lname" class="err_msg"></label><br>

        <label for="emailS">Email:</label><br>
        <input type="text" id="emailS" name="emailS"><br>
        <label id="msg_emailS" class="err_msg"></label><br>

        <label for="username">Username:</label><br>
        <input type="text" id="username" name="username"><br>
        <label id="msg_username" class="err_msg"></label><br>

        <label for="password">Password:</label><br>
        <input type="password" id="password" name="password"><br>
        <label id="msg_password" class="err_msg"></label><br>

        <label for="passwordC">Confirm Password:</label><br>
        <input type="password" id="passwordC" name="passwordC"><br>
        <label id="msg_passwordC" class="err_msg"></label><br>

        <label for="fileToUpload">Please upload your desired avatar: </label><br>
        <input type="file" name="fileToUpload" id="fileToUpload"><br>
        <label id="msg_avatar" class="err_msg"></label><br>

        <input type="submit" value="Sign Up" id="signUpButton" class="watchlistbutton"><br>
      </form>

    </section>

    <section class="third">
      <h2 class="center"> Don't want to sign up? </h2>
      <button class="watchlistbutton"> <a href=homepage.php> Continue as guest </a></button>
    </section>

  </div>

  <script type="text/javascript" src="events-r.js"></script>

</body>

</html>