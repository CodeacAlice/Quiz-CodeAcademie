<?php

include 'infosconnect.php';


try

{

    // On se connecte à MySQL

    $bdd  = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);

}

catch(Exception $e)

{

    // En cas d'erreur, on affiche un message et on arrête tout

        die('Erreur : '.$e->getMessage());

}


 ?>
