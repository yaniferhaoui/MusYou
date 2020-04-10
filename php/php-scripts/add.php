<?php

  session_start();

  require("./connectDB.php");

  function clean_input($data) {
      $data = trim($data);
      $data = stripslashes($data);
      $data = htmlspecialchars($data);
      return $data;
  }


  $url= clean_input($_POST["url"]);
  $title= clean_input($_POST["title"]);
  $artist= clean_input($_POST["artist"]);


  // Vérification des attributs de la musique
  if(!empty($url) && !empty($title) && !empty($artist)){
    $redirect= "../user_music.php";
  }
  else {
      $redirect= "../add_music.php";
  }


  // Vérification de l'zxistence de la musique
  $req = $bdd -> prepare("SELECT * FROM MUSIC WHERE URLlink =:param");
  $req -> bindParam(":param", $url);
  $req -> execute();
  $count = $req->rowCount();

  if($count == 0) {
    if($redirect!= "../add_music.php"){
      $query = "SELECT max(idMusic) as nbid FROM MUSIC";
      $smtp = $bdd -> prepare($query);
      $smtp->execute();
      $res = $smtp->fetch();
      $result = $res["nbid"]+1;
        try{
          // Insertion dans la table MUSIC
          $requete1 = "INSERT INTO MUSIC(idMusic, musicTitle, artist, URLlink, dateAdded) VALUES(:idMusic, :musicTitle, :artist, :URLlink, NOW())";
          $smtp1 = $bdd -> prepare($requete1);
          $smtp1 -> bindParam(":idMusic", $result);
          $smtp1 -> bindParam(":musicTitle", $title);
          $smtp1 -> bindParam(":artist", $artist);
          $smtp1 -> bindParam(":URLlink", $url);
          $smtp1 -> execute();
          // Inserttion dans la table AJOUTE_MUSIC
          $requete2 = "INSERT INTO AJOUTE_MUSIC(idMember, idMusic, dateAdd) VALUES(:idMember, :idMusic, NOW())";
          $smtp2 = $bdd -> prepare($requete2);
          $smtp2 -> bindParam(":idMember", $_SESSION['idMember']);
          $smtp2 -> bindParam(":idMusic", $result);
          $smtp2 -> execute();
        }
        catch(Exception $e){
            die("Erreur : Inscription du client dans la BDD\n" . $e -> getMessage());
        }
    }
  } else {
    $redirect = "../add_music.php?inBD=True";
  }

  header("Location: $redirect");

?>
