<?php 
session_start(); 
$path = "../.."; $titlepage = "Accueil";

require_once $path.'/database.php';
if(!isset($_SESSION['Loger'])){
  header('location:../deconnexion.php');
}
else {

  include($path."/assets/views/head.php"); 
  
?>
  <!-- CSS additionnel -->
  <link rel="stylesheet" type="text/css" href="<?= $path ?>/assets/css/homepage.css">


  
  <div class="conteneur">
    <h1>Bienvenue <?= $_SESSION['Loger']?> !</h1>
  
    <div class="container-fluid">
      <div class="row">
        <div class="liens col-sm-6">
          <a href="mesquiz.php">Mes quiz</a>
          <?php include($path."/assets/img/test-quiz.svg"); ?>
        </div>
        <div class="liens col-sm-6">
          <a href="moncompte.php">Mon compte</a>
          <?php include($path."/assets/img/user.svg"); ?>
        </div>
      </div>
    </div>
  </div>

<?php include($path."/assets/views/footer.php"); ?>

</body>
</html>
<?php } ?>
