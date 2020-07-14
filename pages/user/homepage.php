<?php session_start(); $path = "../.."; ?><!doctype html>
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

  <title>[Code Academie] Promo #3 - Accueil</title>

  <!--css-->
  <link rel="stylesheet" type="text/css" href="../../assets/css/stylesheet.css">
  <link rel="stylesheet" type="text/css" href="../../assets/css/homepage.css">

</head>

<body>
  <?php
  require_once '../../database.php';
  if(!isset($_SESSION['Loger'])){
    header('location:../deconnexion.php');
  }
  else {
    ?>
  
    
    <?php include($path."/assets/views/header.php"); ?>

      <div class="conteneur">
        <h1>Bienvenue <?= $_SESSION['Loger']?> !</h1>
      
        <div class="container-fluid">
          <div class="row">
            <div class="liens col-sm-6">
              <a href="mesquiz.php">Mes quiz</a>
              <?php include($path."/assets/images/test-quiz.svg"); ?>
            </div>
            <div class="liens col-sm-6">
              <a href="moncompte.php">Mon compte</a>
              <?php include($path."/assets/images/user.svg"); ?>
            </div>
          </div>
        </div>
      </div>

    <?php include($path."/assets/views/footer.php"); ?>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
  <?php } ?>
  </body>

  </html>
