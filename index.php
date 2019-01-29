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

        <title>[Code Academie] Promo #3 - Trombinoscope</title>
    </head>

    <body>
      <?php
      require_once 'database.php';
      if(!$_SESSION['Loger']){
        header('location:log.php');
      }
       ?>
        <header class="">
            <nav class="navbar navbar-light">
                <a class="navbar-brand" href="#">
                    <img src="../images/logo-codeacademie.png" height="60" class="d-inline-block align-middle mr-4" alt="">
                    <span class="h3 align-middle">Promo #3</span>
                </a>
                <pre class="d-inline-block align-middle ml-5 mb-0 lead">&lt;limit&gt;&lt;/limit&gt;</pre>
            </nav>
        </header>

        <div class= 'container'>
          <h3>bienvenue <?= $_SESSION['Loger']?></h3>
          <a href="Admin/login.php" class="btn btn-info" role="button">Connexion Admin</a>
          <a href="Admin/deconnexion.php" class='btn btn-info' role='button'>Déconnexion</a>
        </div>
        <div class="container-fluid">
            <div class="row">
                <div class="col-2 bg-dark">
                    <div class="row">
                        <div class="col-12 p-3 d-flex align-items-center justify-content-between">
                            <h4 class="text-light mb-0">Filtres</h4>
                            <a href="#" id="btn-reset" class="btn btn-sm btn-light"><i class="fas fa-undo"></i></a>
                        </div>
                    </div>
                    <p class="text-light border-top pt-2 mb-1">Genre :</p>
                    <a href="#" id="btn-toggle-masculin" class="btn btn-light btn-sm">Masculin</a>
                    <a href="#" id="btn-toggle-feminin" class="btn btn-light btn-sm">Féminin</a>
                </div>
                <div class="col-10">
                    <div class="row">
                        <div class="col-12 bg-info text-light p-3">
                            <h4 class="m-0">Nombre d'apprenants concernés : <span id="studentsConcernedNumber" class="font-weight-bold"></span></h4>
                        </div>
                    </div>
                    <div id="students" class="row py-3">

                        <?php  include 'construct.php'; ?>

                    </div>

                      <?php  include 'modal.php'; ?>


                </div>
            </div>
        </div>
        <script type="text/javascript" src="script.js"></script>
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
    </body>

</html>
