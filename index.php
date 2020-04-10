<?php
session_start();
if(isset($_SESSION['idMember'])) header("Location: php/home.php");
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat:400,700"/>
    <link rel="stylesheet" href="css/index.css"/>
    <title>MusYou</title>
  </head>
  <body>

    <h1>The Music You Love</h1>

    <?php
    if(isset($_GET['error'])) {
        echo "<h2 id='error'>Error in pseudo or password !</h2>";
    }

    ?>

    <form id="login" method="post" action="./php/php-scripts/login.php">
      <input type="text" maxlength="20" placeholder="Pseudonym" name="pseudoMember" required/>
      <input type="password" placeholder="Password" name="passwordMember" required/>
      <input id="enter" type="submit" name="enter" value="Log In">
      <a href="./php/register.php">Sign Up</a>
    </form>

  </body>
</html>
