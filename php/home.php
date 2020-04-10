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
    <title>MusYou : Home</title>
  </head>

  <body>

    <div id="head">
      <form id="register" method="get" action="search.php">
        <input type="text" maxlength="30" placeholder="Search" name="search"/>
        <input type="hidden" name="sort" value="MUSICTITLE"/>
        <input id="enter" type="submit" name="valid_search" hidden>
      </form>
      <a id="dec" href="user_music.php">Your Music</a>
      <a id="dec" href="./php-scripts/deconnect.php">Log Out</a>
      <h1>Hello <?php echo $_SESSION['pseudoMember'];?></h1>
    </div>



    <div id="mus">

      <div id="sec-head">
        <h2>Last musics of the community</h2>
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

            $redirect= "home.php";

            $requete = "SELECT musicTitle, URLlink, artist FROM MUSIC order by dateAdded DESC";
            $smtp = $bdd -> prepare($requete);
            $smtp -> execute();
            $res = $smtp->fetchAll();

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
                $ib++;
              }

              echo "<a class='mus' target='_blank' style='background-image: url(\"https://img.youtube.com/vi/".$tag."/0.jpg\");' href=".$elem["URLlink"].">
                <p>".$elem["musicTitle"]." - ".$elem["artist"]."</p>
              </a>";
            }
        ?>

      </div>

    </div>



  </body>

</html>
