<?php
    try{
        $hostname = "localhost";
        $dbname = "DBferhaoui_test";
        $charset = "utf8";
        $user = "yani-test";
        $password = "ferhaoui-test";
        $bdd = new PDO("mysql:host=$hostname; dbname=$dbname; charset=$charset", $user, $password, array(PDO::ATTR_PERSISTENT => true));
    }
    catch(Exception $e){
       echo $e->getMessage();
    }

?>
