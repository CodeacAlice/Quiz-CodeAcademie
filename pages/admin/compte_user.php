<?php 
session_start(); 
$path = "../.."; $titlepage = "Compte utilisateur";

require_once $path.'/database.php';
if(!isset($_SESSION['Admin'])){
  header('location:../deconnexion.php');
}
else {

  include($path."/assets/views/head.php"); 
  
?>


  <?php
  // Code pour afficher les informations et remplir la modal de modification
    $sth = $bdd->prepare("SELECT * FROM users WHERE idusers = '".$_GET['user']."'");
    $sth->execute();
    $result = $sth->fetch(PDO::FETCH_ASSOC);
    if ($result['QPV'] == 1) {
      $qpv = 'Oui';
      $inputqpv = '<input type="radio" name="qpv" value="1" checked>Oui   <input type="radio" name="qpv" value="0">Non';
    } 
    else {
      $qpv = 'Non';
      $inputqpv = '<input type="radio" name="qpv" value="1">Oui   <input type="radio" name="qpv" value="0" checked>Non';
    }
    if ($result['RQTH'] == 1) {
      $rqth = 'Oui';
      $inputrqth = '<input type="radio" name="rqth" value="1" checked>Oui   <input type="radio" name="rqth" value="0">Non';
    } 
    else {
      $rqth = 'Non';
      $inputrqth = '<input type="radio" name="rqth" value="1">Oui   <input type="radio" name="rqth" value="0" checked>Non';
    }
    if ($result['actif'] == 1) {
      $actif = 'Oui';
      $inputactif = '<input type="radio" name="actif" value="1" checked>Oui   <input type="radio" name="actif" value="0">Non';
    } 
    else {
      $actif = 'Non';
      $inputactif = '<input type="radio" name="actif" value="1">Oui   <input type="radio" name="actif" value="0" checked>Non';
    }
    if ($result['tiers_temps'] == 1) {
      $tierst = 'Oui';
      $inputtiers = '<input type="radio" name="tierstps" value="1" checked>Oui   <input type="radio" name="tierstps" value="0">Non';
    } 
    else {
      $tierst = 'Non';
      $inputtiers = '<input type="radio" name="tierstps" value="1">Oui   <input type="radio" name="tierstps" value="0" checked>Non';
    }

    if ($result['genre'] == 'homme') {
      $inputgenre = '<input type="radio" name="genre" required value="homme" checked>Homme   <input type="radio" name="genre" required value="femme">Femme   <input type="radio" name="genre" required value="autre">Autre';
    }
    else if ($result['genre'] == 'femme') {
      $inputgenre = '<input type="radio" name="genre" required value="homme">Homme   <input type="radio" name="genre" required value="femme" checked>Femme   <input type="radio" name="genre" required value="autre">Autre';
    }
    else {
      $inputgenre = '<input type="radio" name="genre" required value="homme">Homme   <input type="radio" name="genre" required value="femme">Femme   <input type="radio" name="genre" required value="autre" checked>Autre';
    }
  ?>

  <section>
    <h2>Informations de l'utilisateur <?= $result['prenom']?> <?= $result['nom']?></h2>
    
    <p>Nom : <?= $result['nom']?></p>
    <p>Prénom : <?= $result['prenom']?></p>
    <p>Genre : <?= ucfirst($result['genre'])?></p>
    <p>Email : <?= $result['mail']?></p>
    <p>QPV : <?= $qpv?></p>
    <p>RQTH : <?= $rqth?></p>
    <p>Actif : <?= $actif?></p>
    <p>Tiers-temps : <?= $tierst?></p>

    <div style="margin-top:2rem">
      <a href="users.php" class="btnface">Retour à la liste</a>
    </div>
  </section>

  <?php include($path."/assets/views/footer.php"); ?>

</body>
</html>

<?php } ?>
