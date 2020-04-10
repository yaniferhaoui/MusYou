<?php

  session_start();

  require("./connectDB.php");

  function clean_input($data) {
      $data = trim($data);
      $data = stripslashes($data);
      $data = htmlspecialchars($data);
      return $data;
  }

  $idMus= clean_input($_POST["idMusic"]);
  $idMem= clean_input($_POST["idMember"]);

  // Vérification de l'zxistence de la musique
  $req = $bdd -> prepare("SELECT * FROM MUSIC WHERE URLlink =:param");
  $req -> bindParam(":param", $url);
  $req -> execute();
  $count = $req->rowCount();

    try{
      // suppression dela musique dans la table AJOUTE_MUSIC
      $requete1 = "delete from AJOUTE_MUSIC where idMusic=:idMus and idMember=:idMem";
      $smtp1 = $bdd -> prepare($requete1);
      $smtp1->bindParam(":idMus", $idMus);
      $smtp1->bindParam(":idMem", $idMem);
      $smtp1->execute();
      // Suppression de la musique dans la table MUSIC
      $requete2 = "delete from MUSIC where idMusic=:idMus";
      $smtp2 = $bdd -> prepare($requete2);
      $smtp2->bindParam(":idMus", $idMus);
      $smtp2->execute();
    }
    catch(Exception $e){
        die("Erreur : Inscription du client dans la BDD\n" . $e -> getMessage());
    }

  header("Location: ../user_music.php");

?>
