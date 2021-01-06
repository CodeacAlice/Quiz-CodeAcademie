<?php session_start(); $path = "../.."; ?><!doctype html>
<html lang="fr">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="../../assets/css/bootstrap.min.css">

  <!-- FontAwesome CSS -->
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.2/css/all.css" integrity="sha384-/rXc/GQVaYpyDdyxK+ecHPVYJSN9bmVFBvjA/9eOB+pb3F2w2N6fc5qB9Ew5yIns" crossorigin="anonymous">
  <!-- jQuery -->
  <script src="../../assets/js/jquery.js"></script>

  <title>[Code Academie] Promo #3 - Accueil</title>

  <!-- CSS -->
  
  <link rel="stylesheet" type="text/css" href="../../assets/css/stylesheet.css">
  <link rel="stylesheet" type="text/css" href="../../assets/css/homepage.css">
</head>

<body>
  <?php
  require_once '../../database.php';
  if(!isset($_SESSION['Admin'])){
    header('location:../deconnexion.php');
  }
  else {
  ?>


  <?php include($path."/assets/views/header.php"); ?>

    
    <div class="conteneur">
      <h1>Bienvenue Maître <?= $_SESSION['Admin']?> !</h1>
    
      <div class="container-fluid">
        <div class="row">
          <div class="liens col-sm-4">
            <a href="mesquiz.php" >Quiz</a>
            <?php include($path."/assets/img/test-quiz.svg"); ?>
          </div>
          <div class="liens col-sm-4">
            <a href="moncompte.php">Mon compte</a>
            <?php include($path."/assets/img/user.svg"); ?>
          </div>
          <div class="liens col-sm-4">
            <a href="users.php">Utilisateurs</a>
            <?php include($path."/assets/img/multiple-users.svg"); ?>
          </div>
        </div>
      </div>
    </div>


  <?php include($path."/assets/views/footer.php"); ?>


  <script src="../../assets/js/popper.min.js" ></script>
  <script src="../../assets/js/bootstrap.min.js"></script>
<?php }?>
</body>

</html>
