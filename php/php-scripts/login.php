<?php
    session_start();

    require("./connectDB.php");

    function clean_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    $pseudo = clean_input($_POST["pseudoMember"]);
    $pass = clean_input($_POST["passwordMember"]);
    $sha1 = sha1($pass);

    $redirect= "../home.php";

    $requete = "SELECT pseudoMember, passwordMember, idMember FROM MEMBER where pseudoMember=:pseudoMember and passwordMember=:passwordMember";
    $smtp = $bdd -> prepare($requete);
    $smtp -> bindParam(":pseudoMember", $pseudo);
    $smtp -> bindParam(":passwordMember", $sha1);
    $smtp -> execute();
    $res = $smtp->fetch();

    if($res){
      $_SESSION['pseudoMember'] = $pseudo;
      $_SESSION['idMember'] = $res["idMember"];
    } else {
        $redirect = "../../index.php?error=True";
    }

    header("Location: $redirect");

?>
