<?php 
  session_start(); 
  $path = "../.."; $titlepage = "Accueil";

  require_once '../../database.php';
  if(!isset($_SESSION['Admin'])){
    header('location:../deconnexion.php');
  }
  else {

    include($path."/assets/views/head.php"); 
  
?>
    
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

</body>

</html>

<?php } ?>
