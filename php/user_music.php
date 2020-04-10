<?php

session_start();
if(!isset($_SESSION['idMember'])) header("Location: ../index.php");

$_SESSION['pseudoMember'];

?>
<!DOCTYPE html>
<html lang="fr" dir="ltr">
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat:400,700"/>
    <link rel="stylesheet" href="../css/home.css">
    <title>MusYou : Your Music</title>
  </head>

  <body>

    <div id="head">
      <form id="register" method="get" action="search.php">
        <input type="text" maxlength="30" placeholder="Search" name="search"/>
        <input type="hidden" name="sort" value="MUSICTITLE"/>
        <input id="enter" type="submit" name="valid_search" hidden>
      </form>
      <a id="dec" href="./add_music.php?inBD=False">Add Music</a>
      <a id="dec" href="./home.php">Home</a>
      <h1>Your Music</h1>
    </div>



    <div id="mus">

      <div id="sec-head">
        <h2>Music you added</h2>
      </div>

      <div id="lst-mus">

        <?php
            require("./php-scripts/connectDB.php");

            function clean_input($data) {
                $data = trim($data);
                $data = stripslashes($data);
                $data = htmlspecialchars($data);
                return $data;
            }

            $redirect= "./home.php";

            $requete = "SELECT idMusic, musicTitle, URLlink, artist
            FROM MUSIC
            where idMusic in (
              select idMusic
              from AJOUTE_MUSIC
              where idMember = :idMember
            ) order by dateAdded DESC";

            $smtp = $bdd -> prepare($requete);
            $smtp -> bindParam(":idMember", $_SESSION['idMember']);
            $smtp -> execute();
            $res = $smtp->fetchAll();
            $i=0;

            foreach($res as $elem){

              $tag = "";
              $bool=1;
              $ib=0;
              while($ib < strlen($elem["URLlink"])) {
                if ($bool==0){
                  $tag.=$elem["URLlink"][$ib];
                }
                if ($elem["URLlink"][$ib]=="="){
                  $bool=0;
                }
                $i++;
                $ib++;
              }

              echo "<a class='mus' target='_blank' style='background-image: url(\"https://img.youtube.com/vi/".$tag."/0.jpg\");' href=".$elem["URLlink"].">
                <p>".$elem["musicTitle"]." - ".$elem["artist"]."</p>

                <form class='supr' action='./php-scripts/delete.php' method='post'>
                  <input type='text' hidden value=".$elem['idMusic']." name='idMusic'/>
                  <input type='text' hidden value=".$_SESSION['idMember']." name='idMember'/>
                  <input type='submit' class='del-but' value=''/>
                </form>

              </a>";
            }

            if($i==0) {
              echo "<h2 id='noMus'>You haven't added any Music</h2>";
            }
        ?>

      </div>

    </div>



  </body>

</html>
