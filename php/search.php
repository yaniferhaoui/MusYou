<?php

session_start();
if(!isset($_SESSION['idMember'])) header("Location: ../index.php");


$sort;
if(isset($_GET['sort'])) {
    $sort = $_GET['sort'];
} else {
    $sort = "MUSICTITLE";
}
if (!isset($_GET['search']) || $_GET['search']=="" || $_GET['search']==null) {
    header("Location: ../index.php");
}

$_SESSION['pseudoMember'];

?>
<!DOCTYPE html>
<html lang="fr" dir="ltr">
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat:400,700"/>
    <link rel="stylesheet" href="../css/home.css">
    <title>MusYou : Search Result</title>
  </head>

  <body>

    <div id="head">

      <form id="register" method="get">
        <input type="text" maxlength="30" placeholder="Search" name="search" value="<?php echo $_GET['search'] ?>"/>
        <input type="hidden" name="sort" value="<?php echo $sort ?>"/>
        <input id="enter" type="submit" name="valid_search" hidden>
      </form>

      <a id="add-mus" href="user_music.php">Your Music</a>
      <a id="home" href="home.php">Home</a>
      <h1>Search Result for : <?php echo $_GET['search'] ?></h1>

    </div>

    <div id="sort">
      <h2>Search in : </h2>
      <?php

        if($sort=="MUSICTITLE") {
            echo "<a id='selected' href='#'>Music</a>";
            echo "<a href=\"search.php?search=".$_GET['search']."&sort=ARTIST\">Artist</a>";
        } else {
            echo "<a href=\"search.php?search=".$_GET['search']."&sort=MUSICTITLE\">Music</a>";
            echo "<a id='selected' href='#'>Artist</a>";
        }

      ?>
    </div>


    <div id="mus">

      <div id="sec-head">
        <h2></h2>
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

            $musicTitle = clean_input($_GET["search"]);
            $search = "%".$musicTitle."%";

            $requete = "SELECT musicTitle, URLlink, artist FROM MUSIC where ".$sort." LIKE :search order by dateAdded DESC";
            $smtp = $bdd -> prepare($requete);
            $smtp -> bindParam(":search", $search);
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
