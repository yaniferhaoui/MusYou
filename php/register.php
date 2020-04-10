<?php
session_start();
if(isset($_SESSION['idMember'])) header("Location: php/home.php");
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat:400,700"/>
    <link rel="stylesheet" href="../css/register.css">
    <title>MusYou : Register</title>
  </head>
  <body>

    <h1>Welcome on MusYou</h1>
    <h2>A place to share the music tou love<h2>

      <?php
      if(isset($_GET['error'])) {
          echo "<h2 id='error'>This pseudo or email is already in the data base !</h2>";
      }

      ?>

    <form id="register" method="post" action="./php-scripts/regist.php">
      <input type="email" maxlength="128" placeholder="E-Mail" name="emailAddressMember" required/>
      <input type="text" maxlength="32" placeholder="First Name" name="firstNameMember" required/>
      <input type="text" maxlength="32" placeholder="Last Name" name="nameMember" required/>
      <input type="text" maxlength="20" placeholder="Pseudonym" name="pseudoMember" required/>
      <input type="password" placeholder="Password" name="passwordMember" required/>
      <input type="password" placeholder="Confirm Password" name="passwordMemberConf" required/>
      <input id="enter" type="submit" name="enter" value="Sign up">
    </form>

  </body>
</html>
