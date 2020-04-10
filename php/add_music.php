<?php

session_start();
if(!isset($_SESSION['idMember'])) header("Location: ../index.php");
if(!isset($_GET['inBD'])) header("Location: ../index.php");

$_SESSION['pseudoMember'];

?>
<!DOCTYPE html>
<html lang="fr" dir="ltr">
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat:400,700"/>
    <link rel="stylesheet" href="../css/add_music.css">
    <title>MusYou : Add Music</title>
  </head>
  <body>

    <div id="head">
      <form id="register" method="get" action="search.php">
        <input type="text" maxlength="30" placeholder="Search" name="search"/>
        <input id="enter" type="submit" name="valid_search" hidden>
      </form>
      <a id="Back" href="user_music.php">Back</a>
      <h1>Adding a Music</h1>
    </div>

    <div id="new-mus">
      <?php
      if($_GET['inBD']=="True") {
          echo "<h2>This Music is already in the data base !</h2>";
      }

      ?>
      <form id="mus-info" method="post" action="./php-scripts/add.php">

        <input type="url" maxlength="128" placeholder="URL of the Youtube video" name="url" required/>
        <input type="text" maxlength="64" placeholder="Title" name="title" required/>
        <input type="text" placeholder="Artist" name="artist" required/>

        <input id="enter" type="submit" name="enter" value="Add music">

      </form>
    </div>

  </body>
</html>
