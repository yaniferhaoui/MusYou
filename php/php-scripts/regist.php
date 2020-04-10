<?php

    require("./connectDB.php");

    function clean_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }


    $pseudoMember= clean_input($_POST["pseudoMember"]);
    $firstNameMember= clean_input($_POST["firstNameMember"]);
    $nameMember= clean_input($_POST["nameMember"]);
    $emailAddressMember = clean_input($_POST["emailAddressMember"]);
    $passwordMember = clean_input($_POST["passwordMember"]);
    $passwordMemberConf = clean_input($_POST["passwordMemberConf"]);


    // check attribut
    $redirect= "../home.php";
    if(!empty($firstNameMember) && !empty($nameMember) && !empty($emailAddressMember) && !empty($pseudoMember) && !empty($passwordMember) && !empty($passwordMemberConf)){
        preg_match("/[^\W][a-zA-Z0-9_]+(\.[a-zA-Z0-9_]+)*\@[a-zA-Z0-9_]+(\.[a-zA-Z0-9_]+)*\.[a-zA-Z]{2,4}/i", $emailAddressMember, $preg_emailAddressMember);
        preg_match("/[0-9A-Za-zàçéèêëîïôöûüù._-]{1,50}/i", $pseudoMember, $preg_pseudoMember);
        preg_match("/[0-9A-Za-zàçéèêëîïôöûüù]{1,50}/i", $firstNameMember, $preg_firstNameMember);
        preg_match("/[0-9A-Za-zàçéèêëîïôöûüù]{1,50}/i", $nameMember, $preg_nameMember);
        preg_match("/$passwordMember/", $passwordMemberConf, $preg_passwordMember);
        $form = [
            [$pseudoMember, $preg_pseudoMember],
            [$firstNameMember, $preg_firstNameMember],
            [$emailAddressMember, $preg_emailAddressMember],
            [$nameMember, $preg_nameMember],
            [$passwordMember, $preg_passwordMember]
        ];
        foreach($form as $_ => $tab){
            if(sizeof($tab[1]) != 1 || $tab[0] != $tab[1][0]){
                $redirect= "../../index.php";
                break;
            }
        }
    }
    else {
        $redirect= "../register.php";
    }

    // Vérification de la non existance
    $req1 = $bdd -> prepare("SELECT * FROM MEMBER WHERE pseudoMember =:pseudo");
    $req1 -> bindParam(":pseudo", $pseudoMember);
    $req1 -> execute();
    $count = $req1->rowCount();
    $req2 = $bdd -> prepare("SELECT * FROM MEMBER WHERE emailAddressMember =:mail");
    $req2-> bindParam(":mail", $emailAddressMember);
    $req2 -> execute();
    $count2 = $req2->rowCount();

    if($count == 0 && $count2 == 0) {

      if($redirect!= "../register.php") {
        $query = "SELECT max(idMember) as nbid FROM MEMBER";
        $smtp = $bdd -> prepare($query);
        $smtp->execute();
        $res = $smtp->fetch();
        $result = $res["nbid"]+1;

        $var1 = "1";

          try{
              $sh1 = sha1($passwordMember);
              $requete = "INSERT INTO MEMBER(idMember, firstNameMember, nameMember, emailAddressMember, passwordMember, pseudoMember, rankMember) VALUES(:idMember, :firstNameMember, :nameMember, :emailAddressMember, :passwordMember, :pseudoMember, :rankMember)";
              $smtp = $bdd -> prepare($requete);
              $smtp -> bindParam(":idMember", $result);
              $smtp -> bindParam(":firstNameMember", $firstNameMember);
              $smtp -> bindParam(":nameMember", $nameMember);
              $smtp -> bindParam(":emailAddressMember", $emailAddressMember);
              $smtp -> bindParam(":passwordMember", $sh1);
              $smtp -> bindParam(":pseudoMember", $pseudoMember);
              $smtp -> bindParam(":rankMember", $var1);
              $smtp -> execute();
          }catch(Exception $e){
             echo $e->getMessage();
          }
          header("Location: ../../index.php");
        }
    } else {
      header("Location: ../register.php?error=True");
    }

?>
