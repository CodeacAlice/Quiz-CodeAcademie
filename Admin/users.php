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

	<title>[Code Academie] Promo #3 - Liste des questions</title>

	<script type="text/javascript">
		function modifQuest(idquest, idquiz) {
			if (idquest == 0) {
				document.getElementById("modifQuest").innerHTML = "";
				return;
			} else {
				if (window.XMLHttpRequest) {
		            // code for IE7+, Firefox, Chrome, Opera, Safari
		            xmlhttp = new XMLHttpRequest();
		        } else {
		            // code for IE6, IE5
		            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
		        }
		        xmlhttp.onreadystatechange = function() {
		        	if (this.readyState == 4 && this.status == 200) {
		        		document.getElementById("modifQuest").innerHTML = this.responseText;
		        	}
		        };
		        xmlhttp.open("GET","assets/php/modifQuest.php?que="+idquest+"&qui="+idquiz,true);
		        xmlhttp.send();
		    }
		}
	</script>

	
</head>

<body>
	<?php
	require_once '../database.php';
	if(!$_SESSION['Admin']){
		header('location:../log.php');
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
						<p>Nom : <input type="text" name="quest" required maxlength="255"></p>
						<p>Prénom : <input type="text" name="rep1" required maxlength="255"></p>
						<p>Mail : <input type="mail" name="rep2" required maxlength="255"></p>
						<p>Réponse 3 : <input type="text" name="rep3" required maxlength="255"></p>
						<p>Réponse 4 : <input type="text" name="rep4" required maxlength="255"></p>
						<p>Bonne réponse : <input type="radio" name="bonnerep" required value="1" checked>1   
							<input type="radio" name="bonnerep" required value="2">2   
							<input type="radio" name="bonnerep" required value="3">3   
							<input type="radio" name="bonnerep" required value="4">4
						</p>
						<p>Tags : 
							
						</p>
						<input type="submit" name="add" value="Ajouter" class="btn btn-info">
					</form>
				</div>
			</div>
		</div>
	</div>
	<?php
	// Code pour ajouter une question
	if (isset($_POST['add']) && $_POST['add'] == 'Ajouter') {

		// Requête envoyée à la table 'questions'
		$quest = str_replace("'", "\'", $_POST['quest']);
		$rep1 = str_replace("'", "\'", $_POST['rep1']);
		$rep2 = str_replace("'", "\'", $_POST['rep2']);
		$rep3 = str_replace("'", "\'", $_POST['rep3']);
		$rep4 = str_replace("'", "\'", $_POST['rep4']);
		$bon = str_replace("'", "\'", $_POST['rep'.$_POST['bonnerep']]);

		$searchmax = $bdd->prepare("SELECT MAX(numero) FROM questions WHERE quiz_idquiz = '".$_GET["idquiz"]."'");
		$searchmax->execute();
		$max = $searchmax->fetch();
		$num = $max['MAX(numero)']+1;

		$addquest = $bdd->prepare("INSERT INTO questions (question, reponse1, reponse2, reponse3, reponse4, 
			bonnerep, quiz_idquiz, numero) 
			VALUES ('".$quest."', '".$rep1."', '".$rep2."', '".$rep3."', '".$rep4."', 
			'".$bon."', '".$_GET["idquiz"]."', '".$num."')");
		$addquest->execute();

		// Requête envoyée à la table 'tags_has_questions'
		$tags = $_POST['tags'];
		for ($i = 0; $i < count($tags); $i++) {
			$searchid = $bdd->prepare("SELECT MAX(idquestions) FROM questions");
			$searchid->execute();
			$maxid = $searchid->fetch();
			$newid = $maxid['MAX(idquestions)'];

			$addtag = $bdd->prepare("INSERT INTO tags_has_questions (tags_idtags, questions_idquestions, questions_quiz_idquiz) 
				VALUES ('".$tags[$i]."', '".$newid."', '".$_GET["idquiz"]."')");
			$addtag->execute();
		}
	}
	?>

	<!-- Modifier une question -->
	<div class="modal fade" id="modalModif" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content" id="modifQuest">
				<div class="modal-header">
					<div class="modal-title" id="exampleModalLabel"><b>Modifier la question n°0</b></div>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<form <?php echo 'action="questions.php?idquiz='.$_GET["idquiz"].'"'; ?> method="post">
						<p style="display:none">id : <input type="text" name="id" required value="0"></p>
						<p>Question : <input type="text" name="quest" required maxlength="255"></p>
						<p>Réponse 1 : <input type="text" name="rep1" required maxlength="255"></p>
						<p>Réponse 2 : <input type="text" name="rep2" required maxlength="255"></p>
						<p>Réponse 3 : <input type="text" name="rep3" required maxlength="255"></p>
						<p>Réponse 4 : <input type="text" name="rep4" required maxlength="255"></p>
						<p>Bonne réponse : <input type="radio" name="bonnerep" required value="1" checked>1   
							<input type="radio" name="bonnerep" required value="2">2   
							<input type="radio" name="bonnerep" required value="3">3   
							<input type="radio" name="bonnerep" required value="4">4
						</p>
						<p>Tags : 

						</p>
						<input type="submit" name="update" value="Modifier" class="btn btn-info">
					</form>
				</div>
			</div>
		</div>
	</div>
	<?php
	// Code pour modifier une question
	if (isset($_POST['update']) && $_POST['update'] == 'Modifier') {

		// Requête envoyée à la table 'questions'
		$id = $_POST['id'];
		$quest = str_replace("'", "\'", $_POST['quest']);
		$rep1 = str_replace("'", "\'", $_POST['rep1']);
		$rep2 = str_replace("'", "\'", $_POST['rep2']);
		$rep3 = str_replace("'", "\'", $_POST['rep3']);
		$rep4 = str_replace("'", "\'", $_POST['rep4']);
		$bon = str_replace("'", "\'", $_POST['rep'.$_POST['bonnerep']]);

		$upquest = $bdd->prepare("UPDATE questions 
			SET question = '".$quest."', reponse1 = '".$rep1."', reponse2 = '".$rep2."', reponse3 = '".$rep3."', reponse4 = '".$rep4."', bonnerep = '".$bon."'
			WHERE idquestions = '".$id."';");
		$upquest->execute();

		// Requêtes envoyées à la table 'tags_has_questions'
		$tagschecked = $_POST['tags'];
		$searchtags = $bdd->prepare("SELECT * FROM tags");
		$searchtags->execute();
		$restags = $searchtags->fetchAll();
		if($searchtags->rowCount()) {
			foreach($restags as $atag){
				$ithasthetag = $bdd->prepare("SELECT * FROM tags_has_questions 
					WHERE tags_idtags = '".$atag['idtags']."' AND questions_idquestions = '".$id."' ");
				$ithasthetag->execute();
				if ($ithasthetag->rowCount()) {
					if (!in_array($atag['idtags'], $tagschecked)) {
						$delete = $bdd->prepare("DELETE FROM tags_has_questions 
							WHERE tags_idtags = '".$atag['idtags']."' AND questions_idquestions = '".$id."' ");
						$delete->execute();
					}
				}
				else {
					if (in_array($atag['idtags'], $tagschecked)) {
						$insert = $bdd->prepare("INSERT INTO tags_has_questions (tags_idtags, questions_idquestions, questions_quiz_idquiz) 
							VALUES ('".$atag['idtags']."', '".$id."', '".$_GET["idquiz"]."')");
						$insert->execute();
					}
				}
			}
		}
	}
	?>


	<h2>Liste des utilisateurs :</h2>
	<a class="btn btn-info" href="index.php">Retour à la page d'accueil</a>

	<div id="listeusers">
		<?php
		// Code pour afficher tous les tags ainsi que les questions associées
		$sth = $bdd->prepare("SELECT * FROM users ORDER BY nom, prenom");
		$sth->execute();
		$result = $sth->fetchAll();
		if($sth->rowCount()) {
			foreach($result as $row){
				echo $row['prenom'].' '.$row['nom'].'<br>';
			}
		}
		else {echo "Ce quiz n'a pas encore de question.";}
		?>



	</div>
	<button class="btn btn-info" data-toggle="modal" data-target="#modalAjout">Ajouter une question</button>

	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
</body>
</html>