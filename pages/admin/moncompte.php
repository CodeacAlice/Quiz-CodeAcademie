<?php session_start(); $path = "../.."; ?><!doctype html>
<html lang="fr">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- CSS -->
  <link rel="stylesheet" type="text/css" href="../../assets/css/stylesheet.css">

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

  <!-- FontAwesome CSS -->
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.2/css/all.css" integrity="sha384-/rXc/GQVaYpyDdyxK+ecHPVYJSN9bmVFBvjA/9eOB+pb3F2w2N6fc5qB9Ew5yIns" crossorigin="anonymous">
  <!-- jQuery -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

  <title>[Code Academie] Promo #3 - Mon Compte</title>

</head>

<body>
  <?php
  require_once '../../database.php';
  if(!isset($_SESSION['Admin'])){
    header('location:../deconnexion.php');
  }
  else {
  ?>


  <?php
  // Code pour modifier les infos
  if (isset($_POST['update']) && $_POST['update'] == 'Modifier') {
    $oldpwd = str_replace("'", "\'", $_POST['oldpwd']);
    $sth = $bdd->prepare("SELECT * FROM users WHERE idusers = '".$_SESSION['iduser']."'");
    $sth->execute();
    $result = $sth->fetch(PDO::FETCH_ASSOC);
    if ($oldpwd == $result['password']) {
      $nom = str_replace("'", "\'", $_POST['nom']);
      $prenom = str_replace("'", "\'", $_POST['prenom']);
      $newpwd = str_replace("'", "\'", $_POST['newpwd']);

      if ($newpwd == '') {
        $upd = $bdd->prepare("UPDATE users SET nom = '".$nom."', prenom = '".$prenom."' WHERE idusers = '".$_SESSION['iduser']."'");
        $upd->execute();
      }
      else {
        $upd = $bdd->prepare("UPDATE users SET nom = '".$nom."', prenom = '".$prenom."', password = '".$newpwd."' WHERE idusers = '".$_SESSION['iduser']."'");
        $upd->execute();
      }
    }
  }
  ?>


  <?php include($path."/assets/views/header.php"); ?>

  <h2>Mon compte</h2>
  <a href="homepage.php" class="btn btn-info">Retour à l'accueil</a>
  <?php
    $sth = $bdd->prepare("SELECT * FROM users WHERE idusers = '".$_SESSION['iduser']."'");
    $sth->execute();
    $result = $sth->fetch(PDO::FETCH_ASSOC);
  ?>
  <p>Nom : <?= $result['nom']?></p>
  <p>Prénom : <?= $result['prenom']?></p>
  <p>Email : <?= $result['mail']?></p>

  <button class="btn btn-info" data-toggle="modal" data-target="#modalModif">Modifier mes informations</button>

  <!-- Modal pour modifier les infos -->
  <div class="modal fade" id="modalModif" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <div class="modal-title" id="exampleModalLabel"><b>Modifier mes informations</b></div>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body" id="modifInfos">
          <form action="moncompte.php" method="post">
            <p>Nom : <input type="text" name="nom" required maxlength="50" value="<?= $result['nom']?>"></p>
            <p>Prénom : <input type="text" name="prenom" required maxlength="50" value="<?= $result['prenom']?>"></p>
            <p>Ancien mot de passe (obligatoire) : <input type="password" name="oldpwd" required maxlength="100"></p>
            <p>Nouveau mot de passe (non obligatoire) : <input type="password" name="newpwd" maxlength="100"></p>
            <input type="submit" name="update" value="Modifier" class="btn btn-info">
          </form>
        </div>
      </div>
    </div>
  </div>



  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
  <?php } ?>
</body>
</html>