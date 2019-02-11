<?php session_start() ?><!doctype html>
<html lang="fr">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <!--css-->
  <link rel="stylesheet" type="text/css" href="home_admin.css">

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

  <!-- FontAwesome CSS -->
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.2/css/all.css" integrity="sha384-/rXc/GQVaYpyDdyxK+ecHPVYJSN9bmVFBvjA/9eOB+pb3F2w2N6fc5qB9Ew5yIns" crossorigin="anonymous">
  <!-- jQuery -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

  <title>[Code Academie] Promo #3 - Quiz</title>
</head>

<body>
  <section>
    <header>
      <div class="banner">
        <span class="code_ac">
          <img src="./assets/images/Logo-code-academie.jpg" alt="Logo de la Code Académie" style="width:30%;">
        </span>
        <span class="face">
          <img src="./assets/images/RENNES_PNG.png" alt="Logo de FACE Rennes" style="width:35%;">
        </span>
      </div>
    </header>
  </section>
  <?php
  require_once 'database.php';
  if(!$_SESSION['Loger']){
    header('location:index.php');
  }
  ?>
  <!-- <div class= 'container'>
    <h3>bienvenue <?= $_SESSION['Loger']?></h3>
    <a href="Admin/deconnexion.php" class='btn btn-info' role='button'>Déconnexion</a>
  </div> -->
  <section class="page">
    <nav role="navigation">
            <div id="menuToggle">
              <input type="checkbox"/>
              <span></span>
                <span></span>
                <span></span>
                  <ul id="menu">
                    <a href="#"><li><?= $_SESSION['Loger']?></li></a>
                    <a href="#"><li>Accueil</li></a>
                    <a href="#"><li>Mon compte</li></a>
                    <a href="Admin/deconnexion.php"><li>Déconnexion</li></a>
                  </ul>
            </div>
    </nav>
    <div class="bienvenue">
      <p>Bienvenue <?= $_SESSION['Loger']?> !</p>
    </div>
    <div class="row">
      <span>
        <button>Mes quiz</button>
        <img src="./assets/images/test-quiz.svg">
      </span>
      <span>
        <button>Mon compte</button>
        <img src="./assets/images/user.svg">
      </span>
      <span>
        <button>Utilisateurs</button>
        <img src="./assets/images/multiple-users.svg">
      </span>
    </div>    
  </section>
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
</body>

</html>
