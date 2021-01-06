<?php session_start(); $path = '.'; ?><!doctype html>
<html lang="fr">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="assets/css/bootstrap.min.css">

  <!-- jQuery -->
  <script src="assets/js/jquery.js"></script>

  <title>[Code Academie] Promo #3 - Quiz - Connexion</title>

  <!-- CSS -->
  <link rel="stylesheet" type="text/css" href="./assets/css/stylesheet.css">

  <style>
    input {
      border-radius: 10px;
      padding: 10px 75px;
      text-align: center;
      background-color: #EEEEEE;
    }
  </style>
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
          $name = $user['prenom'] . " " . $user['nom'];

          if($user['is_admin']){
            $_SESSION['Admin'] = $name; $page = "admin";
          }
          else {
            $_SESSION['Loger'] = $name; $page = "user";
          }
          header('location:pages/'.$page.'/homepage.php');

        }
        else{
          $error = 'Identifiants incorrects.';
        }
      }
      if(isset($error)){
        echo '<div>
        '.$error.'
        </div>';
      }
      else {
        $error = 'Veuillez remplir tous les champs.';
      }
    }
    ?>

  <?php include($path."/assets/views/header.php"); ?>

  <section>
    <h1>Bienvenue aux quiz de la prochaine<br>session de la Code Académie</h1>
    <div>
      <form class="formulaires" action='index.php' method='POST'>
        <input type="text" name='username' placeholder="mail"><br>
        <input type="password" name="password" placeholder="mot de passe"><br><br>
        <button>Connexion</button>
      </form>
    </div>      
      
  </section>


  <?php include($path."/assets/views/footer.php"); ?>
</body>

</html>
