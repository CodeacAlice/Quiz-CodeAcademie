<?php 
  session_start(); 
  $path = "../.."; $titlepage = "Mon compte";

  require_once $path.'/database.php';
  if(!isset($_SESSION['Admin'])){
    header('location:../deconnexion.php');
  }
  else {

  // Code pour modifier les infos
  if (isset($_POST['update']) && $_POST['update'] == 'Modifier') {
    $oldpwd = str_replace("'", "\'", $_POST['oldpwd']);
    $sth = $bdd->prepare("SELECT * FROM users WHERE idusers = '".$_SESSION['iduser']."'");
    $sth->execute();
    $result = $sth->fetch(PDO::FETCH_ASSOC);
    if ($oldpwd == $result['password']) {
      $nom = str_replace("'", "\'", $_POST['nom']);
      $prenom = str_replace("'", "\'", $_POST['prenom']);
      $newpwd = str_replace("'", "\'", $_POST['newpwd']);

      if ($newpwd == '') {
        $upd = $bdd->prepare("UPDATE users SET nom = '".$nom."', prenom = '".$prenom."' WHERE idusers = '".$_SESSION['iduser']."'");
        $upd->execute();
      }
      else {
        $upd = $bdd->prepare("UPDATE users SET nom = '".$nom."', prenom = '".$prenom."', password = '".$newpwd."' WHERE idusers = '".$_SESSION['iduser']."'");
        $upd->execute();
      }
    }
  }

  
  include($path."/assets/views/head.php"); 

  ?>


  <section>
    <h2>Mon compte</h2>
    
    <?php
      $sth = $bdd->prepare("SELECT * FROM users WHERE idusers = '".$_SESSION['iduser']."'");
      $sth->execute();
      $result = $sth->fetch(PDO::FETCH_ASSOC);
    ?>
    <p>Nom : <?= $result['nom']?></p>
    <p>Prénom : <?= $result['prenom']?></p>
    <p>Email : <?= $result['mail']?></p>

    <button data-toggle="modal" data-target="#modalModif">Modifier mes informations</button>
  </section>


  <!-- Modal pour modifier les infos -->
  <div class="modal fade" id="modalModif" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <div class="modal-title" id="exampleModalLabel"><b>Modifier mes informations</b></div>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body" id="modifInfos">
          <form action="moncompte.php" method="post">
            <p>Nom : <input type="text" name="nom" required maxlength="50" value="<?= $result['nom']?>"></p>
            <p>Prénom : <input type="text" name="prenom" required maxlength="50" value="<?= $result['prenom']?>"></p>
            <p>Ancien mot de passe (obligatoire) : <input type="password" name="oldpwd" required maxlength="100"></p>
            <p>Nouveau mot de passe (non obligatoire) : <input type="password" name="newpwd" maxlength="100"></p>
            <input type="submit" name="update" value="Modifier" class="btnface-small">
          </form>
        </div>
      </div>
    </div>
  </div>

  <?php include($path."/assets/views/footer.php"); ?>

</body>
</html>


<?php } ?>