<?php 
  session_start(); 
  $path = "../.."; $titlepage = "Liste des utilisateurs";

  require_once $path.'/database.php';
  if(!isset($_SESSION['Admin'])){
    header('location:../deconnexion.php');
  }
  else {

    include($path."/assets/views/head.php"); 
  
?>

	<!-- Modal pour ajouter un utilisateur -->
	<div class="modal fade" id="modalAjout" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<div class="modal-title" id="exampleModalLabel"><b>Ajouter un utilisateur</b></div>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<form action="users.php" method="post">
						<p>Statut : <input type="radio" name="stat" required value="0" onclick="user()" checked> Utilisateur
							<input type="radio" name="stat" required value="1" onclick="Adm()"> Administrateur
						</p>
						<p>Nom : <input type="text" name="nom" required maxlength="50"></p>
						<p>Prénom : <input type="text" name="prenom" required maxlength="50"></p>
						<p class="userth">Genre : <input class="checker" type="radio" name="genre" required value="homme" checked> Homme
							<input class="checker" type="radio" name="genre" required value="femme"> Femme
							<input class="checker" type="radio" name="genre" required value="autre"> Autre
						</p>
						<p>Email : <input type="email" name="mail" required maxlength="50"></p>
						<p>Mot de passe : <input type="password" name="pwd" required maxlength="100"></p>
						<p class="userth">QPV : <input class="checker" type="radio" name="qpv" value="1"> Oui
							<input class="checker" type="radio" name="qpv" value="0"> Non
						</p>
						<p class="userth">RQTH : <input class="checker" type="radio" name="rqth" onclick="andi()" value="1"> Oui
							<input class="checker" type="radio" name="rqth" onclick="norqth()" value="0"> Non
						</p>
						<p class="userth">Actif : <input class="checker" type="radio" name="actif" value="1"> Oui
							<input class="checker" type="radio" name="actif" value="0"> Non
						</p>
						<p class="tiers">Requiert un tiers-temps : <input class="checker tiert" type="radio" name="tierstps" value="1"> Oui
							<input class="checker tiert" type="radio" name="tierstps" value="0"> Non
						</p>
						<input type="submit" name="add" value="Ajouter" class="btnface">
					</form>
				</div>
			</div>
		</div>
	</div>
	<?php
	// Code pour ajouter un utilisateur
	if (isset($_POST['add']) && $_POST['add'] == 'Ajouter') {

		// Requête envoyée à la table 'questions'
		$nom = str_replace("'", "\'", $_POST['nom']);
		$prenom = str_replace("'", "\'", $_POST['prenom']);
		$mail = $_POST['mail'];
		$password = $_POST['pwd'];
		$stat = $_POST['stat'];
		if($stat == 0){
			$genre = $_POST['genre'];
			$qpv = $_POST['qpv'];
			$rqth = $_POST['rqth'];
			$actif = $_POST['actif'];
			$tierstps = $_POST['tierstps'];
			$adduser = $bdd->prepare("INSERT INTO users
				(nom, prenom, genre, mail, password, QPV, RQTH, actif, tiers_temps, is_admin)
				VALUES ('".$nom."', '".$prenom."', '".$genre."', '".$mail."', '".$password."', '".$qpv."',
				'".$rqth."', '".$actif."', '".$tierstps."', '".$stat."')");
			$adduser->execute();
		}
		else{
			$adduser = $bdd->prepare("INSERT INTO users
				(nom, prenom, mail, password, is_admin)
				VALUES ('".$nom."', '".$prenom."', '".$mail."', '".$password."', '".$stat."')");
			$adduser->execute();
		}
	}
	?>





	<section>
		<h2>Liste des utilisateurs :</h2>

		<div id="listeusers">
			<?php
			// Code pour afficher tous les utilisateurs
			$sth = $bdd->prepare("SELECT * FROM users WHERE is_admin = 0 ORDER BY nom, prenom");
			$sth->execute();
			$result = $sth->fetchAll();
			if($sth->rowCount()) {
				foreach($result as $row){
					?>
					<p><?=$row['prenom']?> <span style="text-transform: uppercase;"><?=$row['nom']?></span>
						<a href="compte_user.php?user=<?=$row['idusers']?>" class="btnface-small">Voir profil</a>
						<a href="statistiques.php?user=<?=$row['idusers']?>" class="btnface-small">Statistiques</a>
					</p>
				<?php ;}
			}
			else {echo "Il n'y a pas encore d'utilisateurs.";}
			?>
		</div>
		<button style="margin-top:2rem" data-toggle="modal" data-target="#modalAjout">Ajouter un utilisateur</button>

	</section>

	<?php include($path."/assets/views/footer.php"); ?>
	

	<script src="../../assets/js/fonction.js"></script>
</body>
</html>

<?php } ?>
