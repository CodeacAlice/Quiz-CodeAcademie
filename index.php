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

  <title>[Code Academie] Promo #3 - Quiz - Connection</title>
  <link rel="stylesheet" type="text/css" href="./assets/css/base.css">
</head>

<body>
  <?php
  require_once 'database.php';
  ?>

  <?php
    if (isset($_POST) AND !empty($_POST)){
      if (!empty(htmlspecialchars($_POST['username'])) AND !empty(htmlspecialchars ($_POST['password']))){
        $req = $bdd->prepare('SELECT * FROM users WHERE mail = :username AND password = :password');
        $req->execute([
          'username' => $_POST['username'],
          'password' => $_POST['password']
        ]);
        $user = $req->fetch();
        if($user){
          $_SESSION['iduser'] = $user['idusers'];

          if($user['is_admin']==0){
            $_SESSION['Loger'] = $user['prenom'] . " " . $user['nom'];
            header('location:pages/user/homepage.php');

          }
          elseif($user['is_admin']==1){
            $_SESSION['Admin'] = $user['prenom'] . " " . $user['nom'];
            header('location:pages/admin/homepage_admin.php');
          }

        }
        else{
          $error = 'identifiants incorrects.';
        }
      }
      if(isset($error)){
        echo '<div>
        '.$error.'
        </div>';
      }
      else {
        $error = 'Veuillez remplir tout les champs.';
      }
    }
    ?>


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

  <section class="page">
    <div class="bienvenue">
      <p>Bienvenue aux quiz de la prochaine<br>session de la Code Académie</p>
      <div>
        <form class="formulaires" action='index.php' method='POST'>
          <input type="text" name='username' placeholder="mail"><br>
          <input type="password" name="password" placeholder="mot de passe"><br>
          <button>Connexion</button>
        </form>
      </div>      
      
    </div>
  </section>


 <script type="text/javascript" src="script.js"></script>
 <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
 <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
 <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
</body>

</html>
