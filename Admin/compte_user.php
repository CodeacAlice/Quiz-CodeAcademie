<?php session_start() ?><!doctype html>
<html lang="fr">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

  <!-- FontAwesome CSS -->
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.2/css/all.css" integrity="sha384-/rXc/GQVaYpyDdyxK+ecHPVYJSN9bmVFBvjA/9eOB+pb3F2w2N6fc5qB9Ew5yIns" crossorigin="anonymous">
  <!-- jQuery -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

  <title>[Code Academie] Promo #3 - Compte utilisateur</title>

</head>

<body>
  <?php
  require_once '../database.php';
  if(!$_SESSION['Admin']){
    header('location: ../index.php');
  }
  ?>


  <?php
  // Code pour afficher les informations et remplir la modal de modification
    $sth = $bdd->prepare("SELECT * FROM users WHERE idusers = '".$_GET['user']."'");
    $sth->execute();
    $result = $sth->fetch(PDO::FETCH_ASSOC);
    if ($result['QPV'] == 1) {
      $qpv = 'Oui';
      $inputqpv = '<input type="radio" name="qpv" value="1" checked>Oui   <input type="radio" name="qpv" value="0">Non';
    } 
    else {
      $qpv = 'Non';
      $inputqpv = '<input type="radio" name="qpv" value="1">Oui   <input type="radio" name="qpv" value="0" checked>Non';
    }
    if ($result['RQTH'] == 1) {
      $rqth = 'Oui';
      $inputrqth = '<input type="radio" name="rqth" value="1" checked>Oui   <input type="radio" name="rqth" value="0">Non';
    } 
    else {
      $rqth = 'Non';
      $inputrqth = '<input type="radio" name="rqth" value="1">Oui   <input type="radio" name="rqth" value="0" checked>Non';
    }
    if ($result['actif'] == 1) {
      $actif = 'Oui';
      $inputactif = '<input type="radio" name="actif" value="1" checked>Oui   <input type="radio" name="actif" value="0">Non';
    } 
    else {
      $actif = 'Non';
      $inputactif = '<input type="radio" name="actif" value="1">Oui   <input type="radio" name="actif" value="0" checked>Non';
    }
    if ($result['tiers_temps'] == 1) {
      $tierst = 'Oui';
      $inputtiers = '<input type="radio" name="tierstps" value="1" checked>Oui   <input type="radio" name="tierstps" value="0">Non';
    } 
    else {
      $tierst = 'Non';
      $inputtiers = '<input type="radio" name="tierstps" value="1">Oui   <input type="radio" name="tierstps" value="0" checked>Non';
    }

    if ($result['genre'] == 'homme') {
      $inputgenre = '<input type="radio" name="genre" required value="homme" checked>Homme   <input type="radio" name="genre" required value="femme">Femme   <input type="radio" name="genre" required value="autre">Autre';
    }
    else if ($result['genre'] == 'femme') {
      $inputgenre = '<input type="radio" name="genre" required value="homme">Homme   <input type="radio" name="genre" required value="femme" checked>Femme   <input type="radio" name="genre" required value="autre">Autre';
    }
    else {
      $inputgenre = '<input type="radio" name="genre" required value="homme">Homme   <input type="radio" name="genre" required value="femme">Femme   <input type="radio" name="genre" required value="autre" checked>Autre';
    }
  ?>
  <h2>Informations de l'utilisateur <?= $result['prenom']?> <?= $result['nom']?></h2>
  <a href="users.php" class="btn btn-info">Retour à la liste</a>
  <p>Nom : <?= $result['nom']?></p>
  <p>Prénom : <?= $result['prenom']?></p>
  <p>Genre : <?= ucfirst($result['genre'])?></p>
  <p>Email : <?= $result['mail']?></p>
  <p>QPV : <?= $qpv?></p>
  <p>RQTH : <?= $rqth?></p>
  <p>Actif : <?= $actif?></p>
  <p>Tiers-temps : <?= $tierst?></p>



  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>

</body>
</html>