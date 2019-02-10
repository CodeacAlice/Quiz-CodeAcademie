<?php session_start() ?>
<!doctype html>
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

	<title>[Code Academie] Promo #3 - Liste des utilisateurs</title>	
</head>

<body>
	<?php
	require_once '../database.php';
	if(!$_SESSION['Admin']){
		header('location:../index.php');
	}
	?>

	<!-- Ajouter un utilisateur -->
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
						<p>Statut : <input type="radio" name="stat" required value="0" checked>Utilisateur   
							<input type="radio" name="stat" required value="1">Administrateur
						</p>
						<p>Nom : <input type="text" name="nom" required maxlength="50"></p>
						<p>Prénom : <input type="text" name="prenom" required maxlength="50"></p>
						<p>Genre : <input type="radio" name="genre" required value="homme" checked>Homme   
							<input type="radio" name="genre" required value="femme">Femme   
							<input type="radio" name="genre" required value="autre">Autre
						</p>
						<p>Email : <input type="email" name="mail" required maxlength="50"></p>
						<p>Mot de passe : <input type="password" name="pwd" required maxlength="100"></p>
						<p>QPV : <input type="radio" name="qpv" value="1">Oui   
							<input type="radio" name="qpv" value="0">Non
						</p>
						<p>RQTH : <input type="radio" name="rqth" value="1">Oui   
							<input type="radio" name="rqth" value="0">Non
						</p>
						<p>Actif : <input type="radio" name="actif" value="1">Oui   
							<input type="radio" name="actif" value="0">Non
						</p>
						<p>Requiert un tiers-temps : <input type="radio" name="tierstps" value="1">Oui   
							<input type="radio" name="tierstps" value="0">Non
						</p>
						<input type="submit" name="add" value="Ajouter" class="btn btn-info">
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
		$genre = $_POST['genre'];
		$mail = $_POST['mail'];
		$password = $_POST['pwd'];
		$qpv = $_POST['qpv'];
		$rqth = $_POST['rqth'];
		$actif = $_POST['actif'];
		$tierstps = $_POST['tierstps'];
		$stat = $_POST['stat'];


		$adduser = $bdd->prepare("INSERT INTO users 
			(nom, prenom, genre, mail, password, QPV, RQTH, actif, tiers_temps, is_admin) 
			VALUES ('".$nom."', '".$prenom."', '".$genre."', '".$mail."', '".$password."', '".$qpv."', 
			'".$rqth."', '".$actif."', '".$tierstps."', '".$stat."')");
		$adduser->execute();

	}
	?>


	<h2>Liste des utilisateurs :</h2>
	<a class="btn btn-info" href="homepage_admin.php">Retour à la page d'accueil</a>

	<div id="listeusers">
		<?php
		// Code pour afficher tous les tags ainsi que les questions associées
		$sth = $bdd->prepare("SELECT * FROM users WHERE is_admin = 0 ORDER BY nom, prenom");
		$sth->execute();
		$result = $sth->fetchAll();
		if($sth->rowCount()) {
			foreach($result as $row){
				?>
				<p><?=$row['prenom']?> <span style="text-transform: uppercase;"><?=$row['nom']?></span>
					<a href="compte_user.php?user=<?=$row['idusers']?>" class="btn btn-info">Voir profil</a>
				</p>
			<?php ;}
		}
		else {echo "Il n'y a pas encore d'utilisateurs.";}
		?>
	</div>
	<button class="btn btn-info" data-toggle="modal" data-target="#modalAjout">Ajouter un utilisateur</button>

	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
</body>
</html>