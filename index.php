<?php 
session_start(); 
$path = "."; $titlepage = "Connexion";
$error = '';

require_once $path.'/database.php';

include($path."/assets/views/head.php"); 
  
?>

  <style>
    input {
      border-radius: 10px;
      padding: 10px 75px;
      text-align: center;
      background-color: #EEEEEE;
    }
    #error {
      color:red;
      font-weight:bold;
    }
  </style>


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
      else {
        $error = 'Veuillez remplir tous les champs.';
      }
    }
    ?>



  <section>
    <h1>Bienvenue aux quiz de la prochaine<br>session de la Code Académie</h1>
    <div>
      <form class="formulaires" action='index.php' method='POST'>
        <input type="text" name='username' placeholder="mail"><br>
        <input type="password" name="password" placeholder="mot de passe"><br><br>
        <button>Connexion</button>
        <div id="error"><?= $error ?></div>
      </form>
    </div>      
      
  </section>


  <?php include($path."/assets/views/footer.php"); ?>
</body>

</html>
